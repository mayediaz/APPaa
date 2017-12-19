import json
import nexmo
from sparkcalls import setHeaders, getRooms, SparkPOST
from functions import cshealth, dbcompare, dbwrite, dbauth, nexmocall
from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route("/v1/tc", methods=['GET'])
def tokencreate():
    client = request.args.get("client")
    dbresp = dbcompare(client, "token", "")
    if dbresp != 0:
        return jsonify({"token": dbresp, "client": client})
    else:
        #Token creation
        dbresp, token = dbwrite(client, "", "token")
        if dbresp == "OK":
            return jsonify({"token":token, "client":client})
        else:
            return jsonify({"error":dbresp})


@app.route("/v1/cs", methods=['POST'])
def csalarms():
    try:
        postdata = json.loads(request.data)
        dbresp = dbauth(request.headers.get("Authorization"), postdata)
        if dbresp == 1:
            if postdata["tokenCS"] != "":
                resp = SparkPOST(setHeaders(postdata["tokenCS"]), "https://api.ciscospark.com/v1/messages",
                          {"roomId": postdata["room"], "text": postdata["message"]})
            else:
                resp = SparkPOST(setHeaders(tokenbot), "https://api.ciscospark.com/v1/messages",
                          {"roomId": postdata["room"], "text": postdata["message"]})
            if str(resp) == "<Response [200]>":
                return jsonify({"result":"Message published"})
            else:
                return jsonify({"result":"Error posting the message"})
        elif dbresp == 0:
            return jsonify({"result":"Invalid Api Key"})
        else:
            return jsonify({"error":dbresp})

    except:
      return jsonify ({"error":"Bad request"})

@app.route("/v1/cstest", methods=['GET'])
def cstest():
    if request.args.get("test") == "1":
        resp = str(cshealth())
        if resp == "<Response [200]>":
            return jsonify({"Service": "OK"})
        else:
            return jsonify({"Service": "Error"})
    else:
        return jsonify({"error":"Not a valid test"})


@app.route("/v1/csrooms", methods=['GET'])
def csrooms():
    token = request.args.get("token")
    header = setHeaders(token)
    return jsonify(getRooms(header))

@app.route("/v1/altcall", methods=['POST'])
def apicall():
    postdata = json.loads(request.data)
    dbresp = dbauth(request.headers.get("Authorization"), postdata)
    if dbresp == 1:

            numberdata = {"number":postdata["pnumber"], "client":postdata["client"]}
            response = nexmocall(numberdata)
            if response != 3:
                response = {**response, **postdata}
                dbresp = dbwrite(postdata["client"], response, "call")
                if dbresp == 1:
                    return jsonify({"result":"Call in progress"})
                else:
                    return jsonify({"error":dbresp})
            else:
                return jsonify({"error": "Fail to communicate with Nexmo"})
    else:
        return jsonify({"result": "Invalid Api Key"})

#Global variables
tokenbot = ""


if __name__ == "__main__":
    # Only for debugging while developing
    app.run(host='0.0.0.0', debug=True, port=80)
