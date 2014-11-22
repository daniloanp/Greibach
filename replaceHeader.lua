src = arg[1]
dst = arg[2]

local srcFile = io.open(src, "r")
local srcCode = srcFile:read("*all")
io.close(srcFile)

local dstFile = io.open(dst, "r")
local dstCode = dstFile:read("*all")
io.close(dstFile)

function extractHeader (code)
	local header = string.sub(code, 1, string.find(code, "\nclass") - 1)
	assert(string.sub(header, #header - 1, #header) == "*/")
	return header
end

local srcHeader = extractHeader(srcCode)
local dstHeader = extractHeader(dstCode)

-- print(srcHeader)
local dstHeaderI, dstHeaderJ = string.find(dstCode, dstHeader)
print(dstHeaderI)
-- local replacedDstCode = string.sub(dstCode, dstHeader, srcHeader)
-- print(replacedDstCode)
-- print(string.sub(dstCode, dstHeader, "lala"))
-- print(srcHeader)