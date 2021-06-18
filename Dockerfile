FROM ubuntu
MAINTAINER allens
ENV REFRESHED 2021-06-18
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.UTF-8
ENV LC_ALL en_US.UTF-8
RUN apt update && apt install -y language-pack-en-base software-properties-common tar lrzsz curl wget vim htop git && locale-gen en_US.UTF-8 && add-apt-repository ppa:ondrej/php -y
RUN apt update && apt install -y php7.0 php7.0-mysql php7.0-curl php7.0-xml php7.0-mcrypt php7.0-gd php7.0-mbstring php7.0-fpm
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN echo  'mysql-server mysql-server/root_password password root' | debconf-set-selections
RUN echo  'mysql-server mysql-server/root_password_again password root' | debconf-set-selections
RUN apt install -y mysql-server nginx
RUN sed -i s/^\;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g /etc/php/7.0/fpm/php.ini
COPY ./.env.docker ./.env
ADD ./nginx/default /etc/nginx/sites-available/default
ADD ./ /var/www/
RUN chown -R www-data:www-data /var/www
EXPOSE 22 80 443
