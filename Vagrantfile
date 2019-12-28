# -*- mode: ruby -*-
# vi: set ft=ruby :

# Increase numworkers if you want more than 3 nodes
numworkers = 2
numstorenodes = 2

# VirtualBox settings
# Increase vmmemory if you want more than 512mb memory in the vm's
vmmemory = 512
# Increase numcpu if you want more cpu's per vm
numcpu = 1

# The Swarm Manager IP Address
manager_ip = "192.168.56.2"

workers  = []
storenodes = []

# create swarm instances Names and IP Addresses
(1..numworkers).each do |n|
  workers.push({:name => "worker#{n}", :ip => "192.168.56.#{n+2}"})
end

# create Storage Node Names and IP Addresses
(1..numstorenodes).each do |n|
  storenodes.push({:name => "gluster#{n}", :ip => "192.168.56.#{80+n}"})
end

# create a hosts file for DNS resolution
File.open("./hosts", 'w') { |file|
  workers.each do |i|
    file.write("#{i[:ip]} #{i[:name]} #{i[:name]}\n")
  end
  storenodes.each do |i|
    file.write("#{i[:ip]} #{i[:name]} #{i[:name]}\n")
  end
}

Vagrant.configure("2") do |config|
    config.vm.provider "virtualbox" do |vb|
     	vb.memory = vmmemory
  	  vb.cpus = numcpu
    end

    config.vm.define "manager" do |node|
      node.vm.box = "ubuntu/trusty64"
      node.vm.hostname = "manager"
      node.vm.network "private_network", ip: "#{manager_ip}"
      node.vm.synced_folder "shared", "/home/vagrant/shared"

      # /etc/hosts update
      node.vm.provision "file", source: "hosts", destination: "/tmp/hosts"
      node.vm.provision "shell", inline: "cat /tmp/hosts >> /etc/hosts", privileged: true
            
      # Auto Start Swarm
      node.vm.provision "shell", path: "./provision.sh"
      node.vm.provision "shell", inline: "docker swarm init --advertise-addr #{manager_ip}"
      node.vm.provision "shell", inline: "docker swarm join-token -q worker > /vagrant/token"
    end

  workers.each do |worker|
    config.vm.define worker[:name] do |node|
      node.vm.box = "ubuntu/trusty64"
      node.vm.hostname = worker[:name]
      node.vm.network "private_network", ip: worker[:ip]
      node.vm.synced_folder "shared", "/home/vagrant/shared"
      
      # /etc/hosts update
      node.vm.provision "file", source: "hosts", destination: "/tmp/hosts"
      node.vm.provision "shell", inline: "cat /tmp/hosts >> /etc/hosts", privileged: true
       
      # Auto Start Swarm
      node.vm.provision "shell", path: "./provision.sh"
      node.vm.provision "shell", inline: "docker swarm join --advertise-addr #{worker[:ip]} --listen-addr #{worker[:ip]}:2377 --token `cat /vagrant/token` #{manager_ip}:2377"
    end
  end

  storenodes.each do |gluster|
    config.vm.define gluster[:name] do |node|
      node.vm.box = "ubuntu/trusty64"
      node.vm.hostname = gluster[:name]
      node.vm.network "private_network", ip: gluster[:ip]
      #
      # /etc/hosts update
      node.vm.provision "file", source: "hosts", destination: "/tmp/hosts"
      node.vm.provision "shell", inline: "cat /tmp/hosts >> /etc/hosts", privileged: true
    end
  end
end

