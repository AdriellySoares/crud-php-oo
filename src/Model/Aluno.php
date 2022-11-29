<?php 

declare(strict_types = 1);

namespace App\Model;

//Aqui vai ficar a definição do caminho até essa classe

class Aluno extends Pessoa
{
    public string $matricula;
    public string $email;
    public bool $status;
    public string $genero;
    public string $dataNascimento;
}