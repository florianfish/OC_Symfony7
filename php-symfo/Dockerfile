# Utilisation de l'image officielle PHP 8 de Docker Hub
FROM php:8.3-cli

# Définition du répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Met à jour les packages du système et installe les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libxml2-dev \
    nodejs \
    npm \
    wget \
    nano \
    apt-transport-https \
    ca-certificates \
    lsb-release \
    # configure les extensions PHP nécessaires
    && docker-php-ext-configure intl \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-configure soap --enable-soap \
    # installe les extensions PHP nécessaires
    && docker-php-ext-install -j$(nproc) \
    intl \
    pdo_mysql \
    pdo_pgsql \
    opcache \
    zip \
    gd \
    soap \
    # supprime les fichiers temporaires du système
    && rm -rf /var/lib/apt/lists/*

# installe l'extension Xdebug pour le débogage et active l'extension dans la configuration PHP
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Installation de Yarn
RUN npm install --global yarn

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation de Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# # Active le module de réécriture de Apache pour permettre l'utilisation de .htaccess
# RUN a2enmod rewrite

# Copie du code source de l'application dans le répertoire de travail du conteneur
COPY . /var/www/html

# # Exposition du port 80 pour le serveur web Apache
# EXPOSE 80

# Commande de démarrage d'Apache (pour la development)
CMD tail -f /dev/null

# CMD ["apache2-foreground"] : signifie que le conteneur s'arrête après le démarrage de Apache (pour la production)