import uuid
import nexmo
from pymongo import MongoClient
from sparkcalls import setHeaders,  SparkPOST

def cshealth():
    try:
        header = setHeaders(tokenbot)
        return SparkPOST(header, "https://api.ciscospark.com/v1/messages", {"roomId": idroomtest, "text": ""})
    except:
        return "Error"

def dbcompare(client, service, callid):
    if service == "token":
        try:
            c = MongoClient("MONGO STRING")
            document = [x for x in c.aalarms.apikeys.find({"cliente":client})]
            if document != []:
                key = uuid.uuid4().hex
                c.aalarms.apikeys.update_one({"cliente": client}, {"$set": {"key": key}}, upsert=False)
                return key
            else:
                return 0
        except:
            return "Failed to add/update"
    elif service == "call":
        try:
            c = MongoClient("MONGO STRING")
            document = [x for x in c.aalarms.callsnexmo.find({"uuid": callid})]
            if document != []:
                return  {"number":document[len(document)-1]["anumber"], "client":document[len(document)-1]["client"]}
            else:
                return 0
        except:
            return 3


def dbwrite(client, data, service):
    if service == "token":
        try:
            token = uuid.uuid4().hex
            c = MongoClient("MONGO STRING")
            c.aalarms.apikeys.insert_one({"cliente":client,"key":token})
            return "OK", token
        except:
            return "Failed to add/update", 0
    elif service == "call":
        try:
            c = MongoClient("MONGO STRING")
            c.aalarms.callsnexmo.insert_one({"client": client, "uuid": data["uuid"], "status":data["status"], "anumber":data["anumber"]})
            return 1
        except:
            return "Failed to add/update"

def dbauth(apikey, postdata):
    try:
        c = MongoClient("MONGO STRING")
        document = [x for x in c.aalarms.apikeys.find({"cliente": postdata["client"]})]

        if document != []:
            if document[0]["key"] == apikey:
                return 1
            else:
                return 0
        else:
            return "Client dosent exist"
    except:
        return "Failed to auth/communicate with database"

def nexmocall(postdata):
    try:
        PRIVATE_KEY = open("private.key", 'r').read()
        client = nexmo.Client(application_id="APP ID", key=nexmo_key,
                                          secret=nexmo_secret, private_key=PRIVATE_KEY)
        response = client.create_call({
                    "to": [{"type": "phone", "number": "{0}".format(postdata["number"])}],
                    "from": {"type": "phone", 'number': "123456789"},
                    "answer_url": ["http://NCCO-STORE".format(postdata["client"])]
                    })
        return response
    except:
        return 3

#Global variables
tokenbot = "BOT TOKEN"
idroomtest = "TEST ROOM ID"
nexmo_key = "NEXMO KEY"
nexmo_secret = "NEXMO SECRET"
