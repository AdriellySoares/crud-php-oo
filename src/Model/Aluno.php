<?php
declare(strict_types=1);
namespace App\Model;
use DateTime;
// aqui vai ficar a definição do caminho até essa classe
class Aluno extends Pessoa
{
    public string $dataNascimento;
    public int $matricula;
    public bool $status;
    public string $genero; //enum
}