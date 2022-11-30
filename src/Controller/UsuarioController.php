<?php
declare(strict_types=1);
namespace App\Controller;
use App\Model\Usuario;
use App\Repository\UsuarioRepository;
use Dompdf\Dompdf;
use Excecption;
use Exception;

class UsuarioController extends AbstractController
{
    private UsuarioRepository $repository;
    public function __construct()
    {
        $this->repository = new UsuarioRepository();
    }
    public function cadastrar(): void
    {
        if(true === empty($_POST)){
            $this->render('usuario/cadastrar');
            return;
        }
        $senha = password_hash($_POST['senha'], PASSWORD_ARGON2I);
        $usuario = new Usuario();
        $usuario->nome = $_POST['nome'];
        $usuario->email = $_POST['email'];
        $usuario->senha = $senha;
        $usuario->perfil = $_POST['perfil'];
        try{
            $this->repository->inserir($usuario);
        } catch(Exception $execption){
            if(true === str_contains($execption->getMessage(), 'email')){
                die('Email já existe');
            }
        }
        $this->redirect('/usuarios/listar');
    }
    public function editar(): void
    {
        $id = $_GET['id'];
        $usuario = $this->repository->buscarUm($id);
        $this->render('usuario/editar', [$usuario]);
        if(false === empty($_POST)){
            $usuario->nome = $_POST['nome'];
            $usuario->email = $_POST['email'];
            $usuario->senha = $_POST['senha'];
            $usuario->perfil = $_POST['perfil'];
            try{
                $this->repository->atualizar($usuario, $id);
            }catch (Exception $execption){
                if(true === str_contains($execption->getMessage(), 'email')){
                    die('Email já existe');
                }
            }
        }
        $this->redirect('/usuarios/listar');
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('usuario/excluir');
        $this->redirect('/usuarios/listar');
    }
}