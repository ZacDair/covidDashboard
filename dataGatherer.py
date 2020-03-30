from urllib.request import Request, urlopen
from bs4 import BeautifulSoup
import pymysql
import unidecode

# Data Source Url
url = 'https://www.worldometers.info/coronavirus/'

# Create a request using the url and our headers
headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.3'}
req = Request(url=url, headers=headers)

# Open our url and read the contents into a variable
contents = urlopen(req).read()


# Function to get data based on pre-index and post-index
def getData(preIndex, postIndex, data):
    data = data.split(preIndex)
    data = data[1].split(postIndex)
    return data[0]


# Remove all html and script code from a string
def refineHtml(data):
    soup = BeautifulSoup(data, features="html.parser")

    # kill all script and style elements
    for script in soup(["script", "style"]):
        script.extract()  # rip it out

    # get text
    text = soup.get_text()

    # break into lines and remove leading and trailing space on each
    lines = (line.strip() for line in text.splitlines())
    # break multi-headlines into a line each
    chunks = (phrase.strip() for line in lines for phrase in line.split("  "))
    # drop blank lines
    text = '\n'.join(chunk for chunk in chunks if chunk)
    return text

# print("Source Code is:")
# print(contents)


code = refineHtml(contents)
codeLines = code.split("\n")

# Line 8 index 7 is total cases
totalCount = codeLines[7]
# Line 11 index 10 is death count
deathCount = codeLines[10]
# Line 13 index 12 is recovered count
recoveredCount = codeLines[12]
# Line 15 index 14 is active case total
activeInfectedTotal = codeLines[14]
# Line 17 index 16 is mild infections - the percentage
mildConditionCount = codeLines[16]
# line 19 index 18 is critical -the percentage
criticalConditionCount = codeLines[18]

print(totalCount)
print(deathCount)
print(recoveredCount)
print(activeInfectedTotal)
print(mildConditionCount)
print(criticalConditionCount)

totalCountPostIndex = ' </span>'

# Get the data from the countries table
tableDataPreIndex = '<tbody>'
tableDataPostIndex = '</tbody>'

# Use our functions get refine our data
tableData = getData(tableDataPreIndex, totalCountPostIndex, str(contents))

# Replace any missing values with ???
tableData = tableData.replace('<td style="font-weight: bold; text-align:right;"> </td>', "???")
tableData = tableData.replace('<td style="font-weight: bold; text-align:right"> </td>', "???")
tableData = tableData.replace('<td style="font-weight: bold; text-align:right"></td>', "???")
tableData = tableData.replace('<td style="font-weight: bold; text-align:right;"></td>', "???")
tableData = tableData.replace('<td style="font-weight: bold; text-align:right;">                                </td>', "???")
tableData = tableData.replace('<td style="font-weight: bold; text-align:right;">  </td>', "???")
print(tableData)
tableData = tableData.replace("\\n\\n", "")
tableData = tableData.replace("\\n", "~")

# Use function to clean html
refinedTable = refineHtml(tableData)
decodedString = unidecode.unidecode(refinedTable)

# List layout for each countries
# Country Name, Total Cases, New Cases, Total Deaths, New Deaths, Total Recovered, Active Cases, Serious Cases, tot
res = []
temp1 = []
tableResults = decodedString.split('~')
for x in tableResults:
    x = x.replace('\\n', '')
    if x != '' and x != " ":
        temp1.append(x)
index = 0
while index < len(temp1):
    y = 0
    temp = []
    while y <= 10 and index < len(temp1):
        temp.append(temp1[index])
        index = index + 1
        y = y + 1
    res.append(temp)

print("Country list stored")

# Upload data to database tables
con = pymysql.connect('localhost', 'root', 'root', 'covidDB')
cur = con.cursor()
cur.execute("insert into generalData(totalCount, deathCount, recoveredCount, activeInfectedCount, mildCaseCount, criticalCaseCount) values(%s, %s, %s, %s, %s, %s);",(int(totalCount), int(deathCount), int(recoveredCount), int(activeInfectedTotal), int(mildConditionCount), int(criticalConditionCount)))
con.commit()
for x in res:
    cur.execute("insert into countryData(countryName, totalCases, newCases, totalDeaths, newDeaths, totalRecovered, activeCases, seriousCases, tot) values (%s, %s, %s, %s, %s, %s, %s, %s, %s);",(x[0],x[1],x[2],x[3],x[4],x[5],x[6],x[7],x[8]))
    con.commit()
