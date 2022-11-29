<?php 

declare(strict_types = 1);

namespace App\Security;

use App\Model\Usuario;

abstract class UsuarioSecurity
{
    public static function desconectar() : void
    {
        session_destroy();
    }

    public static function estaLogado() : bool
    {
        return isset($_SESSION['usuario_escola']);
    }

    public static function seConectar(Usuario $usuario) : void
    {
        $usuario->senha = '';
        $_SESSION['usuario_escola'] = $usuario;
    }

    public static function capturarUsuarioLogado() : Usuario
    {
        return $_SESSION['usuario_escola'];
    }
}