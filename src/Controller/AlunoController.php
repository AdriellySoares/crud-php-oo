<?php
declare(strict_types=1);
namespace App\Controller;
use App\Model\Aluno;
use App\Repository\AlunoRepository;
use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

class AlunoController extends AbstractController
{
    private AlunoRepository $repository;
    public function __construct()
    {
        $this->repository = new AlunoRepository();
    }
    public function listar(): void
    {
        // $this->checarLogin();
        $alunos = $this->repository->buscarTodos();
        $this->render('aluno/listar', [
            'alunos'=>$alunos,
        ]);
    }
    public function cadastrar(): void
    {
        // $this->checarLogin();
        if(true === empty($_POST)){
            $this->render('aluno/cadastrar');
            return;
        }
        $aluno = new Aluno();
        $aluno->nome = $_POST['nome'];
        $aluno->dataNascimento = $_POST['nascimento'];
        $aluno->cpf = $_POST['cpf'];
        $aluno->email = $_POST['email'];
        $aluno->genero = $_POST['genero'];
        try{
            $this->repository->inserir($aluno);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'cpf')){
                die('CPF já existe');
            }
            if(true === str_contains($exception->getMessage(), 'email')){
                die('Email já existe');
            }
            die('Vish, aconteceu um erro');
        }
        $this->redirect('/alunos/listar');
    }
    public function editar(): void
    {
        // $this->checarLogin();
        $id = $_GET['id'];
        $aluno = $this->repository->buscarUm($id);
        $this->render('aluno/editar', [$aluno]);
        if (false === empty($_POST)) {
            $aluno->nome = $_POST['nome'];
            $aluno->dataNascimento = $_POST['nascimento'];
            $aluno->cpf = $_POST['cpf'];
            $aluno->email = $_POST['email'];
            $aluno->genero = $_POST['genero'];
            try {
                $this->repository->atualizar($aluno, $id);
            } catch (Exception $exception) {
                if (true === str_contains($exception->getMessage(), 'cpf')) {
                    die('CPF já existe');
                }
                if (true === str_contains($exception->getMessage(), 'email')) {
                    die('Email já existe');
                }
                die('Vish, aconteceu um erro');
            }
            $this->redirect('/alunos/listar');
        }
    }
    public function excluir(): void
    {
        // $this->checarLogin();
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('aluno/excluir');
        $this->redirect('/alunos/listar');
    }
    private function renderizar(iterable $alunos)
    {
        $resultado = '';
        foreach ($alunos as $aluno) {
        $resultado .= "
            <tr>
                <td>{$aluno->id}</td>
                <td>{$aluno->nome}</td>
                <td>{$aluno->matricula}</td>
                <td>{$aluno->cpf}</td>
                <td>{$aluno->email}</td>
                <td>{$aluno->genero}</td>
                <td>{$aluno->status}</td>
                <td>{$aluno->dataNascimento}</td>
            </tr>
            ";
            }
            return $resultado;
        }
    public function relatorio(): void
    {
        $hoje = date('d/m/Y');
        $alunos = $this->repository->buscarTodos();
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
                        <th>Matricula</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Gênero</th>
                        <th>Status</th>
                        <th>Data Nascimento</th>
                    </tr>
                </thead>
                <tbody>
                ".$this->renderizar($alunos)."
                </tbody>
            </table>
        ";
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait'); // tamanho da pagina
        $dompdf->loadHtml($design); //carrega o conteudo do PDF
        $dompdf->render(); //aqui renderiza 
        $dompdf->stream('relatorio-aluno.pdf',['Attachment' => 0,]); //é aqui que a magica acontece
    }
}