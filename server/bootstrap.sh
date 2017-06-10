#!/usr/bin/env bash

add-apt-repository ppa:ondrej/php -y

curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list

apt-get update

apt-get install -y \
	nodejs-legacy \
	yarn \
	nginx \
	postgresql \
	php-fpm \
	php-xml \
	php-mbstring \
	php-pgsql \
	php-sqlite3

if ! [ -L "/var/www/vagrant.vitkutny.cz/current" ]; then
	mkdir -p "/var/www/vagrant.vitkutny.cz"
	rm -rf "/var/www/vagrant.vitkutny.cz/current"
	ln -fs "/vagrant" "/var/www/vagrant.vitkutny.cz/current"
fi

if ! [ -L "/etc/nginx/sites-enabled/vagrant.vitkutny.cz" ]; then
	rm -rf "/etc/nginx/sites-enabled/vagrant.vitkutny.cz"
	ln -fs "/vagrant/server/etc/nginx/sites-available/vagrant.vitkutny.cz" "/etc/nginx/sites-enabled/vagrant.vitkutny.cz"
fi

curl -LOs "https://deployer.org/deployer.phar"
mv deployer.phar "/usr/local/bin/dep"
chmod +x "/usr/local/bin/dep"
