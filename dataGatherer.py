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


# Set pre and post indexes to get the total count of cases
totalCountPreIndex = 'div class="maincounter-number"> <span style="color:#aaa">'
totalCountPostIndex = ' </span>'

# Use our function to display
print("Getting Total Count")
totalCount = getData(totalCountPreIndex, totalCountPostIndex, str(contents))
totalCount = totalCount.replace(",","")

# Set pre and post indexes to get the death count
deathCountPreIndex = 'div class="maincounter-number"> <span>'
deathCountPostIndex = '</span>'

# Use our function to display
print("Getting Death Count")
deathCount = getData(deathCountPreIndex, deathCountPostIndex, str(contents))
deathCount = deathCount.replace(",","")

# Set pre and post indexes to get the recovered count
recoveredCountPreIndex = '<div class="maincounter-number" style="color:#8ACA2B "> <span>'
recoveredCountPostIndex = '</span>'

# Use our function to display
print("Getting Recovered Count")
recoveredCount = getData(recoveredCountPreIndex, recoveredCountPostIndex, str(contents))
recoveredCount = recoveredCount.replace(",","")

# Set pre and post indexes to get the recovered count
activeInfectedPreIndex = '<div class="number-table-main">'
activeInfectedPostIndex = '</div>'

# Use our function to display
print("Getting Active Infection Cases")
activeInfectedTotal = getData(activeInfectedPreIndex, activeInfectedPostIndex, str(contents))
activeInfectedTotal = activeInfectedTotal.replace(",","")

# Set pre and post index to get the mild condition count
mildConditionPreIndex = '<span class="number-table" style="color:#8080FF">'
mildConditionPostIndex = '</span>'

# Use our function to display
print("Getting Amount of Mild Cases")
mildConditionCount = getData(mildConditionPreIndex, mildConditionPostIndex, str(contents))
mildConditionCount = mildConditionCount.replace(",","")

# Set pre and post index to get the mild condition count
criticalConditionPreIndex = '<span class="number-table" style="color:red ">'
criticalConditionPostIndex = '</span>'

# Use our function to display
print("Getting Amount of Critical Cases")
criticalConditionCount = getData(criticalConditionPreIndex, criticalConditionPostIndex, str(contents))
criticalConditionCount = criticalConditionCount.replace(",","")

# Get the data from the countries table
tableDataPreIndex = '<tbody>'
tableDataPostIndex = '</tbody>'

# Use our functions get refine our data
print("Getting table data")
tableData = getData(tableDataPreIndex, totalCountPostIndex, str(contents))

# Replace any missing values with ???
tableData = tableData.replace('<td style="font-weight: bold; text-align:right;"> </td>', "???\n")
tableData = tableData.replace('<td style="font-weight: bold; text-align:right"> </td>', "???\n")
tableData = tableData.replace('<td style="font-weight: bold; text-align:right"></td>', "???\n")

# Use function to clean html
print("Cleaning HTML")
refinedTable = refineHtml(tableData)

# List layout for each countries
# Country Name, Total Cases, New Cases, Total Deaths, New Deaths, Total Recovered, Active Cases, Serious Cases, tot
res = []
decodedString = unidecode.unidecode(refinedTable)
tableResults = decodedString.split('\n')
index = 0
while index < len(tableResults):
    y = 0
    temp = []
    while y <= 8 and index < len(tableResults):
        temp.append(tableResults[index])
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
