<?php

namespace ImersaoJava;

readonly class Conteudo
{
    public function __construct(
        public string $titulo,
        public string $urlImagem,
    ) { }
}
