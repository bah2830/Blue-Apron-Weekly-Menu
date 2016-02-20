# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

$setupBootstrap = <<SETUP
apt-get update && apt-get install apache2 php5 php5-xdebug -y

echo " "
echo "Installing composer"
echo "==================="

cd /vagrant
curl -sS https://getcomposer.org/installer | php
php composer.phar install

echo " "
echo "Setting up apache"
echo "================="

sed -i \'s/User \$\{APACHE_RUN_USER\}/User vagrant/g\' /etc/apache2/apache2.conf
sed -i \'s/Group \$\{APACHE_RUN_GROUP\}/Group vagrant/g\' /etc/apache2/apache2.conf
sed -i \'s/short_open_tag = Off/short_open_tag = On/g\' /etc/php5/apache2/php.ini
sed -i \'s/display_errors = Off/display_errors = On/g\' /etc/php5/apache2/php.ini

rm -f /etc/apache2/sites-enabled/000-default.conf

echo "<VirtualHost *:80>" >> /etc/apache2/sites-enabled/000-default.conf
echo "    DocumentRoot /vagrant" >> /etc/apache2/sites-enabled/000-default.conf
echo "    <Directory /vagrant/>" >> /etc/apache2/sites-enabled/000-default.conf
echo "        Options Indexes FollowSymLinks" >> /etc/apache2/sites-enabled/000-default.conf
echo "        AllowOverride All" >> /etc/apache2/sites-enabled/000-default.conf
echo "        Order allow,deny" >> /etc/apache2/sites-enabled/000-default.conf
echo "        Allow from all" >> /etc/apache2/sites-enabled/000-default.conf
echo "        Require all granted" >> /etc/apache2/sites-enabled/000-default.conf
echo "    </Directory>" >> /etc/apache2/sites-enabled/000-default.conf
echo "</VirtualHost>" >> /etc/apache2/sites-enabled/000-default.conf

service apache2 restart
SETUP

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "10.10.10.10"

  config.vm.provision :shell, inline: $setupBootstrap
end
