import sys
import utils
import ip
import wg
import docker
import argparse
import json

def errorMsg():
    result = {
        'status' : "ERROR"
    }
    result = json.dumps(result)
    print(result)
    sys.exit()

#check
#python3 core.py --action check --peerchk 5rqgllKd0+OvQzvEoFR12znwqhwlV8IXnrX29n4dQm4=
#add
#python3 core.py --action add --peer 5rqgllKd0+OvQzvEoFR12znwqhwlV8IXnrX29n4dQm4=
#update
#python3 core.py --action update --oldpeer 5rqgllKd0+OvQzvEoFR12znwqhwlV8IXnrX29n4dQm4= --peer 5rqgllKd0+OvQzvEoFR12znwqhwlV8IXnrX29n4dQm4=
#remove
#python3 core.py --action remove --peer 5rqgllKd0+OvQzvEoFR12znwqhwlV8IXnrX29n4dQm4=
#deploy ubuntu
#python3 core.py --action deploy --machine ubuntu --user rathna

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--action', help='What is needs to be made', type=str, required=False)
    parser.add_argument('--peerchk', help='What is needs to be made', type=str, required=False)
    parser.add_argument('--peer', help='What is needs to be made', type=str, required=False)
    parser.add_argument('--oldpeer', help='What is needs to be made', type=str, required=False)
    parser.add_argument('--machine', help='What is needs to be made', type=str, required=False)
    parser.add_argument('--user', help='What is needs to be made', type=str, required=False)
    parser.add_argument('--cont_id', help='What is needs to be made', type=str, required=False)
    args = parser.parse_args()

    if(not hasattr(args, 'action') or (args.action==None)):
        errorMsg()

    action = args.action

    if(action=="check"):
        if(not hasattr(args, 'peerchk') or (args.peerchk==None)):
            errorMsg()
        public_key = args.peerchk
        if(wg.peerCheck(public_key)):
            result = {
                'status' : "SUCCESS",
            }
            result = json.dumps(result)
            print(result)
            sys.exit()
        else:
           errorMsg() 

    elif(action=="add"):
        if(not hasattr(args, 'peer') or (args.peer==None)):
            errorMsg()
        peer = args.peer
        ip = ip.getIp()
        if((ip is None) or (ip=="")):
            errorMsg()

        peer_details = {
            'allowed_ip' : ip,
            'public_key' : peer
        }
        if(wg.peerAction(peer_details, 'add')):
            result = {
                'status' : "SUCCESS",
                'peer_details' : peer_details
            }
            result = json.dumps(result)
            print(result)
            sys.exit()
        else:
            errorMsg()

    elif(action=="update"):
        if((not hasattr(args, 'peer')) or (not hasattr(args, 'oldpeer')) or (args.peer==None) or (args.oldpeer==None)):
            errorMsg()
        peer = args.peer
        old_peer = args.oldpeer
        peer_details = {
            'allowed_ip' : "",
            'public_key' : old_peer
        }
        if(not wg.peerAction(peer_details, 'remove')):
            errorMsg()
        ip = ip.getIp()
        if((ip is None) or (ip=="")):
            errorMsg()

        peer_details = {
            'allowed_ip' : ip,
            'public_key' : peer
        }
        if(wg.peerAction(peer_details, 'add')):
            result = {
                'status' : "SUCCESS",
                'peer_details' : peer_details
            }
            result = json.dumps(result)
            print(result)
            sys.exit()
        else:
            errorMsg()

    elif(action=="remove"):
        if(not hasattr(args, 'peer') or (args.peer==None)):
            errorMsg()
        peer = args.peer
        peer_details = {
            'allowed_ip' : "",
            'public_key' : peer
        }
        if(wg.peerAction(peer_details, 'remove')):
            result = {
                'status' : "SUCCESS"
            }
            result = json.dumps(result)
            print(result)
            sys.exit()
        else:
            errorMsg()
    elif(action=="deploy"):
        if((not hasattr(args, 'machine')) or (not hasattr(args, 'user')) or (args.machine==None) or (args.user==None)):
            errorMsg()
        machine = args.machine
        user = args.user

        ip = ip.getIp()
        if((ip is None) or (ip=="")):
            errorMsg()

        private_key, public_key = wg.genKeys()
        if((private_key is None) or (private_key=="") or (public_key is None) or (public_key=="")):
            errorMsg()

        machine_details = {
            'image' : machine,
            'private_key' : private_key,
            'allowed_ip' : ip,
            'user_name' : user
        }

        container_id = docker.deployMachine(machine_details)
        if(len(container_id)!=64):
            errorMsg()

        ping = utils.ping(ip)
        if(ping!=0):
            errorMsg()

        peer_details = {
            'allowed_ip' : ip,
            'public_key' : public_key
        }
        if(not wg.peerAction(peer_details, 'add')):
            errorMsg()  

        machine_details = {
            'allowed_ip' : ip,
            'public_key' : public_key,
            'machine' : machine,
            'container_id' : container_id
        }

        result = {
            'status' : 'SUCCESS',
            'machine_details' : machine_details
        }

        result = json.dumps(result)
        print(result)
        sys.exit()
    elif(action=="shutdown"):
        if((not hasattr(args, 'cont_id')) and (args.cont_id is None)):
            errorMsg()  
        container_id = args.cont_id
        if(docker.stopMachine(container_id)):
            result = {
                'status' : "SUCCESS"
            }
            result = json.dumps(result)
            print(result)
            sys.exit()
        else:
            errorMsg() 
    elif(action=="delete"):
        if((not hasattr(args, 'cont_id')) and (args.cont_id is None)):
            errorMsg() 
        container_id = args.cont_id
        if(docker.deleteMachine(container_id)):
            result = {
                'status' : "SUCCESS"
            }
            result = json.dumps(result)
            print(result)
            sys.exit()
        else:
            errorMsg() 
    elif(action=="start"):
        if((not hasattr(args, 'cont_id')) and (args.cont_id is None)):
            errorMsg() 
        container_id = args.cont_id
        if(docker.startMachine(container_id)):
            result = {
                'status' : "SUCCESS"
            }
            result = json.dumps(result)
            print(result)
            sys.exit()
        else:
            errorMsg() 
    else:
        errorMsg()






