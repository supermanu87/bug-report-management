# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
#COPY . /var/www/html

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Install any needed packages specified in requirements.txt
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    && a2enmod rewrite

# Make port 80 available to the world outside this container
EXPOSE 80

# Define environment variable
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Enable apache mod_rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copy virtual host configuration
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Enable the new virtual host configuration
RUN a2ensite 000-default.conf