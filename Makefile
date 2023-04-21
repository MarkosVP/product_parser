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

build: ## Recrio as imagens do projeto
	docker compose up --build

install: ## Instalo as dependências do projeto
	docker compose run --rm -it $(APP_CONTAINER) composer install

delete-packages: ## Deleto as dependências do projeto
	sudo rm -rf ./src/vendor

reset-environment: delete-packages install ## Restauro o projeto

access-app: ## Acesso o terminal do container do App
	docker exec -it $(APP_CONTAINER) bash

access-db: ## Acesso o terminal do container do DB
	docker exec -it $(DB_CONTAINER) bash