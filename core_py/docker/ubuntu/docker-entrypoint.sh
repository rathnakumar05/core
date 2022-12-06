#!/bin/bash

private_key=${PRIVATE_KEY}
user=${USER}
ip=${IP}

flag=0
if [[ $user == "" ]];then
    echo "[x] username is not acquired"
    flag=1
fi

if [[ $private_key == "" ]];then    
    echo "[x] keys are not acquired"
    flag=1
fi

if [[ $ip == "" ]];then
    echo "[x] ip is not acquired"
fi

if [[ $flag == 1 ]];then
    exit
fi

echo "username ===> $user"
echo "wg private_key ===>  $private_key"
echo "allowed ip ===> $ip"

echo $private_key > /etc/wireguard/private.key
chmod go= /etc/wireguard/private.key
cat /etc/wireguard/private.key | wg pubkey > /etc/wireguard/public.key

cat <<< "[Interface]
PrivateKey = $private_key
Address = $ip

[Peer]
PublicKey = qVmEOK7DDhMxIvk15NzMn8WepdtK2hRqcgvPTviwaXQ=
AllowedIPs = 10.8.0.0/24
Endpoint = host.docker.internal:51820
PersistentKeepalive = 30" > /etc/wireguard/wg0.conf

adduser $user --gecos "First Last,RoomNumber,WorkPhone,HomePhone" --disabled-password
echo "${user}:${user}123" | chpasswd

usermod -aG sudo $user

wg-quick up wg0

exec /usr/sbin/sshd -D

