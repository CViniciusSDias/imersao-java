<?php

declare(strict_types=1);

namespace ImersaoJava;

class FabricaDeExtrator
{
    public static function criaExtrator(string $url): ?ExtratorConteudo
    {
        $mapaDeOcorrencias = [
            'Movies' => ExtratorConteudoImdb::class,
            'NASA' => ExtratorConteudoNasa::class,
        ];

        foreach ($mapaDeOcorrencias as $ocorrencia => $classe) {
            if (stripos($url, $ocorrencia) !== false) {
                return new $classe();
            }
        }

        return null;
    }
}
