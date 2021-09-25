ARG HOST_USER_ID=1000
ARG HOST_GROUP_ID=1000

FROM ubuntu:20.04

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
    apt-get -y install nano sudo git wget openssh-client inetutils-ping mysql-client unzip

RUN apt-get -yq install software-properties-common
RUN add-apt-repository -y ppa:ondrej/php
RUN apt-get update

RUN apt-get update && \
    apt-get -yq install \
    php8.0 \
    php8.0-gmp \
    php8.0-curl \
    php8.0-gd \
    php8.0-mbstring \
    php8.0-bcmath \
    php8.0-soap \
    php8.0-zip \
    php8.0-xml \
    php8.0-mysql \
    php8.0-redis \
    php8.0-mongodb \
    php8.0-msgpack

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/95d11ed947f602b5a5f83f80c062e134d62c9f4b/web/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -yq libnss3-tools curl && \
    wget https://github.com/FiloSottile/mkcert/releases/download/v1.4.3/mkcert-v1.4.3-linux-amd64 -O /usr/local/bin/mkcert && \
    chmod +x /usr/local/bin/mkcert

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - && \
    apt-get install -y nodejs && \
    apt-get remove cmdtest

RUN npm i -g yarn

COPY ./certbot.sh /tmp
COPY ./init.sh /tmp

WORKDIR /home/ubuntu/app
ENTRYPOINT /bin/bash /tmp/init.sh && tail -f /home/ubuntu/app/storage/logs/laravel.log
