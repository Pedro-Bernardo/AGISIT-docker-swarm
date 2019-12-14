# AGISIT-docker-swarm
Docker Swarm


## This was in the Vagrantfile but needs to be modified and moved:

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
ssh-keyscan worker1 worker2 >> ~/.ssh/known_hosts
```

Play the `ssh-addkey.yml` playbook:
```
ansible-playbook ssh-addkey.yml --ask-pass
```

Verify the connectivity:
```
ansible all -m ping
```

Finally, add the worker nodes to the docker swarm:
```
ansible-playbook add-workers.yml
```

Verify that the workers were added to the swarm:
```
docker node ls
```
