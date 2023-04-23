# Product Parser

# Descrição
O projeto em questão representa um site de consulta, inclusão e checagem de nomes de produtos com base no [Open Food Facts](https://br.openfoodfacts.org/data).

O projeto foi feito de forma simplória e contém somente uma tela, buscando simplificar o objetivo final.

# Ferramentas Utilizadas

Para este projeto, as seguintes ferramentas foram utilizadas:
* Docker
* PHP 8
* Apache
* Laravel 9
* PostgreSQL
* crontab (Linux)

# Instalação

Para instalar o projeto, os seguintes passos devem ser executados:
* Garantir que sua máquina contém `Docker (Linux)` ou `Docker Desktop e WSL 2 (Windows)` configurados
* Garantir que sua máquina tenha o `make` instalado
* Baixar o repositório para sua máquina local:
    ```
    git clone https://github.com/MarkosVP/product_parser.git
    ```
* Com o projeto baixado em sua máquina, execute o comando `make prepare-environment` e aguarde o projeto inicializar
* Acesse o projeto na [URL local](http://localhost:8080/home)

# Detalhes do projeto

Um ferramenta vital nesse projeto é o Makefile, utilizado para a modelagem de toda a estrutura. Diversos comando foram modelados para auxiliar na manipulação do projeto, incluindo uma estrutura de 'helper' que descreve os comandos, portanto, caso queira avaliar os comandos disponíveis, execute `make` ou `make help`

O projeto utiliza a estrutura de CRON do Linux para efetuar as chamadas automáticas para o Open Food Facts e atualizar sua base, para que esse fluxo funcione entretanto, é necessário que a cron seja ativada através do comando abaixo:
```
make init-cron
```
A CRON esta configurada para executar todo dia as 00:00:00, mas caso necessário, altere o arquivo `Makefile` do projeto (Função `config-cron`) e execute novamente o comando acima (Caso já tenha executado o init da cron, derrube o container e suba novamente, pois o comando só anexa a cron no arquivo, não substitui)

>  This is a challenge by [Coodesh](https://coodesh.com/)