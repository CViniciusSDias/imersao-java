<?php

// Requisição para a API
$url = $_SERVER['API_ENDPOINT'] ?? 'https://raw.githubusercontent.com/alura-cursos/imersao-java-2-api/main/TopMovies.json';

$resposta = file_get_contents($url);
$respostaParseada = json_decode($resposta);

// Definições de estilo
$semEstilo = "\u{001b}[m";
$negrito = "\u{001b}[1m";
$corClassificacao = "\u{001b}[37m\u{001b}[45m";
$emojiEstrela = "\u{2B50}";

// Exibição dos dados recuperados
foreach ($respostaParseada->items as $filme) {
    $estrelas = '';
    if (is_numeric($filme->imDbRating)) {
        $estrelas = str_repeat($emojiEstrela, round($filme->imDbRating));
    }

    echo <<<FIM
    {$negrito}Título:{$semEstilo} $filme->title
    {$negrito}Poster:{$semEstilo} $filme->image
    {$negrito}{$corClassificacao}Classificação: {$filme->imDbRating}{$semEstilo}
    $estrelas
    
    
    FIM;
}
