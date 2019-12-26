FROM nginx:1.17.0-alpine

MAINTAINER Shpak

ADD nginx.conf /etc/nginx/
ADD symfony.conf /etc/nginx/conf.d/

RUN rm /etc/nginx/conf.d/default.conf
RUN ln -s /etc/nginx/conf.d/symfony.conf /etc/nginx/conf.d/default.conf

RUN echo "upstream php-upstream { server app:9000; }" > /etc/nginx/conf.d/upstream.conf

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
