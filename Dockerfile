FROM alpine:latest

LABEL maintainer="djfurman@gmail.com"

RUN apk update && \
    apk upgrade && \
    apk add openrc nginx php7 php7-fpm php7-pdo_pgsql && \
    rc-update add nginx default && \
    rc-update add php-fpm7 default

# Add php-fpm configuration
# Add NGINX Configuration
#  using php-fpm socket
#  using http2
# Add secure DH exchange
# Add SELinux

ADD . /opt/facet/post-award

# Setup Cron
# Setup worker & supervisor

EXPOSE 443
