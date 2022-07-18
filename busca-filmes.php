<?php

// Requisição para a API
$url = 'https://alura-filmes.herokuapp.com/conteudos';

$resposta = file_get_contents($url);
$respostaParseada = json_decode($resposta);

// Definições de estilo
$semEstilo = "\u{001b}[m";
$negrito = "\u{001b}[1m";
$corClassificacao = "\u{001b}[37m\u{001b}[45m";

// Exibição dos dados recuperados
foreach ($respostaParseada->items as $filme) {
    $estrelas = notaParaEstrelas($filme->imDbRating);

    echo <<<FIM
    {$negrito}Título:{$semEstilo} $filme->title
    {$negrito}Poster:{$semEstilo} $filme->image
    {$negrito}{$corClassificacao}Classificação: {$filme->imDbRating}{$semEstilo}
    $estrelas
    
    
    FIM;
}

function notaParaEstrelas(float $nota): string
{
    $emojiEstrela = "\u{2B50}";
    $arrayEstrelas = array_fill(0, round($nota), $emojiEstrela);

    return implode('', $arrayEstrelas);
}