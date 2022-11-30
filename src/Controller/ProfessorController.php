<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Professor;
use App\Repository\AlunoRepository;
use App\Repository\ProfessorRepository;
use Dompdf\Dompdf;
use Exception;

class ProfessorController extends AbstractController
{
    private ProfessorRepository $repository;
    public function __construct()
    {
        $this->repository = new ProfessorRepository();
    }
    public function listar(): void
    {
        // $this->checarLogin();
        $professores = $this->repository->buscarTodos();
        $this->render('professor/listar', [
            'professores'=>$professores,
        ]);
    }
    public function cadastrar(): void
    {
        if(true === empty($_POST)){
            $this->render('professor/cadastrar');
            return;
        }
        $professor = new Professor();
        $professor->nome = $_POST['nome'];
        $professor->cpf = $_POST['cpf'];
        $professor->endereco = $_POST['endereco'];
        $professor->formacao = $_POST['formacao'];
        try{
            $this->repository->inserir($professor);
        }catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'cpf')){
                die('CPF já existe');
            }
        }
        $this->redirect('/professores/listar');
    }
    public function editar(): void
    {
        $id = $_GET['id'];
        $professor = $this->repository->buscarUm($id);
        $this->render('professor/editar', [$professor]);
        if(false === empty($_POST)){
            $professor->nome = $_POST['nome'];
            $professor->cpf = $_POST['cpf'];
            $professor->endereco = $_POST['endereco'];
            $professor->formacao = $_POST['formacao'];
            try{
                $this->repository->atualizar($professor, $id);
            } catch(Exception $exception){
                if(true === str_contains($exception->getMessage(), 'cpf')){
                    die('CPF já existe');
                }
            }
        $this->redirect('/professores/listar');
        }
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('professor/excluir');
        $this->redirect("/professores/listar");
    }
    private function renderizar(iterable $professores)
    {
        $resultado = '';
        foreach($professores as $professor){
            $resultado .= "
            <tr>
                <td>{$professor->id}</td>
                <td>{$professor->nome}</td>
                <td>{$professor->cpf}</td>
                <td>{$professor->endereco}</td>
                <td>{$professor->status}</td>
                <td>{$professor->formacao}</td>
            </tr>
            ";
            return $resultado;
        }
    }
    public function relatorio(): void
    {
        $hoje = date('d/m/Y');
        $professores = $this->repository->buscarTodos();
        $design =  "
            <h1>Relatorio de Alunos</h1>
            <hr>
            <em>Gerado em {$hoje}</em>
            <br>
            <table border='1' width='100%' style='margin-top: 30px;'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Endereço</th>
                        <th>Status</th>
                        <th>Formação</th>
                    </tr>
                </thead>
                <tbody>
                ".$this->renderizar($professores)."
                </tbody>
            </table>
        ";
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4','portrait');
        $dompdf->loadHtml($design);
        $dompdf->render();
        $dompdf->stream('relatorio-professor.pdf', ['Attachment'=> 0,]);
    }
}