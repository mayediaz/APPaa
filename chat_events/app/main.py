import json
from sparkcalls import setHeaders, getRooms
from functions import cshealth, dbcompare, dbwrite, dbauth
from flask import Flask, request, jsonify

app = Flask(__name__)
#Token process
@app.route("/v1/tc", methods=['GET'])
def tokencreate():
    client = request.args.get("client")
    dbresp = dbcompare(client)
    if dbresp != 0:
        return jsonify({"token": dbresp, "client": client})
    else:
        #Token creation
        dbresp, token = dbwrite(client)
        if dbresp == "OK":
            return jsonify({"token":token, "client":client})
        else:
            return jsonify({"error":dbresp})

#Message send via Cisco Spark
@app.route("/v1/cs", methods=['POST'])
def csalarms():
    postdata = json.loads(request.data)
    dbresp = dbauth(request.headers.get("Authorization"), postdata)
    if dbresp == 1:
        return jsonify({"result":"Message published"})
    elif dbresp == 0:
        return jsonify({"result":"Invalid Api Key"})
    else:
        return jsonify({"error":dbresp})
#Cisco Spark Test
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

#Cisco Spark get rooms
@app.route("/v1/csrooms", methods=['GET'])
def csrooms():
    token = request.args.get("token")
    header = setHeaders(token)
    return jsonify(getRooms(header))


if __name__ == "__main__":
    # Only for debugging while developing
    app.run(host='0.0.0.0', debug=True, port=80)
