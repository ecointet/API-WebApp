
# Use the official PHP image.
# https://hub.docker.com/_/php
FROM php:8.0-apache

# Configure PHP for Cloud Run.
# Precompile PHP code with opcache.
RUN docker-php-ext-install -j "$(nproc)" opcache
RUN docker-php-ext-install mysqli
#RUN docker-php-ext-install curl
RUN set -ex; \
  { \
    echo "; Cloud Run enforces memory & timeouts"; \
    echo "memory_limit = -1"; \
    echo "max_execution_time = 0"; \
    echo "; File upload at Cloud Run network limit"; \
    echo "upload_max_filesize = 32M"; \
    echo "post_max_size = 32M"; \
    echo "; Configure Opcache for Containers"; \
    echo "opcache.enable = On"; \
    echo "opcache.validate_timestamps = Off"; \
    echo "; Configure Opcache Memory (Application-specific)"; \
    echo "opcache.memory_consumption = 32"; \
  } > "$PHP_INI_DIR/conf.d/cloud-run.ini"

# Copy in custom code from the host machine.
WORKDIR /var/www/html
COPY . ./

##MOUNT PERSISTENT STORAGE
#ENV MNT_DIR /mnt/gcs
##VOLUME api-webapp:/data
# Use the PORT environment variable in Apache configuration files.
# https://cloud.google.com/run/docs/reference/container-contract#port
RUN a2enmod rewrite
RUN cp srv/.apache /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
    
# CREATE THE FOLDER FOR THE DATABASE
RUN mkdir -p /var/www/html/data
RUN chmod -R 777 /var/www/html/data

#GOOGLE API KEY
ENV GKEY=
ENV PORT=8080

#FILE or SQL (database type)
ENV DB_TYPE=FILE
ENV SQL_DB=api-webapp
ENV SQL_HOST=db
ENV SQL_PWD=

# Configure PHP for development.
# Switch to the production php.ini for production operations.
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
# https://github.com/docker-library/docs/blob/master/php/README.md#configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"