#!/bin/lua
local luasql = require "luasql.postgres"
local env = assert (luasql.postgres())

-- Configuration Table
local conf = {
  -- Postgres configs
  db        = 'meconsultedb',
  user      = 'dbauser',
  password  = '<password>',
  host      = "127.0.0.1",
  port      = 5432,
  -- PHP config
  baseParentClassName = 'MyActiveRecord',
  translateFile       = nil, -- To do
}

local con = assert (env:connect(conf.db, conf.user, conf.password, conf.host, conf.port))

-- table that map type-to-validator
local validators = {
  ['date'] = {
    name = 'ext.validators.ClientDateValidator'
  },
  ['smallint, integer, bigint'] = {
    name = 'numerical',
    opts = {integerOnly = true}
  },
  ['real, double precision, numeric'] = {
    name = 'ext.validators.CLocaleNumberValidator',
    opts = {integerOnly = false}
  },
  ['character, character varying'] = {
    name = 'length',
    opts = {
      max = function(dbType) return '1' end,
      min = function(dbType) return '2' end
    }
  },
  ['text'] = {
    name = 'safe'
  }
}

-- Useful vars

tableName = arg[1] or "meconsulte_messages"
tableNameCondition = "table_name ='" .. tableName .. "'"
tableCatalog = 'meconsultedb'
tableSchema = 'protected'
tableSchemaAndCatalogCondition = "table_catalog ='" .. tableCatalog .. "' AND table_schema = '" .. tableSchema .. "'"

translateFileName = arg[2]

cursor, errorString = con:execute("SELECT * FROM information_schema.columns WHERE " .. tableSchemaAndCatalogCondition .. " AND " .. tableNameCondition .. " ORDER BY table_name, ordinal_position")

psqlTables = {}

row = cursor:fetch ({}, "a")

while row do
	if psqlTables[row.table_name] == nil then
		psqlTables[row.table_name] = {}
	end

	table.insert(psqlTables[row.table_name], {
		columnName = row.column_name,
		dataType = row.data_type ~= 'USER-DEFINED' and row.data_type or row.udt_name

	})
	
	-- reusing the table of results
	row = cursor:fetch (row, "a")
end

function getEnumValues(enumName) -- returns a string
  local cursor, errorString =  con:execute('SELECT e.enumlabel FROM pg_enum e JOIN pg_type t ON e.enumtypid = t.oid  WHERE t.typname =\''..enumName.."';")  
  local row = cursor:fetch ({}, "a")

  if not row then return nil end

  local range = '['
  while row do
    if range ~= '[' then
      range = range .. ', '
    end
    range = range .. "'"..row.enumlabel.."'"
    row = cursor:fetch (row, "a")
  end

  return range..']'
end

function getTranslateFileName( )
  return translateFileName
end

function headerColumnList (psqlTable)
  local result = ""

  for index, column in pairs(psqlTable) do
    result = result .. " * " .. column.columnName .. "\n"
  end

  return string.sub(result, 0, -2)
end

function headerRelationList (psqlTable)
  return "headerRelationList"
end

-- returns the CamelCased version of tableName
function underscoreToCamelCase (tableName)
  local head = string.sub(tableName, 1, 1)
  head = string.upper(head)

  local tail = string.sub(tableName, 2)
  tail = string.gsub(tail, "(_.)", function (w) return string.upper(string.sub(w, 2)) end)

  return head .. tail
end

function className (tableName)
  return underscoreToCamelCase(tableName)
end

function baseParentClassName ()
  return conf.baseParentClassName
end

function schemaPrefixAndTableName (psqlTable)
  return "schemaPrefixAndTableName"
end

function rules (psqlTable)
  local result = ""
  local tp_columns = {}
  -- Group attr by types.
  for index, column in pairs(psqlTable) do
    local dbType = column.dataType
    if tp_columns[dbType] == nil then
      tp_columns[dbType] = {}
    end
    table.insert(tp_columns[dbType], column.columnName)
  end

  for dbType, attrs in pairs(tp_columns) do
    print(dbType)
    local validator = nil
    -- find validator (expensive in complexity, but small list)
    for tp, vl in pairs(validators) do
      if string.match(tp, dbType) then
        validator = vl
        break
      end
    end
    if validator == nil then  -- Try enum
      local range = getEnumValues(dbType)
      if range then -- Is enum
        validator = {
          name = 'in',
          opts = {
            ['range'] = range
          }
      }
      else
        validator = {name = 'safe'}
      end
    end
    -- use validator
    result = result .."            ['"..table.concat(attrs, ', ').."'"
    result = result.. ", '"..validator.name.."'"
    if validator.opts ~= nil then
      for opt, val in pairs(validator.opts) do
        result = result..", '"..opt.."' => "
        local valType = type(val)
        if valType == 'function' then
          val = val(dbType)
          result = result..tostring(val)
        elseif opt == 'range' then
          result = result..val
        elseif valType == 'string' then
          result = result.."'"..tostring(val).."'"
        else 
          result = result..tostring(val)
        end
        
      end
    end
    result = result..'],\n'    
  end 

  return result
end

function relations (psqlTable)
  return "relations"
end

function labels (psqlTable, translateFileName)
  local result = ""

  for index, column in pairs(psqlTable) do
    result = result .. "            '" .. column.columnName .. "' => " 
    if translateFileName == nil then
      result = result .. "'" .. string.gsub(column.columnName, "_", " ") .. "',\n"
    else
      result = result .. "Yii::t('" .. translateFileName .. "', '" .. string.gsub(column.columnName, "_", " ") .. "'),\n"
    end
  end
  return string.sub(result, 0, -2) -- remove newline
end

function generateTableModel (tableName, psqlTable)
  local templateFile = io.open("template.php", "r")
  local template = templateFile:read("*all")
  io.close(templateFile)

  template = string.gsub(template, "__SCHEMAPREFIXANDTABLENAME__", schemaPrefixAndTableName(psqlTable))
  template = string.gsub(template, "__HEADERCOLUMNLIST__", headerColumnList(psqlTable))
  template = string.gsub(template, "__HEADERRELATIONLIST__", headerRelationList(psqlTable))
  template = string.gsub(template, "__CLASSNAME__", className(tableName))
  template = string.gsub(template, "__BASEPARENTCLASSNAME__", baseParentClassName())
  template = string.gsub(template, "__RULES__", rules(psqlTable))
  template = string.gsub(template, "__RELATIONS__", relations(psqlTable))
  template = string.gsub(template, "__LABELS__", labels(psqlTable, getTranslateFileName()))

  local modelFile = io.open(className(tableName) .. ".php", "w")
  modelFile:write(template)
  io.close(modelFile)

  print(template)
  print(className(tableName) .. ".php generated successfully")
end

for tableName, psqlTable in pairs(psqlTables) do
  if tableName == tableName then
    generateTableModel(tableName, psqlTable)
  end
end --todo for/else if table not found
