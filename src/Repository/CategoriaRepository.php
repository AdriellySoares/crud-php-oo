<?php 

declare(strict_types = 1);

namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Categoria;
use PDO;

class CategoriaRepository implements RepositoryInterface
{
    public const TABLE = 'tb_categorias';

    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = DatabaseConnection::abrirConexao();
    }

    public function buscarTodos() : iterable
    {
        $sql = "SELECT * FROM " . self::TABLE;
        $query = $this->conexao->query($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, Categoria::class);
    }

    public function buscarUm(string $id) : object
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE id=" . $id;
        $query = $this->conexao->query($sql);
        $query->execute();
    
        return $query->fetchObject(Categoria::class);       
    }

    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO " . self::TABLE . "(nome, email, senha, perfil) VALUES ('{$dados->nome}', '{$dados->email}', '{$dados->senha}', '{$dados->perfil}')";
        $this->conexao->query($sql);
        return $dados;
    }

    public function atualizar(object $novosDados, string $id): object
    {
        $sql = "UPDATE " . self::TABLE . 
        " SET nome='{$novosDados->nome}' WHERE id = '{$id}';
        ";

        $this->conexao->query($sql);

        return $novosDados;
    }

    public function excluir(string $id) : void
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id=" . $id;
        $query = $this->conexao->query($sql);
        $query->execute();
    }
}