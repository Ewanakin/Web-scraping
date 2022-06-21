from typing import List
import mysql.connector

import requests
from bs4 import BeautifulSoup
class Scraper:
    def __init__(self, search, id_search, link, id_link):
        self.search = search
        self.id_search = id_search
        self.link = link
        self.id_link = id_link


    def getSearch(self):
        return self.search
    def getLink(self):
        return self.link


    def pageContent(self, config):
        page = requests.get(self.link, headers={'user-agent': 'Mozilla/5.0 (X11; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0','connection': 'keep-alive'}).content
        soup = BeautifulSoup(page, "html.parser")
        cnx = mysql.connector.connect(**config)
        cursor = cnx.cursor()
        add_content = ("INSERT INTO content "
                        "(fk_id_link_id, content)"
                        "VALUES (%s, %s)")
        for content in soup.find_all('p'):
            data_content = (self.id_link, content.text)
            cursor.execute(add_content, data_content)
            cnx.commit()
        cursor.close()
        cnx.close()

    def pageImage(self, config):
        page = requests.get(self.link, headers={'user-agent': 'Mozilla/5.0 (X11; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0','connection': 'keep-alive'}).content
        soup = BeautifulSoup(page, "html.parser")
        cnx = mysql.connector.connect(**config)
        cursor = cnx.cursor()
        add_content = ("INSERT INTO image "
                       "(fk_link_id, link) "
                       "VALUES (%s, %s)")
        for content in soup.find_all('img'):
            if content.get("src") != None:
                data_content = (self.id_link, content.get("src"))
                cursor.execute(add_content, data_content)
                cnx.commit()
        cursor.close()
        cnx.close()






