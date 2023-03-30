<?php

use ImersaoJava\ExtratorConteudoImdb;
use ImersaoJava\ExtratorConteudoNasa;
use ImersaoJava\GeradorFigurinha;
use parallel\Runtime;

require_once 'vendor/autoload.php';

$runtime = new Runtime(__DIR__ . '/vendor/autoload.php');
$future = $runtime->run(function () {
    $imdbEndpoint = $_SERVER['IMDB_API_ENDPOINT'] ?? 'https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/TopMovies.json';
    $respostaImdb = file_get_contents($imdbEndpoint);
    $extratorImdb = new ExtratorConteudoImdb();
    $filmes = $extratorImdb->extraiConteudos($respostaImdb);

    $geradorFigurinha = new GeradorFigurinha(__DIR__ . '/saida');
    foreach ($filmes as $conteudo) {
        echo "\u{001b}[1mTítulo do filme:\u{001b}[m {$conteudo->titulo}" . PHP_EOL;
        $geradorFigurinha->geraFigurinha($conteudo->urlImagem, "Imersão Java");
    }
});

$nasaEndpoint = $_SERVER['NASA_API_ENDPOINT'] ?? 'https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/NASA-APOD.json';
$respostaNasa = file_get_contents($nasaEndpoint);
$extratorNasa = new ExtratorConteudoNasa();

$fotos = $extratorNasa->extraiConteudos($respostaNasa);

$gerador = new GeradorFigurinha(__DIR__ . '/saida');
foreach ($fotos as $conteudo) {
    echo "\u{001b}[1mTítulo da NASA:\u{001b}[m {$conteudo->titulo}" . PHP_EOL;
    $gerador->geraFigurinha($conteudo->urlImagem, "Imersão Java");
}
