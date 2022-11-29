<?php

declare(strict_types = 1);

namespace App\Controller;

abstract class AbstractController
{
    public function renderizar(string $nomeDoArquivo, ?array $dados = null, bool $navbar = true) : void
    {
        if(isset($dados)){
            extract($dados);
        }
        include_once dirname(__DIR__) . "../../views/template/head.phtml";
        $navbar === true && include_once dirname(__DIR__) . "../../views/template/navbar.phtml";
        include_once dirname(__DIR__) . "../../views/{$nomeDoArquivo}.phtml";
        include_once dirname(__DIR__) . "../../views/template/foot.phtml";
    }

    public function redirecionar(string $onde) : void
    {
        header("Location:/{$onde}");
        exit();
    }
}