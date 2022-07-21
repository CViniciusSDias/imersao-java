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

    $imagem = imagemSemTamanho($filme->image);
    echo <<<FIM
    {$negrito}Título:{$semEstilo} $filme->title
    {$negrito}Poster:{$semEstilo} $imagem
    {$negrito}{$corClassificacao}Classificação: {$filme->imDbRating}{$semEstilo}
    $estrelas
    
    
    FIM;
    criaFigurinha($imagem);
}

function criaFigurinha(string $caminhoImagem): string
{
    // Cria a pasta saída se ainda não existir
    $caminhoSaida = __DIR__ . '/saida';
    if (!is_dir($caminhoSaida)) {
        mkdir($caminhoSaida);
    }

    // Lê a imagem original (seja de arquivo ou URL)
    $imagemOriginal = new Imagick($caminhoImagem);
    $larguraOriginal = $imagemOriginal->getImageWidth();
    $alturaOriginal = $imagemOriginal->getImageHeight();

    // Cria a nova imagem com fundo transparente e 100px a mais de altura
    $novaImagem = new Imagick();
    $novaImagem->newImage(
        $larguraOriginal,
        $alturaOriginal + 100,
        new ImagickPixel('transparent')
    );
    // Adiciona a imagem original a essa nova imagem
    $novaImagem->compositeImage($imagemOriginal, Imagick::COMPOSITE_ADD, 0, 0);

    // Escreve na nova imagem
    $definicoesDaFonte = new ImagickDraw();
    $definicoesDaFonte->setFont('/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf');
    $definicoesDaFonte->setFillColor(new ImagickPixel('#9b870c'));
    $definicoesDaFonte->setFontSize(64);
    $novaImagem->annotateImage($definicoesDaFonte, 0, $alturaOriginal + 75, 0, 'Texto de teste');

    // Salva a nova imagem
    $imagemSaida = $caminhoSaida . '/' . basename($caminhoImagem, '.jpg') . '.png';
    $novaImagem->writeImage($imagemSaida);

    return $imagemSaida;
}

function imagemSemTamanho(string $caminhoCompletoImagem): string
{
    return preg_replace('/\@(.*)\.jpg/', '@.jpg', $caminhoCompletoImagem);
}