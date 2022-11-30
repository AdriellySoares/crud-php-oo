<?php
declare(strict_types=1);
namespace App\Controller;

use App\Repository\UsuarioRepository;
use App\Security\UsuarioSecurity;

class AuthController extends AbstractController
{
    private UsuarioRepository $usuarioRepository;
    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }
    public function login(): void
    {
        if(false === empty($_POST)){
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $usuario = $this->usuarioRepository->buscarUmPorEmail($email);
            if(false === $usuario){
                die('Email não existe');
            }
            if(false === password_verify($senha, $usuario->senha)){
                die('Senha incorreta');
            }
            UsuarioSecurity::conectar($usuario);
            return;
        }
        $this->render('auth/login', navbar: false);
    }
    public function logout(): void
    {
        UsuarioSecurity::desconectar();
        $this->redirect('/login');
    }
}