FROM php:7.4.33-apache

WORKDIR /app

COPY . .

RUN compose install

# symfony server:start --port=8000 -d
CMD ['symphony'] ['server:start'] ['--port=8000']

EXPOSE 8000
