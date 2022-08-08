FROM registry.gitlab.qsoft.ru/system-software/unit-php:7.4-prod
USER root
ADD ./docker/runit_entry /runit_entry
RUN apt update && apt install -y unzip runit php7.4-zip php7.4-mysql \
    && curl https://getcomposer.org/installer -o /tmp/composer  \
    && php /tmp/composer --install-dir=/var/www/app --filename=composer.phar --version=2.0.9 \
    && chmod a+x /runit_entry
USER www-data
WORKDIR /var/www/app
COPY ./ /var/www/app/
COPY ./docker/config.json /tmp/config.json
RUN ./composer.phar install --no-dev --optimize-autoloader
