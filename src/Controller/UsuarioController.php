<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\Usuario;
use App\Repository\UsuarioRepository;

class UsuarioController extends AbstractController
{
    private UsuarioRepository $repository;

    public function __construct()
    {
        $this->repository = new UsuarioRepository;
    }

    public function listar()
    {
        $usuarios = $this->repository->buscarTodos(); 
        $this->renderizar('usuario/listar', [
            'usuarios' => $usuarios
        ]);
    }

    public function novo()
    {
        if(empty($_POST)){
            $this->renderizar('usuario/novo');
            return;
        }

        $senha = password_hash($_POST['senha'], PASSWORD_ARGON2I);

        $usuario = new Usuario();
        $usuario->nome = $_POST['nome'];
        $usuario->email = $_POST['email'];
        $usuario->senha = $senha;
        $usuario->perfil = $_POST['perfil'];

        $this->repository->inserir($usuario);

        $this->redirecionar('usuarios/listar');
    }
}