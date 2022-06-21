from Scraper import Scraper
from datetime import datetime
import mysql.connector
from bs4 import BeautifulSoup
import requests

def collectLinkPage(search, lastDate, dateNow):
    page = requests.get("https://www.google.fr/search?q=" + search + "&source=lnt&tbs=cdr%3A1%2Ccd_min%3A" + lastDate[1] + "%2F" +
                        lastDate[2] + "%2F" + lastDate[0] + "%2Ccd_max%3A" + dateNow[1] + "%2F" + dateNow[2] + "%2F" + dateNow[0] + "&tbm=",
                        headers={'user-agent': 'Mozilla/5.0 (X11; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0','connection': 'keep-alive'}).content
    soup = BeautifulSoup(page, "html.parser")
    for linkPage in soup.find_all("div", attrs={"class": "g"}):
        link.append(linkPage.find_next("a").get("href"))

# récupération de la date actuelle
enrgDate = datetime.now()
dateNow = enrgDate.date().isoformat().split("-")
# dateFile = open("lastDate.txt", "w")
# dateFile.write(dateNow)
# dateFile.close()

# lecture de la date
lastDate = open("lastDate.txt", "r")
latestDate = lastDate.read().split('-')
lastDate.close()


with open("link.csv", "r") as search:
    for line in search:
        url = line.split(";")

connection_params = {
    'host': "",
    'user': "",
    'password': "",
    'database': "",
}


for search in url:
    link = []
    search = search.strip("\n")
    collectLinkPage(search, latestDate, dateNow)

    cnx = mysql.connector.connect(**connection_params)
    cursor = cnx.cursor()
    ####################################################################################################################
    cursor.execute("SELECT * FROM search WHERE search = '"+search+"'")
    if cursor.fetchall():
        cursor.execute("SELECT id FROM search WHERE search = '"+search+"'")
        result = cursor.fetchone()
    else:
        cursor.execute("INSERT INTO search(search) VALUES('"+search+"')")
        cnx.commit()
        cursor.execute("SELECT id FROM search WHERE search = '"+search+"'")
        result = cursor.fetchone()
    for id_search in result:
        idSearch = id_search
    ####################################################################################################################
    print(link)
    for line in link:
        idLink = None
        cursor.execute("SELECT * FROM link WHERE link = '" + line + "'")
        if cursor.fetchall():
            print("la ligne "+ line +" existe déjà ! ")
        else:
            req = ("INSERT INTO link(fk_id_search_id, link)"
                   "VALUES(%s,%s)")
            data = (idSearch, line)
            cursor.execute(req, data)
            cnx.commit()
            cursor.execute("SELECT id FROM link WHERE link = '" + line + "'")
            result = cursor.fetchone()
            for id_link in result:
                idLink = id_link
        searchObject = Scraper(search, idSearch, line, idLink)
        if idLink != None:
            searchObject.pageContent(connection_params)
            searchObject.pageImage(connection_params)