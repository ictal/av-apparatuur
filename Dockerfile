FROM tutum/apache-php
RUN rm -fr /app
ADD ./app /app

RUN sed 's/^upload_max_filesize = 2M$/upload_max_filesize = 64M/' /etc/php5/apache2/php.ini > /etc/php5/apache2/php.ini

VOLUME /app/assets
RUN chown -R www-data:www-data /app/assets