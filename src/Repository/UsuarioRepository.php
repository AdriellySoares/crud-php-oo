<?php 

declare(strict_types = 1);

namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Usuario;
use PDO;

class UsuarioRepository 
{
    public const TABLE = 'tb_usuarios';

    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = DatabaseConnection::abrirConexao();
    }

    public function buscarUmPeloEmail(string $email) : Usuario | bool
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE email='{$email}'";

        $query = $this->conexao->query($sql);
        $query->execute();
        return $query->fetchObject(Usuario::class);
    }
    public function buscarTodos() : iterable
    {
        $sql = "SELECT * FROM " . self::TABLE;
        $query = $this->conexao->query($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, Usuario::class);
    }

    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO " . self::TABLE . "(nome, email, senha, perfil) VALUES ('{$dados->nome}', '{$dados->email}', '{$dados->senha}', '{$dados->perfil}')";
        $this->conexao->query($sql);
        return $dados;
    }
}