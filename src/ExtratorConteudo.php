<?php

namespace ImersaoJava;

interface ExtratorConteudo
{
    /** @return Conteudo[] */
    public function extraiConteudos(string $json): array;
}
