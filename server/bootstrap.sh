#!/usr/bin/env bash

add-apt-repository ppa:ondrej/php -y

apt-get update

apt-get install -y \
	nginx \
	postgresql \
	php-fpm \
	php-pgsql \
	php-sqlite3

if ! [ -L "/var/www/vagrant.vitkutny.cz" ]; then
	rm -rf "/var/www/vagrant.vitkutny.cz"
	ln -fs "/vagrant" "/var/www/vagrant.vitkutny.cz"
fi

if ! [ -L "/etc/nginx/sites-enabled/vagrant.vitkutny.cz" ]; then
	rm -rf "/etc/nginx/sites-enabled/vagrant.vitkutny.cz"
	ln -fs "/vagrant/server/etc/nginx/sites-available/vagrant.vitkutny.cz" "/etc/nginx/sites-enabled/vagrant.vitkutny.cz"
fi

