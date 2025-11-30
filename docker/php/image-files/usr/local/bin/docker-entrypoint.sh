#!/bin/bash

# This script is run within the php containers on start

# Fail on any error
set -o errexit

# Set permissions based on ENV variable (debian only)
if [ -x "usermod" ] ; then
    usermod -u ${PHP_USER_ID} www-data
fi

chown -R www-data:www-data ./web/storage
chown -R www-data:www-data ./runtime
chown -R www-data:www-data ./web/assets

for f in $(find ./config/local/_docker -regex '.*\.php'); do envsubst < $f > "./config/local/$(basename $f)"; done

composer install

php yii migrate --interactive=0
php yii cache/flush cache --interactive=0
php yii clickhouse/dictionaries > ./docker/clickhouse/image-files/etc/clickhouse-server/dictionaries/configured.xml

php yii queue/supervisor > /etc/supervisor/conf.d/project.conf

service cron start
service supervisor start
supervisorctl update

php yii crontab/index | crontab -u www-data -

#php yii settings/geo/load

# Execute CMD
exec "$@"
