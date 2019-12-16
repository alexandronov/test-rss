-include .env

DOCKER_COMPOSE ?= docker-compose
RUN_PHP ?= $(DOCKER_COMPOSE) run --rm --no-deps php-fpm
RUN_COMPOSER = $(RUN_PHP) composer

envfile:
	if [ ! -f .env ]; then cp .env.dist .env; fi;
.PHONY: envfile

composer-install:
	$(RUN_COMPOSER) install
.PHONY: composer-install

db-migrate:
	$(RUN_PHP) bin/console doctrine:migrations:migrate
.PHONY: db-migrate

ssh:
	$(RUN_PHP) sh
.PHONY: ssh

clean:
	$(DOCKER_COMPOSE) down -v --remove-orphans
.PHONY: clean

test:
	$(RUN_PHP) vendor/bin/codecept run -vv
.PHONY: test
