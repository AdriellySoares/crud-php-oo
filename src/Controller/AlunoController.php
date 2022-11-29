<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Aluno;
use App\Repository\AlunoRepository;
use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;
use Exception;

class AlunoController extends AbstractController
{
    private AlunoRepository $repository;
    public function __construct()
    {
        $this->repository = new AlunoRepository;
    }

    public function listar() : void
    {
        if(!UsuarioSecurity::estaLogado()){
            die('Precisa estar logado');
        }
        $this->renderizar('aluno/listar', [
            'alunos' => $this->repository->buscarTodos()
        ]);
    }

    public function novo() : void
    {
        if(empty($_POST)){
            $this->renderizar('aluno/novo');
            return;
        }

        $aluno = new Aluno();
        $aluno->nome = $_POST['nome'];
        $aluno->cpf = $_POST['cpf'];
        $aluno->email = $_POST['email'];
        $aluno->genero = $_POST['genero'];
        $aluno->dataNascimento = $_POST['dataNascimento'];
        
        try{
            $this->repository->inserir($aluno);
        } catch(Exception $exception){
            if(str_contains($exception->getMessage(), 'cpf')){
                die('CPF já existe');
            }
            if(str_contains($exception->getMessage(), 'email')){
                die('Email já existe');
            }

            die('Vish, aconteceu um erro');
        }
        $this->redirecionar('alunos/listar');      
    }

    public function editar() : void
    {
        $id = $_GET['id'];
        $aluno = $this->repository->buscarUm($id);
        $this->renderizar('aluno/editar', [$aluno]);
        if(!empty($_POST)){
            $aluno->nome = $_POST['nome'];
            $aluno->cpf = $_POST['cpf'];
            $aluno->email = $_POST['email'];
            $aluno->genero = $_POST['genero'];
            $aluno->dataNascimento = $_POST['dataNascimento'];
            try{
                $this->repository->atualizar($aluno, $id);
            } catch(Exception $exception){
                if(str_contains($exception->getMessage(), 'cpf')){
                    die('CPF já existe');
                }
                if(str_contains($exception->getMessage(), 'email')){
                    die('Email já existe');
                }
    
                die('Vish, aconteceu um erro');
            }
            $this->redirecionar('alunos/listar');
        }
    }

    public function excluir() : void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        
        $this->redirecionar('alunos/listar');
    }
    
    public function relatorio() : void
    {
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = date('d/m/Y, H:i:s');
        $alunos = $this->repository->buscarTodos();
        $corpoTabela = '';
        $estaMatriculado = 'Não matriculado';
        
        foreach($alunos as $cadaAluno){
            $inverterData = array_reverse(explode('-',$cadaAluno->dataNascimento));
            $dataNascimento = implode('/',$inverterData);
            if($cadaAluno->status == 1){
                $estaMatriculado = 'Matriculado';
            }
            $corpoTabela .= "
                <tr>
                    <td>{$cadaAluno->id}</td>
                    <td>{$cadaAluno->nome}</td>
                    <td>{$cadaAluno->cpf}</td>
                    <td>{$cadaAluno->matricula}</td>
                    <td>{$cadaAluno->email}</td>
                    <td>{$estaMatriculado}</td>
                    <td>{$cadaAluno->genero}</td>
                    <td>{$dataNascimento}</td>
                </tr>
            ";
        }
        $design = "
            <h1>Relatorio de Alunos</h1>
            <em>Gerado em {$hoje}</em>
            <hr>
            <table border='1' width='100%' style='margin-top: 30px; text-align:center;'>
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Matricula</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th>Gênero</th>
                    <th>Data de nascimento</th>
                </thead>
                <tbody>" 
                .
                $corpoTabela 
                .
                "</tbody>
            </table>"; 

        $dompdf = new Dompdf();

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($design);
        $dompdf->render();
        $dompdf->stream('relatorio-de-alunos.pdf', ['Attachment' => 0]);
    }
}