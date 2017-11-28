import uuid
from pymongo import MongoClient
from sparkcalls import setHeaders,  SparkPOST

def cshealth():
    try:
        header = setHeaders(tokenbot)
        return SparkPOST(header, "https://api.ciscospark.com/v1/messages", {"roomId": idroomtest, "text": ""})
    except:
        return "Error"

def dbcompare(client):
    try:
        c = MongoClient("mongodb://aalarms:Inf0m3d142017$@mongo/aalarms")
        document = [x for x in c.aalarms.apikeys.find({"cliente":client})]
        if document != []:
            key = uuid.uuid4().hex
            c.aalarms.apikeys.update_one({"cliente": client}, {"$set": {"key": key}}, upsert=False)
            return key
        else:
            return 0
    except:
        return "Failed to add/update"

def dbwrite(client):
    try:
        token = uuid.uuid4().hex
        c = MongoClient("mongodb://aalarms:Inf0m3d142017$@mongo/aalarms")
        c.aalarms.apikeys.insert_one({"cliente":client,"key":token})
        return "OK", token
    except:
        return "Failed to add/update", 0

def dbauth(apikey, postdata):
    try:
        c = MongoClient("mongodb://aalarms:Inf0m3d142017$@mongo/aalarms")
        document = [x for x in c.aalarms.apikeys.find({"cliente": postdata["client"]})]
        if document != []:
            if document[0]["key"] == apikey:
                if postdata["tokenCS"] != "":
                    SparkPOST(setHeaders(postdata["tokenCS"]), "https://api.ciscospark.com/v1/messages",
                          {"roomId": postdata["room"], "text": postdata["message"]})
                else:
                    SparkPOST(setHeaders(tokenbot), "https://api.ciscospark.com/v1/messages",
                              {"roomId": postdata["room"], "text": postdata["message"]})
                return 1
            else:
                return 0
        else:
            return "Client dosen´t exist"
    except:
        return "Failed to auth/communicate with database"


#Global variables
tokenbot = "NDU2NmZlMmQtNTM2Mi00ZDkyLWIyNjItNzE5YmJiNjc4MGI3YjZlODRmNjAtMzQy"
idroomtest = "Y2lzY29zcGFyazovL3VzL1JPT00vODFhZTFkODAtY2JhYS0xMWU3LThlYTgtYmY3ZTBhNTQwOWIx"
