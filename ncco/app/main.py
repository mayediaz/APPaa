import json
from flask import Flask, jsonify, request
from functions import dbcompare, nexmocall

app = Flask(__name__)

@app.route("/ncco", methods=['GET'])
def ncco():
    client = request.args.get("client")
    return jsonify([
  {
    "action": "talk",
    "voiceName": "Penelope",
    "text": "Bievenido al sistema de alarmas automaticas, estamos experimentando "
            "una falla en el cliente {0}".format(client)
  }
])
@app.route("/", methods=["POST"])
def nexmo():
    postdata = json.loads(request.data)
    if postdata["status"] == "timeout":
        dbresp = dbcompare("", "call", postdata["uuid"])
        if dbresp != 0 or dbresp != 3:
            response = nexmocall(dbresp)
            if response != 3:
                return jsonify({"status":"Call in progress"})
            else:
                return jsonify({"error":"Fail to communicate with Nexmo"})
        elif dbresp == 0:
            return  jsonify({"status": "Call no found"})
        else:
            return jsonify({"error": "Failed to auth/communicate with database"})


    else:
        return jsonify({"status":"No need alternative call"})

if __name__ == "__main__":
    app.run()