<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Curso;
use App\Repository\CategoriaRepository;
use App\Repository\CursoRepository;
use Exception;

class CursoController extends AbstractController
{

    private CursoRepository $repository;

    public function __construct()
    {
        $this->repository = new CursoRepository();
    }

    public function listar(): void
    {
        $this->checkLogin();
        $rep = new CursoRepository();
        $cursos = $rep->buscarTodos();

        $this->render("curso/listar", [
            'cursos' => $cursos,
        ]);
    }

    public function cadastrar(): void
    {
        
        $rep = new CategoriaRepository();
        if (true === empty($_POST)) {
            $categorias = $rep->buscarTodos();
            $this->render("/curso/cadastrar", ['categorias' => $categorias]);
            return;
        }

        $curso = new Curso();
        $curso->nome = $_POST['nome'];
        $curso->descricao = $_POST['descricao'];
        $curso->cargaHoraria = intval($_POST['cargaHoraria']);
        $curso->categoria_id = intval($_POST['categoria']);

        $this->repository->inserir($curso);
        // try {
        // } catch (Exception $exception) {
        //     var_dump($exception->getMessage());
        //     // if (true === str_contains($exception->getMessage(), 'cpf')) {
        //     //     die('CPF ja existe');
        //     // }

        //     // if (true === str_contains($exception->getMessage(), 'email')) {
        //     //     die('Email ja existe');
        //     // }

        //     die('Vish, aconteceu um erro');
        // }

        $this->redirect('/cursos/listar');
    }

    public function excluir(): void
    {
        echo "Pagina de excluir";
    }

    public function editar(): void
    {
        echo "Pagina de editar";
    }
}