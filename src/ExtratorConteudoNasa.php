<?php

namespace ImersaoJava;

class ExtratorConteudoNasa implements ExtratorConteudo
{
    public function extraiConteudos(string $json): array
    {
        $respostaParseada = json_decode($json);

        return array_map(fn (object $item) => new Conteudo($item->title, $item->url), $respostaParseada);
    }
}
