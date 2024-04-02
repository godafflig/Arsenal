FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite and set ServerName
RUN a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Adjust Apache to allow .htaccess files and enable overrides
RUN echo '<Directory "/var/www/html">' > /etc/apache2/conf-available/override.conf \
    && echo '    AllowOverride All' >> /etc/apache2/conf-available/override.conf \
    && echo '</Directory>' >> /etc/apache2/conf-available/override.conf \
    && a2enconf override

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# No need to restart Apache here; it will be handled by CMD/ENTRYPOINT

EXPOSE 80

# This is the default CMD for the official php:apache image.
CMD ["apache2-foreground"]
