<?php
declare(strict_types=1);
namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Usuario;
use PDO;

class UsuarioRepository implements RepositoryInterface
{
    public const TABLE = 'tb_usuario';
    public PDO $pdo;
    public function __construct()
    {
        $this->pdo = DatabaseConnection::abrirConexao();
    }
    public function buscarTodos(): iterable
    {
        $sql = 'SELECT * FROM '.self::TABLE;
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, Usuario::class);
    }
    public function buscarUm(string $id): ?object
    {
        $sql = "SELECT * FROM ".self::TABLE." WHERE id ='{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchObject(Usuario::class);
    }
    public function buscarUmPorEmail(string $email): Usuario | bool
    {
        $sql = "SELECT * FROM ".self::TABLE." WHERE email='{$email}'";
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchObject(Usuario::class);
    }
    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO ".self::TABLE."(nome, email, senha, perfil) "."VALUES ('{$dados->nome}','{$dados->email}','{$dados->senha}','{$dados->perfil}');";
        $this->pdo->query($sql);
        return $dados;
    }
    public function atualizar(object $novosDados, string $id): object
    {
        $sql = "UPDATE ".self::TABLE." SET
        nome = '{$novosDados->nome}',
        email = '{$novosDados->nome}',
        senha = '{$novosDados->nome}',
        perfil = '{$novosDados->nome}'
        WHERE id = '{$id}';";
        $this->pdo->query($sql);
        return $novosDados;
    }
    public function excluir(string $id): void
    {
        $sql = "DELETE FROM ".self::TABLE." WHERE id = '{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
    }
}