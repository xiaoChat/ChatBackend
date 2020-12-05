FROM yexk/hyperf
##
# ---------- env settings ----------
##
# --build-arg timezone=Asia/Shanghai
ARG timezone

ENV TIMEZONE=${timezone:-"Asia/Shanghai"}

WORKDIR /opt/www

COPY . /opt/www

# update
RUN cd /etc/php7 \
    # - config PHP
    && { \
        echo "upload_max_filesize=100M"; \
        echo "post_max_size=108M"; \
        echo "memory_limit=1024M"; \
        echo "date.timezone=${TIMEZONE}"; \
    } | tee conf.d/99_overrides.ini \
    # - config timezone
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    # install vender
    && cd /opt/www && composer install --no-dev -o && php bin/hyperf.php \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

EXPOSE 9501

CMD ["php", "/opt/www/bin/hyperf.php", "start"]
