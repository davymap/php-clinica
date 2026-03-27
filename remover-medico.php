<?php

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

require_once "vendor/autoload.php";

$medico = new Medico(1, "CRM/PI 1111", "Antonio Carlos", "Otorrino");

$pdoMedico = new RepositorioMedico();
$resposta = $pdoMedico->deletar($medico);

var_dump($resposta);