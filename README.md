# AGISIT-docker-swarm
Docker Swarm


## This was in the Vagrantfile but needs to be modified and moved:
(REVIEW THIS)
### command to join the swarm with a token saved in '/vagrant/token'. This will be done through ansible and there will be no token file
The ansible playbook will be present in the shared folder

```
if auto
    i.vm.provision "shell", inline: "docker swarm join --advertise-addr #{instance[:ip]} --listen-addr #{instance[:ip]}:2377 --token `cat /vagrant/token` #{manager_ip}:2377"
end
```

## Procedure
Boot up the machines:
```
vagrant up
```

Once all machines are up and running, ssh into the manager node:
```
vagrant ssh manager
```

Create an ssh-key:
```
ssh-keygen -t rsa -b 2048
```

Scan the workers public key:
```
ssh-keyscan manager worker1 worker2 gluster1 gluster2 >> ~/.ssh/known_hosts
```

Play the `ssh-addkey.yml` playbook:
```
ansible-playbook ssh-addkey.yml --ask-pass
```

Verify the connectivity:
```
ansible all -m ping
```

### Setup container and launch service 

Build the container in all of the swarm nodes
```
ansible-playbook build_webserver_image.yml --ask-pass
```

Launch the service with only 1 replica.   
- /mnt/sharedfs is the location of the glusterfs mountpoint
- web_container is the name of the custom container (apache + php)
```
docker service create --name web --replicas 1 --publish 8080:80 --mount type=bind,source=/mnt/sharedfs,target=/storage --env UPLOAD_DIR=/storage/ web_container
```

Replicate the service:
```
docker service scale web=3
```

## Setup shared filesystem

On the manager node run:
```
ansible-playbook gluster.yml
```
