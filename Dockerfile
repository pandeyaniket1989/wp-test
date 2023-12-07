FROM mcr.microsoft.com/appsvc/wordpress-alpine-php:8.2
ADD ./wp-content/plugins/webiwork-api-form /home/site/wwwroot/wp-content/plugins/webiwork-api-form
