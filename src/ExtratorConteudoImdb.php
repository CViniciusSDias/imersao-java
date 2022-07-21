<?php

namespace ImersaoJava;

class ExtratorConteudoImdb implements ExtratorConteudo
{
    /** @return Conteudo[] */
    public function extraiConteudos(string $json): array
    {
        $respostaParseada = json_decode($json);

        return array_map(
            fn (object $filme) => new Conteudo(
                $filme->title,
                preg_replace('/(@+)(.*).jpg$/', '$1.jpg', $filme->image)
            ),
            $respostaParseada->items
        );
    }
}
