import requests
import json
#Set Cisco Spark headers
def setHeaders(token):
    accessToken_hdr = 'Bearer ' + token
    spark_header = {'Authorization': accessToken_hdr, 'Content-Type': 'application/json; charset=utf-8'}
    return spark_header
# Get an specific message from Cisco Spark
def SparkGET(uri, theHeader):
    resp = requests.get(uri, headers=theHeader)
    return resp.json()
# Post messages to Cisco Spark
def SparkPOST(theHeader, uri, payload):
    resp = requests.post(uri, data=json.dumps(payload), headers=theHeader)
    return resp
# Get list of rooms from an specific account
def getRooms(theHeader):
    uri = 'https://api.ciscospark.com/v1/rooms'
    resp = requests.get(uri, headers=theHeader)
    return resp.json()
# Search for an specific room name
def findRoom(roomList, name):
    roomId = 0
    for room in roomList["items"]:
        if room["title"] == name:
            roomId = room["id"]
            break
    return roomId