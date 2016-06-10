FROM tutum/apache-php
RUN rm -fr /app
ADD ./app /app

VOLUME /app/assets
RUN chown -R www-data:www-data /app/assets