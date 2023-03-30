<?php

namespace ImersaoJava;

use Imagick;
use ImagickDraw;
use ImagickPixel;

readonly class GeradorFigurinha
{
    public function __construct(private string $pastaSaida)
    {
        if (!is_dir($this->pastaSaida)) {
            mkdir($this->pastaSaida);
        }
    }

    public function geraFigurinha(string $caminhoImagem, string $texto): void
    {
        $imagemOriginal = new Imagick($caminhoImagem);
        [$novaLargura, $novaAltura] = $this->redimensionaImagemOriginal($imagemOriginal);

        // Cria a nova imagem com fundo transparente e 100px a mais de altura
        $novaImagem = new Imagick();
        $novaImagem->newImage(
            $novaLargura,
            $novaAltura + 100,
            new ImagickPixel('transparent'),
            'png'
        );
        // Adiciona a imagem original a essa nova imagem
        $novaImagem->compositeImage($imagemOriginal, Imagick::COMPOSITE_ADD, 0, 0);

        // Obtém as dimensões da caixa do texto
        $definicoesDeFonte = $this->definicoesDeFonte();
        $caixaDeTexto = $novaImagem->queryFontMetrics($definicoesDeFonte, $texto);
        $larguraDoTexto = $caixaDeTexto['textWidth'];
        // Escreve na nova imagem
        $posicaoHorizontal = ($novaLargura - $larguraDoTexto) / 2;
        $novaImagem->annotateImage($definicoesDeFonte, $posicaoHorizontal, $novaAltura, 0, $texto);

        // Salva a nova imagem
        $imagemSaida = $this->pastaSaida . '/' . basename($caminhoImagem, '.jpg') . '.png';
        $novaImagem->writeImage($imagemSaida);
    }

    /**
     * @param Imagick $imagemOriginal
     * @return array{0: int, 1: float} Largura no primeiro índice e altura no segundo
     * @throws \ImagickException
     */
    private function redimensionaImagemOriginal(Imagick $imagemOriginal): array
    {
        $larguraOriginal = $imagemOriginal->getImageWidth();
        $alturaOriginal = $imagemOriginal->getImageHeight();

        $novaLargura = min($larguraOriginal, 500);
        $proporcao = $novaLargura / $larguraOriginal;
        $novaAltura = intval($alturaOriginal * $proporcao);

        $imagemOriginal->resizeImage($novaLargura, $novaAltura, Imagick::FILTER_POINT, 0);

        return [$novaLargura, $novaAltura];
    }

    private function definicoesDeFonte(): ImagickDraw
    {
        $definicoes = new ImagickDraw();
        $definicoes->setFont(__DIR__ . '/../impact.ttf');
        $definicoes->setFillColor(new ImagickPixel('#9b870c'));
        $definicoes->setFontSize(64);
        $definicoes->setGravity(Imagick::GRAVITY_NORTHWEST);
        $definicoes->setStrokeColor(new ImagickPixel('black'));
        $definicoes->setStrokeWidth(2);

        return $definicoes;
    }
}
