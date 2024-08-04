# Use a imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Instale extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar o xdebug para o teste de cobertura de código   
RUN pecl install xdebug && docker-php-ext-enable xdebug

ENV XDEBUG_MODE=coverage

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie o conteúdo da aplicação para o diretório de trabalho
COPY . /var/www/html

# Defina as permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponha a porta 80 para o Apache
EXPOSE 80

# Comando padrão para iniciar o servidor Apache
CMD ["apache2-foreground"]
