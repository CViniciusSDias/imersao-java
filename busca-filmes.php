<?php

require_once 'vendor/autoload.php';

// Requisição para a API
$url = $_SERVER['API_ENDPOINT'] ?? 'https://alura-filmes.herokuapp.com/conteudos';

$resposta = file_get_contents($url);
/** @var \ImersaoJava\ExtratorConteudo $extrator */
$extrator = new \ImersaoJava\ExtratorConteudoImdb();
// $extrator = new \ImersaoJava\ExtratorConteudoNasa();
$respostaParseada = $extrator->extraiConteudos($resposta);

// Definições de estilo
$gerador = new \ImersaoJava\GeradorFigurinha(__DIR__ . '/saida');
// Exibição dos dados recuperados
foreach ($respostaParseada as $conteudo) {
    echo <<<FIM
    \u{001b}[1mTítulo:\u{001b}[m $conteudo->titulo
    
    FIM;
    $gerador->geraFigurinha($conteudo->urlImagem, $conteudo->titulo);
}
