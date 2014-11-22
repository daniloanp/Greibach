luasql = require "luasql.postgres"
env = assert (luasql.postgres())
con = assert (env:connect('meconsultedb', 'dbauser', '<password>', "127.0.0.1", 5432))

tableName = arg[1] or "meconsulte_messages"
tableNameCondition = "table_name ='" .. tableName .. "'"
tableCatalog = 'meconsultedb'
tableSchema = 'protected'
tableSchemaAndCatalogCondition = "table_catalog ='" .. tableCatalog .. "' AND table_schema = '" .. tableSchema .. "'"

cursor, errorString = con:execute("SELECT * FROM information_schema.columns WHERE " .. tableSchemaAndCatalogCondition .. " AND " .. tableNameCondition .. " ORDER BY table_name, ordinal_position")

psqlTables = {}

row = cursor:fetch ({}, "a")

while row do
	if psqlTables[row.table_name] == nil then
		psqlTables[row.table_name] = {}
	end

	table.insert(psqlTables[row.table_name], {
		columnName = row.column_name,
		dataType = row.data_type
	})
	
	-- reusing the table of results
	row = cursor:fetch (row, "a")
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
  return "MyActiveRecord"
end

function schemaPrefixAndTableName (psqlTable)
  return "schemaPrefixAndTableName"
end

function rules (psqlTable)
  return "rules"
end

function relations (psqlTable)
  return "relations"
end

function labels (psqlTable)
  local result = ""

  for index, column in pairs(psqlTable) do
    result = result .. "            '" .. column.columnName .. "' => '" .. string.gsub(column.columnName, "_", " ") .. "'\n"
  end

  return string.sub(result, 0, -2)
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
  template = string.gsub(template, "__LABELS__", labels(psqlTable))

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