<?php

namespace ImersaoJava;

use Imagick;
use ImagickDraw;
use ImagickPixel;

class GeradorFigurinha
{
    public function __construct(private readonly string $pastaSaida)
    {
        if (!is_dir($this->pastaSaida)) {
            mkdir($this->pastaSaida);
        }
    }

    public function geraFigurinha(string $caminhoImagem, string $texto): void
    {
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
        $novaImagem->annotateImage($this->definicoesDeFonte(), 0, $alturaOriginal + 75, 0, $texto);

        // Salva a nova imagem
        $imagemSaida = $this->pastaSaida . '/' . basename($caminhoImagem, '.jpg') . '.png';
        $novaImagem->writeImage($imagemSaida);
    }

    private function definicoesDeFonte(): ImagickDraw
    {
        $definicoes = new ImagickDraw();
        $definicoes->setFont('/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf');
        $definicoes->setFillColor(new ImagickPixel('#9b870c'));
        $definicoes->setFontSize(64);

        return $definicoes;
    }
}
