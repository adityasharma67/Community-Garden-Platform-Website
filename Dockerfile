FROM php:8.1-apache

# Copy all files to the Apache document root
COPY . /var/www/html/

# Expose port 80
EXPOSE 80