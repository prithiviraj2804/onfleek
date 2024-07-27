#!/bin/bash
#services start
wg-quick up wg0 #Peer Variable
iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
sudo iptables -A FORWARD  -p tcp -i wg0 --dst 172.20.0.0/16
service ssh start

# htdocs symlink
rm -rf /var/www/html
ln -s /home/mechtool/htdocs /var/www/html #username variable


#apache config file symlink
mkdir /home/mechtool/htconfig/
cp -rn /etc/apache2/sites-available/* /home/mechtool/htconfig
rm -rf /etc/apache2/sites-available
ln -s /home/mechtool/htconfig /etc/apache2/sites-available

# change permissions to htdocs
cd /home
chmod 775 mechtool #username variable
chown -R mechtool:mechtool /home/mechtool/htdocs #username variable
adduser www-data mechtool #username variable
# echo "Options +FollowSymLinks +SymLinksIfOwnerMatch" > /home/mechtool/htdocs/html/.htaccess #username variable
cd /home/mechtool/htdocs #username variable
chmod o+x *

#chaning permissions to htconfig
chown -R mechtool:mechtool /home/mechtool/htconfig
chown -R mechtool:mechtool /home/mechtool/.ssh
chown -R mechtool:mechtool /home/mechtool/.bashrc

#remove password
echo "mechtool ALL=(ALL:ALL) NOPASSWD: /usr/sbin/a2ensite" | sudo tee -a /etc/sudoers.d/mechtool > /dev/null
echo "mechtool ALL=(ALL:ALL) NOPASSWD: /usr/sbin/a2enmod" | sudo tee -a /etc/sudoers.d/mechtool > /dev/null
echo "mechtool ALL=(ALL:ALL) NOPASSWD: /usr/sbin/a2dismod" | sudo tee -a /etc/sudoers.d/mechtool > /dev/null
echo "mechtool ALL=(ALL:ALL) NOPASSWD: /usr/sbin/a2dissite" | sudo tee -a /etc/sudoers.d/mechtool > /dev/null


cd /home/mechtool
touch init.sh
chmod +x  init.sh
chown -R mechtool:mechtool init.sh

su mechtool <<EOF
mkdir /home/mechtool/.ssh/
chown mechtool:mechtool .ssh/
chmod go-w /home/mechtool/
chmod 700 /home/mechtool/.ssh
chmod 600 /home/mechtool/.ssh/authorized_keys
cd /home/mechtool && ./init.sh
echo mechtool@321 | sudo -S service apache2 restart
tail -f /dev/null
EOF

tail -f /dev/null