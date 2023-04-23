# Defino o nome da imagem utilizada no projeto
APP_IMAGE := app

# Defino o nome do container utilizado no projeto
APP_CONTAINER := productparser_app

# Defino o nome de container do banco de dados
DB_CONTAINER := productparser_pgsql

# Defino a regra padrão executada pelo comando 'make'
.DEFAULT_GOAL := help

help: ## Mostra a lista de comandos deste projeto
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

fix-permissions: ## Atualiza as permisões nas pastas e arquivos do projeto
	sudo chmod -R a+rwx .

up: ## Subo a imagem do projeto e disponibilizo para acesso, travando o terminal
	docker compose up

up-in-background: ## Subo a imagem do projeto e disponibilizo para acesso, liberando o terminal após execução
	docker compose up -d

down: ## Derrubo todas as imagens de pé relacionadas ao projeto
	docker compose down --remove-orphans

build:  ## Preparo e subo o ambiente
	docker compose up --build

install: ## Instalo as dependências do projeto
	docker compose run --rm -it $(APP_IMAGE) composer install

delete-packages: ## Deleto as dependências do projeto
	sudo rm -rf ./src/vendor

reset-environment: delete-packages prepare-environment ## Restauro o projeto

access-app: ## Acesso o terminal do container do App
	docker exec -it $(APP_CONTAINER) bash

access-db: ## Acesso o terminal do container do DB
	docker exec -it $(DB_CONTAINER) bash

prepare-environment: install up-in-background fix-permissions migrate-db ## Preparo e executo o projeto

migrate-db: ## Migra as tabelas necessárias para o banco de dados
	docker compose run --rm -it $(APP_IMAGE) php artisan migrate

migrate-reverse-db: ## Deleta as tabelas migradas pelo app no Banco
	docker compose run --rm -it $(APP_IMAGE) php artisan migrate:reset

config-cron: ## Configuro a cron no container
	docker exec $(APP_CONTAINER) sh -c '(crontab -l 2>/dev/null; echo "*/1 * * * * /cron/cronStart.sh") | crontab -'

start-cron: ## Inicializo o serviço da cron no container
	docker exec $(APP_CONTAINER) service cron start

init-cron: config-cron start-cron ## Configuro e subo a cron no container

check-cron: ## Checa se o serviço da cron está de pé e funcional
	docker exec $(APP_CONTAINER) sh -c 'ps -ef | grep cron | grep -v grep'