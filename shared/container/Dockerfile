FROM php:7.4.1-apache
COPY service/content/ /var/www/html/

ARG host_name

ENV UPLOAD_DIR=/tmp/
ENV HOST_NAME=$host_name
