#!/usr/bin/python

import subprocess
import time

cmds = {}
def ping(ip):
    time.sleep(5)
    result = subprocess.Popen(['ping', '-c', '1', ip], stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    output, error = result.communicate()

    if result.returncode==0:
        return True
    else:
        return False