FROM php:8.2-fpm-alpine

RUN apk --update --no-cache add $PHPIZE_DEPS \
        build-base \
        libtool \
		freetype-dev \
		git \
		libjpeg-turbo-dev \
		libpng-dev \
		libxml2-dev \
		libzip-dev \
		openssh-client \
		imagemagick \
		imagemagick-libs \
		imagemagick-dev \
        zlib-dev \
        zlib \
        icu-dev \
        gnu-libiconv \
        tzdata

RUN docker-php-ext-install exif bcmath pdo_mysql mysqli zip pcntl
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-configure gd --with-jpeg --with-freetype && docker-php-ext-install gd

RUN pecl channel-update pecl.php.net
RUN pecl install apcu && docker-php-ext-enable apcu
RUN pecl install imagick-3.7.0 && docker-php-ext-enable imagick

# TimeZone
ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
#RUN /usr/local/bin/composer install -n --no-cache -d /var/www

ENV PHP_EXTRA_CONFIGURE_ARGS --enable-fpm
WORKDIR /var/www
CMD ["php-fpm"]
