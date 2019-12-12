FROM php:5.6-apache

# Instala vim e git nas imagens
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y libbz2-dev curl git vim libmcrypt-dev libxml2-dev gettext libxslt-dev 

# Instala as extensões PHP e módulos PECL.
RUN docker-php-ext-install bcmath bz2 calendar iconv intl mbstring mcrypt opcache
RUN docker-php-ext-install pdo mysql soap 

# Habilita o módulo rewrite.
RUN a2enmod rewrite
