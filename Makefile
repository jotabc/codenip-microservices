
help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start-all: ## Runs all services: RabbitMQ, register, application and mailer
	make -C rabbitmq start
	make -C register start
	make -C application start
	make -C mailer start
	$(MAKE) prepare-all

prepare-all: ## Install dependencies and run migrations in all services
	make -C register prepare
	make -C application prepare
	make -C mailer prepare

stop-all: ## Stop all services: RabbitMQ, register, application and mailer
	make -C rabbitmq stop
	make -C register stop
	make -C application stop
	make -C mailer stop

build-all: ## Build all services RabbitMQ, register, application and mailer
	make -C register build
	make -C application build
	make -C mailer build

restart-all: ## Restart all services RabbitMQ, register, application and mailer
	make -C rabbitmq build
	make -C register build
	make -C application build
	make -C mailer build

ssh-register: ## bash into Register Service PHP container
	make -C register ssh-be

ssh-application: ## bash into Application Service PHP container
	make -C application ssh-be

ssh-mailer: ## bash into Mailer Service PHP container
	make -C mailer ssh-be
