#!/bin/bash

OS = $(shell uname)
UID = $(shell id -u)
DOCKER_BE = codenip-ms-register-service-be
NAMESERVER_IP = $(shell ip address | grep docker0)

ifeq ($(OS),Darwin)
	NAMESERVER_IP = host.docker.internal
else ifeq ($(NAMESERVER_IP),)
	NAMESERVER_IP = $(shell grep nameserver /etc/resolv.conf | cut -d ' ' -f2)
else
	NAMESERVER_IP = 172.17.0.1
endif

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start: ## start containers
	docker network create codenip-microservices-network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	U_ID=${UID} docker-compose up -d

stop: ## stop containers
	U_ID=${UID} docker-compose stop

restart: ## restart containers
	$(MAKE) stop && $(MAKE) start

build: ## rebuild all containers
	docker network create codenip-microservices-network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	cp -n .env.dist .env || true
	U_ID=${UID} docker-compose build


prepare: ## prepare containers
	$(MAKE) composer-install
# Backend commands
composer-install: ## install composer dependencies
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install -no-interaction

be-logs: ## show backend logs
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} tail -f var/log/dev.log
# End backend commands

ssh-be: ## bash into the container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

code-style:
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix tests --rules=@Symfony


