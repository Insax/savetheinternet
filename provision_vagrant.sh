echo "Add the ondrej/php ppa repository"
add-apt-repository -y ppa:ondrej/php > /dev/null
echo "Add the mariadb repository"
curl -sS https://downloads.mariadb.com/MariaDB/mariadb_repo_setup | bash > /dev/null

apt-get update > /dev/null

echo "Install the dependencies"
export DEBIAN_FRONTEND=noninteractive
# set the mariadb root password because mariadb asks for it
debconf-set-selections <<< 'mariadb-server-5.5 mysql-server/root_password password savetheinternet'
debconf-set-selections <<< 'mariadb-server-5.5 mysql-server/root_password_again password savetheinternet'
# actually install
apt-get install -y nginx curl zip unzip git software-properties-common supervisor sqlite3 php7.1-fpm php7.1-cli php7.1-gd php7.1-mbstring php7.1-xml php7.1-curl php7.1-sqlite3 > /dev/null

echo "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

echo "Install nodejs and yarn"
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
apt-get -y install nodejs yarn > /dev/null