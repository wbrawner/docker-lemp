FROM php:5.6-fpm

# Install required dependencies
RUN apt-get update -y && apt-get install -y libc6 libfreetype6-dev \
libgd3 libjpeg62-turbo-dev libpng12-dev libvpx1 libx11-6 libxpm4 \
zlib1g phpapi-20131226 php5-common ucf libcurl4-gnutls-dev libltdl7 \
libmcrypt-dev libgcc1 libicu52 libgcc1 libicu-dev

# Install required php extensions
RUN docker-php-ext-install gd && \
docker-php-ext-install mcrypt && \
docker-php-ext-install intl && \
docker-php-ext-install curl && \
docker-php-ext-install pdo_mysql

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
git clone https://github.com/Accolades/MagerunTools.git /usr/local/share/n98-magerun/modules/MagerunTools

# Install Magento Mess Detector
RUN git clone git@github.com:AOEpeople/mpmd.git /usr/local/share/n98-magerun/modules/mpmd
