<?php

use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

require_once "vendor/autoload.php";

$stmtMedico = new RepositorioMedico();
$resposta = $stmtMedico->listar();

var_dump($resposta);