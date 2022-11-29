<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Repository\ProfessorRepository;

class ProfessorController extends AbstractController
{
    public function listar() : void
    {
        $rep = new ProfessorRepository;
        $this->renderizar('professor/listar', [
            'professores' => $rep->buscarTodos()
        ]);
    }

    public function novo() : void
    {
        $this->renderizar('professor/novo');
    }

    public function editar() : void
    {
        $this->renderizar('professor/editar');
    }

    public function excluir() : void
    {
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $rep->excluir($id);
        
        $this->redirecionar('professores/listar');
    }
} 
