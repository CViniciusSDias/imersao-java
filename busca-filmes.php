<?php

use ImersaoJava\FabricaDeExtrator;
use ImersaoJava\GeradorFigurinha;

require_once 'vendor/autoload.php';

// Define a URL padrão 50% das vezes para a do IMDB e 50% das vezes para a da NASA
$urlPadrao = rand() % 2 === 0
    ? 'https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/TopMovies.json'
    : 'https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/NASA-APOD.json';
// Usa a URL padrão somente se a variável de ambiente não estiver definida
$url = $_SERVER['API_ENDPOINT'] ?? $urlPadrao;

$resposta = file_get_contents($url);
$extrator = FabricaDeExtrator::criaExtrator($url);
if (is_null($extrator)) {
    echo 'URL não reconhecida' . PHP_EOL;
}

$respostaParseada = $extrator->extraiConteudos($resposta);

// Definições de estilo
$gerador = new GeradorFigurinha(__DIR__ . '/saida');
// Exibição dos dados recuperados
foreach ($respostaParseada as $conteudo) {
    echo "\u{001b}[1mTítulo:\u{001b}[m {$conteudo->titulo}" . PHP_EOL;
    $gerador->geraFigurinha($conteudo->urlImagem, "Imersão Java");
}
