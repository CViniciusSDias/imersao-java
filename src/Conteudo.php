<?php

namespace ImersaoJava;

class Conteudo
{
    public function __construct(
        public readonly string $titulo,
        public readonly string $urlImagem,
    )
    {
    }
}
