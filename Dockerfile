FROM mcr.microsoft.com/appsvc/wordpress-alpine-php:8.2
COPY ./wp-content/plugins /home/site/wwwroot/wp-content/plugins
