build:
	docker build -t biz-linker-php -f ./docker/app/Dockerfile . && docker build -t biz-linker-reverb-php -f ./docker/reverb/Dockerfile .

up:
	docker compose up -d

down:
	docker compose down

cli:
	docker compose exec app bash

logs:
	docker compose logs
