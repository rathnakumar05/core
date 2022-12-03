#!/usr/bin/python

import subprocess
import ipaddress

cmds = {
    'wg_allowed_ips' : 'wg show wg0 allowed-ips'
}

DEFAULT_IP = '10.8.0.2/32'

def getMissingIps(ip_list):
    for i in range(ip_list[0], ip_list[-1]+1):
        if(i not in ip_list):
            return [i]
    return []

def getIp():
    cmd = cmds['wg_allowed_ips']
    output = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    allowed_ips_li = []

    for out in output.stdout:
        ip = out.decode('ascii').strip().split('\t')[1].split('/')[0]
        try:
            allowed_ips_li.append(int(ipaddress.ip_address(ip)))
        except ValueError:
            continue

    if(len(allowed_ips_li)>0):
        allowed_ips_li.sort()
        if(str(ipaddress.IPv4Address(allowed_ips_li[0]))!='10.8.0.2'):
            return DEFAULT_IP
        missing_ips = getMissingIps(allowed_ips_li)
        if(len(missing_ips)>0):
            return str(ipaddress.IPv4Address(missing_ips[0]))+"/32"
        else:
            return str(ipaddress.IPv4Address(allowed_ips_li[-1]+1))+"/32"
    else:
        return DEFAULT_IP
