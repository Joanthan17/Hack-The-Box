#!/usr/bin/python3

import requests
import sys
import re
from bs4 import BeautifulSoup

url = "http://10.10.10.93/transfer.aspx"
filename = "extensions.txt"

def upload(f):
    s = requests.Session()
    r = s.get(url)
    #if r.status_code == 200:
    #    print("[INFO] Checking...{0}".format(f))
    #else:
    #    print("[ERROR] Can't connect...")
    #    sys.exit(1)
    
    p = BeautifulSoup(r.content, "html.parser")
    viewState = p.find(attrs = {'name' : '__VIEWSTATE'})['value']
    eventValidation = p.find(attrs = {'name' : '__EVENTVALIDATION'})['value']
    postData = {
            '__VIEWSTATE' : viewState,
            '__EVENTVALIDATION' : eventValidation,
            'btnUpload' : 'Upload'
            }
    
    uploadedFile = {'FileUpload1' : (f, 'test')}
    r = s.post(url, files=uploadedFile, data=postData)
    return r.text


print("[INFO] Allowed Extensions:")
for i in open(filename, 'r'):
    #print(i[:-1])
    response = upload('bigb0ss.' + i[:-1])
    if "successfully" in response:
        print("[+] %s" % i.strip())
