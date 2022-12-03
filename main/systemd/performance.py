from time import sleep
import psutil
import json
import pika

mq_creds  = pika.PlainCredentials(
    username = "guest",
    password = "guest")

mq_params = pika.ConnectionParameters(
    host         = "rabbitmq",
    credentials  = mq_creds,
    virtual_host = "/")

mq_exchange    = "amq.topic"
mq_routing_key = "test"

mq_conn = pika.BlockingConnection(mq_params)

mq_chan = mq_conn.channel()

def loopIt():
    while True:
        data = {
          "cpu": psutil.cpu_percent(),
          "ram": psutil.virtual_memory().percent,
          "disk": psutil.disk_usage('/').percent
        }
        mq_chan.basic_publish(
        exchange    = mq_exchange,
        routing_key = mq_routing_key,
        body        = json.dumps(data))
        sleep(0.5)

try:
    loopIt()
except:
    sleep(30)
    loopIt()


