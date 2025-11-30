set -o allexport
source .env
set +o allexport

docker-compose exec db_mysql mysql -u heavy_apps -p${DB_MYSQL_PASSWORD} heavy_apps