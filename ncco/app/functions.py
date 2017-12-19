import uuid
import nexmo
from pymongo import MongoClient




def dbcompare(client, service, callid):
    if service == "token":
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
    elif service == "call":
        try:
            c = MongoClient("mongodb://aalarms:Inf0m3d142017$@mongo/aalarms")
            document = [x for x in c.aalarms.callsnexmo.find({"uuid": callid})]
            if document != []:
                return  {"number":document[len(document)-1]["anumber"], "client":document[len(document)-1]["client"]}
            else:
                return 0
        except:
            return 3




def dbauth(apikey, postdata):
    try:
        c = MongoClient("mongodb://aalarms:Inf0m3d142017$@mongo/aalarms")
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
        PRIVATE_KEY = open("/app/private.key", 'r').read()
        client = nexmo.Client(application_id="f0a90063-6f55-4524-991a-0f3b7f51ed94", key=nexmo_key,
                                          secret=nexmo_secret, private_key=PRIVATE_KEY)
        response = client.create_call({
                    "to": [{"type": "phone", "number": "{0}".format(postdata["number"])}],
                    "from": {"type": "phone", 'number': "123456789"},
                    "answer_url": ["http://msg-bot-abacox.infomediaservice.com:5003/ncco?client={0}".format(postdata["client"])]
                    })
        return response
    except:
        return 3

#Global variables

nexmo_key = ""
nexmo_secret = ""
