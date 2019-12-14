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