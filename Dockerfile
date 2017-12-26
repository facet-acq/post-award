FROM alpine:3.7

MAINTAINER "djfurman@gmail.com"
LABEL maintainer="djfurman@gmail.com"

RUN apk update && \
    apk upgrade && \
    apk add openrc nginx && \
    apk add php7 php7-curl php7-fpm php7-json php7-openssl php7-pdo_pgsql php7-phar php7-mbstring php7-tokenizer php7-mcrypt php7-xml php7-zlib && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

COPY infrastructure/config/www.conf /etc/php7/php-fpm.d/www.conf

COPY infrastructure/config/post_award.conf /etc/nginx/conf.d/default.conf
#  using http2
# Add secure DH exchange

# Add SELinux

COPY . /opt/facet/post-award/
WORKDIR /opt/facet/post-award
RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader && \
    mkdir -p /run/nginx && \
    rc-update add nginx default && \
    rc-update add php-fpm7 default

# Setup Cron
# Setup worker & supervisor

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
