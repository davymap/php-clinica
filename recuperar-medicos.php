<?php

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

require_once "vendor/autoload.php";

$pdoMedico = new RepositorioMedico();
$resposta = $pdoMedico->listar();

var_dump($resposta);