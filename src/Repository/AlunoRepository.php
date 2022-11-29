<?php 

declare(strict_types = 1);

namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Aluno;
use PDO;

class AlunoRepository implements RepositoryInterface
{

    public const TABLE = 'tb_alunos';
    public PDO $conexao;

    public function __construct()
    {
        $this->conexao = DatabaseConnection::abrirConexao();
    }

    public function buscarTodos(): iterable
    {
        $sql = 'SELECT * FROM ' . self::TABLE;

        $query = $this->conexao->query($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, Aluno::class);
    }
    
    public function buscarUm(string $id): object
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE id=" . $id;
        $query = $this->conexao->query($sql);
        $query->execute();

        return $query->fetchObject(Aluno::class);       
    }

    public function inserir(object $dados): object
    {
        $matricula = date('Ymd') . substr($dados->cpf, -2);
        $sql = "INSERT INTO " . self::TABLE . 
        "(nome, cpf, matricula, email, status, genero, dataNascimento) " . 
        "VALUES ('{$dados->nome}', '{$dados->cpf}', '{$matricula}', '{$dados->email}', '1', '{$dados->genero}', '{$dados->dataNascimento}');";

        $this->conexao->query($sql);

        return $dados;
    }

    public function atualizar(object $novosDados, string $id): object
    {
        $sql = "UPDATE " . self::TABLE . 
        " SET nome='{$novosDados->nome}', cpf='{$novosDados->cpf}', email='{$novosDados->email}', genero='{$novosDados->genero}', dataNascimento='{$novosDados->dataNascimento}'
        WHERE id = '{$id}';
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