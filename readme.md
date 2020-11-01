https://github.com/guillaumebriday/laravel-blog

git clone https://github.com/guillaumebriday/laravel-blog.git
cd laravel-blog
cp .env.example .env
docker-compose run --rm --no-deps scrapper-server composer install
docker-compose run --rm --no-deps scrapper-server php artisan key:generate
docker-compose run --rm --no-deps scrapper-server php artisan storage:link
docker run --rm -it -v $(pwd):/app -w /app node yarn
docker-compose up -d

docker-compose run --rm --no-deps scrapper-server php composer.phar require intervention/image

f716883ddd58
# LARAVEL
docker-compose run --rm --no-deps scrapper-server php artisan make:controller
docker-compose run --rm --no-deps scrapper-server php artisan optimize
# REDIS
docker exec -it scrapper_redis_1 redis-cli