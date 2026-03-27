<?php

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

require_once "vendor/autoload.php";

$medico = new Medico(null, "CRM/PI 1111", "Antonio Carlos", "Otorrino");

$pdoMedico = new RepositorioMedico();
$resposta = $pdoMedico->inserir($medico);

var_dump($resposta);