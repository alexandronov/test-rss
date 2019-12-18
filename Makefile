DOCKER_COMPOSE ?= docker-compose
RUN_PHP ?= $(DOCKER_COMPOSE) run --rm --no-deps php-fpm
RUN_COMPOSER = $(RUN_PHP) composer

all: envfile up composer-install db-migrate
.PHONY: all

up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

envfile:
	if [ ! -f .env ]; then cp .env.dist .env; fi;
.PHONY: envfile

composer-install:
	$(RUN_COMPOSER) install
.PHONY: composer-install

db-migrate:
	$(RUN_PHP) bin/console doctrine:migrations:migrate -n
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
