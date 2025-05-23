build:
	docker build -t biz-linker-php -f ./docker/app/Dockerfile . && docker build -t biz-linker-reverb-php -f ./docker/reverb/Dockerfile .

dev:
	docker compose up -d

prod:
	docker compose -f compose.prod.yml up -d

down:
	docker compose down

cli:
	docker compose exec app bash

logs:
	docker compose logs

fetch:
	git fetch && git reset --hard origin/main && git pull
