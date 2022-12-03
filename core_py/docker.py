#!/usr/bin/python

import subprocess

cmds = {
    'ubuntu' : 'docker run -d --add-host host.docker.internal:host-gateway -h core --cap-add NET_ADMIN --cap-add SYS_MODULE --sysctl net.ipv6.conf.all.disable_ipv6=0 --sysctl="net.ipv4.conf.all.src_valid_mark=1" -e PRIVATE_KEY={} -e IP={} -e USER={} r0xff/core_ubuntu:alpha',
    'debian' : 'docker run -d --add-host host.docker.internal:host-gateway -h core --cap-add NET_ADMIN --cap-add SYS_MODULE --sysctl net.ipv6.conf.all.disable_ipv6=0 --sysctl="net.ipv4.conf.all.src_valid_mark=1" -e PRIVATE_KEY={} -e IP={} -e USER={} r0xff/core_debian:alpha',
    'shutdown' : 'docker stop {}',
    'delete' : 'docker rm -f {}',
    'start' : 'docker start {}',
}

def deployMachine(machine_details):
    image = machine_details['image']
    cmd = ''
    if(image=='ubuntu'):
        cmd = cmds['ubuntu'].format(machine_details['private_key'], machine_details['allowed_ip'], machine_details['user_name'])
    elif(image=='debian'):
        cmd = cmds['debian'].format(machine_details['private_key'], machine_details['allowed_ip'], machine_details['user_name'])


    container_id = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    container_id = container_id.stdout.readline().decode('ascii').strip()

    return container_id

def stopMachine(container_id):
    cmd = cmds['shutdown'].format(container_id)

    container_id_res = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    container_id_res = container_id_res.stdout.readline().decode('ascii').strip()

    if(container_id_res==container_id):
        return True
    else:
        return False

def deleteMachine(container_id):
    cmd = cmds['delete'].format(container_id)

    container_id_res = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    container_id_res = container_id_res.stdout.readline().decode('ascii').strip()

    if(container_id_res==container_id):
        return True
    else:
        return False

def startMachine(container_id):
    cmd = cmds['start'].format(container_id)

    container_id_res = subprocess.Popen(cmd, shell=True, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    container_id_res = container_id_res.stdout.readline().decode('ascii').strip()

    if(container_id_res==container_id):
        return True
    else:
        return False

    