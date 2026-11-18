<?php

class Livro
{
    public $id;
    public $titulo;
    public $autor;
    public $ano;
    public $imagem;
    public $pdf;

    public function __construct($id = null, $titulo = null, $autor = null, $ano = null, $imagem = null, $pdf = null)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->ano = $ano;
        $this->imagem = $imagem;
        $this->pdf = $pdf;
    }
}
