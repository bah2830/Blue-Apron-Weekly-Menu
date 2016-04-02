# -*- mode: ruby -*-
# vi: set ft=ruby :

$bootstrapScript = <<SETUP
curl -sSL https://get.docker.com/ | sh
usermod -aG docker vagrant
SETUP

$initScript = <<INITSCRIPT
cd /vagrant
./deploy.sh
INITSCRIPT

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "10.10.10.10"

  config.vm.provision :shell, inline: $bootstrapScript
  config.vm.provision :shell, inline: $initScript, run: "always"
end
