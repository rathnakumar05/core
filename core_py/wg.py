#!/usr/bin/python

import subprocess
import re

cmds = {
    'wg_private_key' : 'wg genkey',
    'wg_public_key' : 'echo "{}" | wg pubkey',
    'wg_add_peer' : 'wg set wg0 peer {} allowed-ips {}',
    'wg_remove_peer' : 'wg set wg0 peer {} remove',
    'wg_peers' : 'wg show wg0 peers | grep -c "{}"',
    'wg_save': 'wg-quick save wg0'
}

def genKeys():
    cmd = cmds['wg_private_key']
    private_key = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    private_key = private_key.stdout.readline().decode('ascii').strip()

    cmd_1 = cmds['wg_public_key'].format(private_key)

    public_key = subprocess.Popen(cmd_1, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    public_key = public_key.stdout.readline().decode('ascii').strip()

    return private_key, public_key

def peerAction(peer_details, action):

    if(action=='add'):
        cmd = cmds['wg_add_peer']
    elif(action=='remove'):
        cmd = cmds['wg_remove_peer']
    else:
        return False

    cmd = cmd.format(peer_details['public_key'], peer_details['allowed_ip'])
    output = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    output = output.stdout.readline().decode('ascii').strip()
    cmd_1 = cmds['wg_save']
    output_1 = subprocess.Popen(cmd_1, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    output_1 = output_1.stdout.readline().decode('ascii').strip()
    # [#] wg showconf wg0
    if(output==''):
        return True
    else:
        return False

def peerCheck(public_key):
    if(public_key==""):
        return False
    cmd = cmds["wg_peers"].format(public_key)
    output = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    output = output.stdout.readline().decode('ascii').strip()
    if(int(output) > 0):
        return True
    else:
        return False




# peerAction({"public_key": "BssTpRJere/rb4bfbX45wKI/aWaByocxmGA7JOl3SGQ=", "allowed_ip" : "10.8.0.2"}, "remove")
