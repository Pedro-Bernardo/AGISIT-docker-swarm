# -*- mode: ruby -*-
# vi: set ft=ruby :

# Increase numworkers if you want more than 3 nodes
numworkers = 2

# VirtualBox settings
# Increase vmmemory if you want more than 512mb memory in the vm's
vmmemory = 512
# Increase numcpu if you want more cpu's per vm
numcpu = 1

manager_ip = "192.168.56.2"

Vagrant.configure("2") do |config|
    config.vm.provider "virtualbox" do |v|
     	v.memory = vmmemory
  	v.cpus = numcpu
    end

    config.vm.define "manager" do |node|
      node.vm.box = "ubuntu/trusty64"
      node.vm.hostname = "manager"
      node.vm.network "private_network", ip: "#{manager_ip}"
      node.vm.provision "shell", path: "./provision.sh"

      # Shared folder configuration
      if Vagrant::Util::Platform.windows? then
      # Configuration SPECIFIC for Windows 10 hosts
        config.vm.synced_folder "shared", "/home/vagrant/shared",
          id: "vagrant-root", ouner: "vagrant", group: "vagrant",
          mount_options: ["dmode=775,fmode=664"]
        else
      # Configuration for Unix/Linux hosts
        config.vm.synced_folder "shared", "/home/vagrant/shared"
      end

      node.vm.provision "shell", inline: "docker swarm init --advertise-addr #{manager_ip}"
      node.vm.provision "shell", inline: "docker swarm join-token -q worker > /vagrant/shared/token"
    end

  (1..numworkers).each do |n|
    config.vm.define "worker#{n}" do |node|
      node.vm.box = "ubuntu/trusty64"
      node.vm.hostname = "worker#{n}"
      node.vm.network "private_network", ip: "192.168.56.#{n+2}"
      node.vm.provision "shell", path: "./provision.sh"

      # Needed?
      # # Shared folder configuration
      # if Vagrant::Util::Platform.windows? then
      # # Configuration SPECIFIC for Windows 10 hosts
      #   config.vm.synced_folder "shared", "/home/vagrant/shared",
      #     id: "vagrant-root", ouner: "vagrant", group: "vagrant",
      #     mount_options: ["dmode=775,fmode=664"]
      #   else
      # # Configuration for Unix/Linux hosts
      #   config.vm.synced_folder "shared", "/home/vagrant/shared"
      # end

    end
  end
end
