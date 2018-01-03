FROM alpine:3.7

MAINTAINER "djfurman@gmail.com"
LABEL maintainer="djfurman@gmail.com"

# Basic System Patching
RUN apk update &&\
    apk upgrade

# Dependencies
RUN apk add supervisor
RUN apk add nginx
RUN apk add php7 \
        php7-curl \
        php7-fpm \
        php7-json \
        php7-mbstring \
        php7-mcrypt \
        php7-openssl \
        php7-phar \
        php7-tokenizer \
        php7-xml \
        php7-zlib
RUN apk add php7-pdo_pgsql
#RUN apk add php7-pdo_mysql
#RUN apk add php7-pdo_sqlite

# Supervisor Configuration
COPY infrastructure/config/supervisord.conf /etc/supervisord.conf
RUN mkdir -p /var/log/supervisor &&\
    touch /var/log/supervisor/supervisord.log

# PHP-FPM Configuration
RUN addgroup -S postAward &&\
    adduser -S -g postAward postAward &&\
    touch /var/run/php-fpm.sock &&\
    chown nginx:nginx /var/run/php-fpm.sock &&\
    chmod 660 /var/run/php-fpm.sock &&\
    chown postAward:postAward /var/log/php7
COPY infrastructure/config/php-fpm.conf /etc/php7/php-fpm.d/www.conf

# NGINX Configuration
RUN mkdir /run/nginx &&\
    chown nginx:nginx /run/nginx
COPY infrastructure/config/nginx-host.conf /etc/nginx/conf.d/default.conf

# Copy the code in
COPY . /opt/facet/post-award/
RUN chown -R postAward:postAward /opt/facet/post-award

# Get Composer Dependency manager
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" &&\
    php composer-setup.php --install-dir=bin --filename=composer &&\
    php -r "unlink('composer-setup.php');"

# Cleanup
RUN rm -rf /var/cache/apk/*

# Setup the system permissions
WORKDIR /opt/facet/post-award
USER postAward
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader

# Run Time
EXPOSE 80
CMD ["supervisord", "-n", "-c", "/etc/supervisord.conf"]
