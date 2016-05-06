FROM php:5.6-fpm

# Install required php extensions
RUN apt-get update -y && apt-get install -y php5-mysql php5-gd php5-curl php5-mcrypt

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '92102166af5abdb03f49ce52a40591073a7b859a86e8ff13338cf7db58a19f7844fbc0bb79b2773bf30791e935dbd938') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Install magerun
RUN apt-get install -y wget && \
    wget https://files.magerun.net/n98-magerun.phar && \
    apt-get purge -y wget && \
    mv n98-magerun.phar /usr/bin/ && \
    echo 'alias magerun="php -f /usr/bin/n98-magerun.phar --"' >> /root/.bashrc

# Install Accolade Magerun Tools
RUN apt-get install -y git && \
mkdir -p /usr/local/share/n98-magerun/modules && \
cd /usr/local/share/n98-magerun/modules && \
git clone https://github.com/Accolades/MagerunTools.git