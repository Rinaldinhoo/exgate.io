FROM wyveo/nginx-php-fpm:php81

# Instalar dependências necessárias e cron
RUN apt-get install -y \
    wget \
    gnupg \
    apt-transport-https \
    lsb-release \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Atualizar a chave GPG do Sury PHP
RUN wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -

# Adicionar o repositório do Sury PHP
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/sury-php.list

# Atualizar a chave GPG do Nginx
RUN wget -qO - https://nginx.org/keys/nginx_signing.key | apt-key add -

# Adicionar o repositório do Nginx
RUN echo "deb http://nginx.org/packages/mainline/debian/ $(lsb_release -sc) nginx" > /etc/apt/sources.list.d/nginx.list

# Atualizar os repositórios e instalar a extensão para PHP
RUN apt-get update