FROM php:5.6-apache

# Instala as extensões PHP e módulos PECL.
RUN buildDeps="libbz2-dev libsasl2-dev" \
    runtimeDeps="curl git libicu-dev libjpeg-dev libmcrypt-dev libpng-dev libpq-dev libxml2-dev gettext libxslt-dev libib-util" \
    && apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y $buildDeps $runtimeDeps \
    && docker-php-ext-install bcmath bz2 calendar iconv intl mbstring mcrypt \
    && docker-php-ext-install opcache pdo mysql soap zip gettext \
    && docker-php-ext-install readline exif sysvmsg sockets shmop xmlrpc xsl wddx \

# Habilita o módulo rewrite.
RUN a2enmod rewrite
