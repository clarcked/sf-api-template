FROM php:7.4-cli

RUN apt-get update
RUN apt-get upgrade -y
RUN apt -y install curl apt-utils
RUN apt-get -qq -y install libcurl3-dev libmcrypt-dev libicu-dev libpcre3-dev libpq-dev zlib1g-dev libzip-dev sendmail libsodium-dev vim git zip unzip wget libsqlite3-dev libsqlite3-0 libbz2-dev
RUN docker-php-ext-install fileinfo tokenizer gettext iconv fileinfo ctype sockets intl pdo pdo_mysql pdo_pgsql mysqli bz2 opcache pdo_sqlite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" >> /usr/local/etc/php/conf.d/sendmail.ini
RUN mv $HOME/.symfony/bin/symfony /usr/local/bin/symfony
RUN docker-php-ext-enable xdebug
#####>
COPY ./ ./home
#####>
RUN sed -i '/#!\/bin\/sh/aservice sendmail restart' /usr/local/bin/docker-php-entrypoint
RUN sed -i '/#!\/bin\/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint
####>
RUN apt-get autoremove
CMD ["symfony","serve","--dir=","/home"]
EXPOSE 8000