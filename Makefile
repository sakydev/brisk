MAKEFLAGS += --silent
#SHELL = /bin/bash -o pipefail

include .env

help:
	sed -rn 's/^([a-zA-Z0-9_-]+):.*?##(.*).*?## (.*)/'$$(tput setaf 99)'make '$$(tput setaf 99)$$(tput bold)'\1|'$$(tput setaf 96)'\2'$$(tput sgr0)'|\3/p' < $(or ${makefile}, Makefile) | sort | column -t -s "|"

start: ## ## Alias for docker-compose up -d redis varnish search
	docker-compose up -d redis varnish search


update: ## ## Shortcut to update repository
	docker-compose ps
	git pull
	docker-compose exec search composer install # install dependencies
	docker-compose exec search composer update # upgrade dependencies if available
	docker-compose exec search cp .env.example .env # changes are made to .env.example so copy
	docker-compose exec search vendor/bin/phpunit tests/search-tests # run unit tests
	docker-compose exec search php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
	docker-compose exec search php artisan l5-swagger:generate # generate swagger docs
	cd laravel-search && npm run docs:build # generate vuepress docs

docs:
	docker-compose exec search php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
	docker-compose exec search php artisan l5-swagger:generate
	cd laravel-search && npm run docs:build

normalizer: ## ## Run the normalizer process
	docker-compose run --rm search php artisan normalizer

phpunit:
	docker-compose exec search vendor/bin/phpunit tests/search-tests

