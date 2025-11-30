git pull
docker-compose exec -T web_php php yii migrate --interactive=0
docker-compose exec -T web_php php yii cache/flush-all
docker-compose exec -T web_php composer install
docker-compose exec -T web_php bash -c "php yii crontab | crontab -u www-data -"
docker-compose exec -T web_php bash -c "php yii queue/supervisor > /etc/supervisor/conf.d/project.conf"
docker-compose exec -T web_php bash -c "supervisorctl update"
docker-compose exec -T web_php bash -c "supervisorctl restart all"
