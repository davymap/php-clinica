<?php

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

require_once "vendor/autoload.php";

$medico = new Medico(2, "CRM/PI 2222", "Bento Luiz", "Oftamologista");

$pdoMedico = new RepositorioMedico();
$resposta = $pdoMedico->atualizar($medico);

var_dump($resposta);