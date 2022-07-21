# Imersão Java Alura

Desafios da imersão Java da Alura implementados em PHP.

## Ambiente

Para executar o projeto, há um _Dockerfile_. Sendo assim, com Docker instalado, basta executar:

```shell
docker build -t php-docker .
```

E para executar os exemplos:
```shell
docker run --rm -itv $(pwd):/app -w /app php-docker php busca-filmes.php
```

## API Endpoint

Na aula 1 foi implementada uma busca pelos principais filmes na API do IMDB.
Para usar um endpoint diferente do padrão ("https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/TopMovies.json"), basta definir a variável de ambiente `API_ENDPOINT`. Exemplo em ambientes Unix:

```shell
API_ENDPOINT="https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/TopMovies.json" php busca-filmes.php
```

Ou usando Docker:
```shell
docker run --rm -itv $(pwd):/app -w /app -e API_ENDPOINT="https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/TopMovies.json" php-docker php aula-1.php
>>>>>>> Gerando imagem com texto a partir do poster do filme
```
