<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Categoria;
use Exception;
use App\Repository\CategoriaRepository;
use App\Security\UsuarioSecurity;
use Dompdf\Dompdf;

class CategoriaController extends AbstractController
{
    private CategoriaRepository $repository;
    public function __construct()
    {
        $this->repository = new CategoriaRepository();
    }
    public function listar(): void
    {
        // $this->checarLogin();
        $categorias = $this->repository->buscarTodos();
        $this->render('categoria/listar', ['categorias'=>$categorias]);
    }
    public function cadastrar(): void
    {
        // $this->checarLogin();
        if(true === empty($_POST)){
            $this->render('categoria/cadastrar');
            return;
        }
        $categoria = new Categoria();
        $categoria->nome = $_POST['nome'];
        try{
            $this->repository->inserir($categoria);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'nome')){
                die('Categoria já existe');
            }
            die(var_dump($exception));
        }
        $this->redirect('/categorias/listar');
    }
    public function editar(): void
    {
        // $this->checarLogin();
        $id = $_GET['id'];
        $categoria = $this->repository->buscarUm($id);
        $this->render('categoria/editar', [$categoria]);
        if(false === empty($_POST)){
            $categoria->nome = $_POST['nome'];
            try{
                $this->repository->atualizar($categoria, $id);
            }catch(Exception $exception){
                if(true === str_contains($exception->getMessage(), 'nome')){
                    die('Categoria já existe');
                }
                die(var_dump($exception));
            }
            $this->redirect('/categorias/listar');
        }
    }
    public function excluir(): void
    {
        // $this->checarLogin();
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('categoria/excluir');
        $this->redirect('/categorias/listar');
    }
    private function renderizar(iterable $categorias)
    {
        $resultado = '';
        foreach($categorias as $categoria){
            $resultado .= "
            <tr>
                <td>{$categoria->id}</td>
                <td>{$categoria->nome}</td>
            </tr>";
        }
        return $resultado;
    }
    public function relatorio(): void
    {
        $hoje = date('d/m/Y');
        $categorias = $this->repository->buscarTodos();
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
                    </tr>
                </thead>
                <tbody>
                ".$this->renderizar($categorias)."
                </tbody>
            </table>
        ";
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($design);
        $dompdf->render();
        $dompdf->stream('relatorio-categoria.pdf', ['Attachment'=> 0,]);
    }
}