include .env

help: ## This help.
	@echo "make [command]\n"
	@echo "Available commands:\n"
	@echo "init #Build the docker container"
	@echo "up #Start the docker container"
	@echo "cli #Connect into the docker container"

first: #Just for the first time execution
	make init

init: ## Build the container
	@docker-compose build
	make up

up: ## Start all services
	@docker-compose up
	echo "Server is running at http://0.0.0.0:8080"

down:
	@docker-compose down

cli:
	@docker-compose exec php /bin/bash
