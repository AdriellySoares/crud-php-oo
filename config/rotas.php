<?php


use App\Controller\AlunoController;
use App\Controller\AuthController;
use App\Controller\CategoriaController;
use App\Controller\CursoController;
use App\Controller\ProfessorController;
use App\Controller\SiteController;
use App\Controller\UsuarioController;

function criarRota(string $controllerNome, string $methodNome) : array
{
    return [
        'controller' => $controllerNome,
        'method' => $methodNome,
    ];
}

$rotas = [
    '/' => criarRota(SiteController::class, 'inicio'),
    
    '/alunos/listar' => criarRota(AlunoController::class, 'listar'),
    '/alunos/novo' => criarRota(AlunoController::class, 'novo'),
    '/alunos/editar' => criarRota(AlunoController::class, 'editar'),
    '/alunos/excluir' => criarRota(AlunoController::class, 'excluir'),
    '/alunos/relatorio' => criarRota(AlunoController::class, 'relatorio'),
    
    '/professores/listar' => criarRota(ProfessorController::class, 'listar'),
    '/professores/novo' => criarRota(ProfessorController::class, 'novo'),
    '/professores/editar' => criarRota(ProfessorController::class, 'editar'),
    '/professores/excluir' => criarRota(ProfessorController::class, 'excluir'),

    '/cursos/listar' => criarRota(CursoController::class, 'listar'),
    '/cursos/novo' => criarRota(CursoController::class, 'novo'),
    '/cursos/editar' => criarRota(CursoController::class, 'editar'),
    '/cursos/excluir' => criarRota(CursoController::class, 'excluir'),
    '/cursos/relatorio' => criarRota(CursoController::class, 'relatorio'),

    '/categorias/listar' => criarRota(CategoriaController::class, 'listar'),
    '/categorias/novo' => criarRota(CategoriaController::class, 'novo'),
    '/categorias/editar' => criarRota(CategoriaController::class, 'editar'),
    '/categorias/excluir' => criarRota(CategoriaController::class, 'excluir'),

    '/usuarios/listar' => criarRota(UsuarioController::class, 'listar'),
    '/usuarios/novo' => criarRota(UsuarioController::class, 'novo'),

    '/login' => criarRota(AuthController::class, 'login'),
    '/desconectar' => criarRota(AuthController::class, 'logout'),
];

return $rotas;