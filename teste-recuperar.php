<?php

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

require_once 'vendor/autoload.php';

$repositorio = new RepositorioMedico();

// tenta buscar o médico com ID 1
$medico = new Medico(1, '', '', '');

$resultado = $repositorio->recuperar($medico);

var_dump($resultado);