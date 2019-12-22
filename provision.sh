#!/bin/bash

export DEBIAN_FRONTEND=noninteractive

sudo apt-key adv --keyserver hkp://ha.pool.sks-keyservers.net:80 \ --recv-keys 58118E89F3A912897C070ADBF76221572C52609D
echo "deb https://apt.dockerproject.org/repo ubuntu-trusty main" | sudo tee /etc/apt/sources.list.d/docker.list
sudo apt-get update
# sudo apt-get install linux-image-extra-$(uname -r) linux-image-extra-virtual -y
sudo apt-get install docker-engine --force-yes -y
sudo usermod -aG docker vagrant
sudo service docker start
docker version

# install docker sdk for python
sudo apt-get install python-pip -y
sudo python -m pip install docker

# install ansible (http://docs.ansible.com/intro_installation.html)
sudo apt-get -y install software-properties-common
sudo apt-add-repository -y ppa:ansible/ansible
sudo apt-get update
sudo apt-get -y install ansible


#gluster clients
sudo apt-get install -y glusterfs-client
sudo mkdir -p /mnt/sharedfs