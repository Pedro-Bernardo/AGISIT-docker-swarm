sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:gluster/glusterfs-3.8
sudo apt-get update
sudo apt-get install -y glusterfs-server

sudo mkdir -p /gluster/volume
