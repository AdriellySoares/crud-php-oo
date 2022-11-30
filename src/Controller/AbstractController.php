<?php
declare(strict_types=1);
namespace App\Controller;

use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;
use Dompdf\Options;

abstract class AbstractController
{
    public function render(string $view, ?array $dados = [], bool $navbar = true): void
    {
        extract($dados);
        include_once '../views/template/header.phtml';
        $navbar === true && include_once '../views/template/menu.phtml';
        include_once "../views/{$view}.phtml";
        include_once '../views/template/footer.phtml';
    }
    public function redirect(string $local): void
    {
        header('location: '.$local);
    }
    // public function checarLogin()
    // {
    //     if(UsuarioSecurity::estaLogado()===false){
    //         $this->redirect('/login');
    //     }
    // }
}