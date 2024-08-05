<p align="center"><a href="https://www.php.net/" target="_blank"><img src="https://www.php.net//images/logos/new-php-logo.svg" width="200" alt="PHP Logo"></a></p>

# Desafio PHP - Criar uma API para Sorteios de Loteria

Este projeto é uma API REST desenvolvida para o desafio de desenvolvedor PHP.

** Tecnologias utilizadas
* PHP 8.2 Vanilla, Mysql, HTML, CSS, Javascript Vanilla, Docker e PHP Unit
* POO, SOLID, Clean Code

** O que ele faz
* Cadastra Tripulantes
* Cadastra Sorteios (bilhetes premiados)
* Gera bilhetes para cada tripulante, separado por sorteio
* Destaca numeros sorteados em cada jogo
* Salva todas as informações no banco de dados
* Possui teste coverage
* Possui front-end

** O que não tem
* Documentação com Swagger
* Sistema de autenticação como exemplo JWT
* Sistema de logs

** O que faltou fazer
* Finalizar a cobertura de testes em 100%


Nossa API vai ter endpoints que possibilitam
** Regras para API
* Criar uma API que gere um bilhete premiado. Os números deste bilhete serão 6 dezenas, que vão de 01 à 60. (ex.: 04, 09, 11, 23, 58, 60)
* Cada número não pode ser sorteado mais de uma vez e eles devem estar em ordem crescente.

** Regras para gerar bilhetes
* Criar uma função/método para gerar bilhetes para o tripulante. Nesta função é necessário informar a quantidade de bilhetes e de dezenas;
* Chamadas nessa função informando dados ausentes ou inválidos não devem ser permitidas, sendo necessário informar que a operação não foi concluída e assim retornar informações de erro, que serão tratadas e exibidas na interface;
* Desenvolver um método/função que confere todos os jogos gerados com o bilhete premiado pela API e retorna uma tabela HTML que irá conter todos jogos destacando quais dezenas foram sorteadas em cada jogo.
* Um tripulante pode solicitar até 50 bilhetes;
* A quantidade de dezenas deve ser informada pelo tripulante e pode variar de 6 a 10 dezenas;
* Todos os bilhetes vão ter o mesmo número de dezenas, seguindo a quantidade informada;

## Instalação

1. **Clone o Repositório:**
    ```bash
    git clone https://github.com/ocdigital/loteria-api.git
    ```

2. **Acesse o Diretório do Projeto:**
    ```bash
    cd loteria-api
    ```

3. **Faça o build e execute o projeto:**
    ```bash
    docker-compose build
    docker compose up -d
    
    ```

4. **Execute o composer para instalar o projeto:**
    ```bash
    composer install
    ```
    
5. **Execute o arquivo para criar as tabelas:**
    ```bash
    docker exec -it loteria-api-php-1 php run_migration.php
    ```
    
5. **Caso queira executar os testes**
    ```bash
    docker exec -it loteria-api-php-1 vendor/bin/phpunit --testdox
    ```
    
## Algumas informações

API: http://localhost:8080

FRONT: http://localhost:8080/front.

# Documentação da API REST

## Endpoints

### Tripulantes

#### Listar Tripulantes
- **Método:** GET
- **URL:** `http://localhost:8080/tripulantes`
- **Descrição:** Retorna a lista de todos os tripulantes.

#### Criar Tripulante
- **Método:** POST
- **URL:** `http://localhost:8080/tripulantes`
- **Descrição:** Cria um novo tripulante.
- **Corpo da Requisição:**
  ```json
  {
    "nome": "Eduardo12",
    "email": "eduardo12@teste.com.br"
  }
  
### Sorteios

#### Listar Sorteios
- **Método:** GET
- **URL:** `http://localhost:8080/sorteios`
- **Descrição:** Retorna a lista de todos os sorteios.

#### Criar Sorteio
- **Método:** POST
- **URL:** `http://localhost:8080/sorteios`
- **Descrição:** Cria um novo sorteio.
- **Corpo da Requisição:** (Vazio)

  ### Bilhetes

#### Listar Bilhetes
- **Método:** GET
- **URL:** `http://localhost:8080/bilhetes`
- **Descrição:** Retorna a lista de todos os bilhetes.

#### Criar Bilhete
- **Método:** POST
- **URL:** `http://localhost:8080/bilhetes`
- **Descrição:** Cria um novo bilhete.
- **Corpo da Requisição:**
  ```json
  {
    "sorteio_id": 1,
    "tripulante_id": 1,
    "quantidade_dezena": 6,
    "quantidade_bilhete": 5,
    "premiado": false
  }




