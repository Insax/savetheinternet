FROM ubuntu:16.04

MAINTAINER Kellerrennkadse

RUN apt-get update \
    && apt-get install -y locales \
    && locale-gen de_DE.UTF-8

ENV LANG de_DE.UTF-8
ENV LANGUAGE de_DE:en
ENV LC_ALL de_DE.UTF-8

RUN apt-get update \
    && apt-get install -y nginx curl zip unzip git software-properties-common supervisor sqlite3 \
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y php7.1-fpm php7.1-cli php7.1-gd \
       php7.1-mbstring php7.1-xml php7.1-curl \
       php7.1-sqlite3 \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && if [ ! -x /usr/bin/composer ]; then echo "Composer not found" && exit 1; fi \
    && mkdir /run/php \
    && apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

COPY default /etc/nginx/sites-available/default

COPY php-fpm.conf /etc/php/7.1/fpm/php-fpm.conf

EXPOSE 80

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY entrypoint.sh /usr/local/bin
RUN chmod +x /usr/local/bin/entrypoint.sh

CMD ["/usr/bin/supervisord"]

COPY packaged /var/www/html

RUN chown -R www-data:www-data /var/www/html
