<?php
declare(strict_types=1);
namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Professor;
use PDO;

class ProfessorRepository implements RepositoryInterface
{
    public const TABLE = 'tb_professores';
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
        return $query->fetchAll(PDO::FETCH_CLASS, Professor::class);
    }
    public function buscarUm(string $id): object
    {
        $sql = "SELECT * FROM ".self::TABLE." WHERE id ='{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchObject(Professor::class);
    }
    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO ".self::TABLE ."(nome, cpf, endereco, status, formacao) "."VALUES ('{$dados->nome}', '{$dados->cpf}', '{$dados->endereco}', '1', '{$dados->formacao}' );";
        $this->pdo->query($sql);
        return $dados;
    }
    public function atualizar(object $novosDados, string $id): object
    {
        $sql = "UPDATE ". self::TABLE ." SET
            nome='{$novosDados->nome}',
            cpf='{$novosDados->cpf}',
            endereco='{$novosDados->endereco}',
            formacao='{$novosDados->formacao}'
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