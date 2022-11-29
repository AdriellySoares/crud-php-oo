<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Categoria;
use App\Repository\CategoriaRepository;
use Exception;

class CategoriaController extends AbstractController
{
    private CategoriaRepository $repository;

    public function __construct()
    {
        $this->repository = new CategoriaRepository;
    }
    public function listar() : void
    {
        $this->renderizar('categoria/listar', [
            'categorias' => $this->repository->buscarTodos()
        ]);
    }

    public function novo() : void
    {
        if(empty($_POST)){
            $this->renderizar('categoria/novo');
            return;
        }

        $categoria = new Categoria();
        $categoria->nome = $_POST['nome'];
        
        try{
            $this->repository->inserir($categoria);
        } catch(Exception $exception){
            if(str_contains($exception->getMessage(), 'nome')){
                die('O categoria já existe');
            }
            die('Vish, aconteceu um erro');
        }
        $this->redirecionar('categorias/listar');      
    }

    public function editar() : void
    {
        $id = $_GET['id'];
        $categoria = $this->repository->buscarUm($id);
        $this->renderizar('categoria/editar', [$categoria]);
        if(!empty($_POST)){
            $categoria->nome = $_POST['nome'];
            try{
                $this->repository->atualizar($categoria, $id);
            } catch(Exception $exception){
                if(str_contains($exception->getMessage(), 'nome')){
                    die('O categoria já existe');
                }

                die('Vish, aconteceu um erro');
            }
            $this->redirecionar('categorias/listar');
        }
    }

    public function excluir() : void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        
        $this->redirecionar('categorias/listar');
    }
} 
