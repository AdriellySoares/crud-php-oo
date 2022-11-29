<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CursoRepository;
class CursoController extends AbstractController
{
    public function listar(): void
    {
        $rep = new CursoRepository();
        $cursos = $rep->buscarTodos();

        $this->render("curso/listar", [
            'cursos' => $cursos,
        ]);
    }

    public function cadastrar(): void
    {
        $rep = new CategoriaRepository();
        $categorias = $rep->buscarTodos();
        echo "Pagina de cadastrar";
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