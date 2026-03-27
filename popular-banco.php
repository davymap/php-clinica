<?php

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Dominio\Modulos\Paciente;
use Luizlins\Projeto01\Infraestrutura\Configuracoes\Telefone;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioPaciente;

require_once 'vendor/autoload.php';

$repositorioMedico = new RepositorioMedico();
$repositorioPaciente = new RepositorioPaciente();

$medicos = [
    new Medico(null, 'CRM/CE 1001', 'Joao Paulo', 'Cardiologista'),
    new Medico(null, 'CRM/CE 1002', 'Mariana Silva', 'Dermatologista'),
    new Medico(null, 'CRM/CE 1003', 'Carlos Eduardo', 'Pediatra'),
];

foreach ($medicos as $medico) {
    $repositorioMedico->inserir($medico);
}

$pacientes = [
    new Paciente(
        null,
        '52998224725',
        'Ana Beatriz',
        [new Telefone('88999990001')],
        new DateTimeImmutable('2000-05-10')
    ),
    new Paciente(
        null,
        '11144477735',
        'Pedro Henrique',
        [new Telefone('88999990002')],
        new DateTimeImmutable('1998-11-22')
    ),
    new Paciente(
        null,
        '12345678909',
        'Davi Silva',
        [new Telefone('88999990003')],
        new DateTimeImmutable('2003-01-15')
    ),
];

foreach ($pacientes as $paciente) {
    $repositorioPaciente->inserir($paciente);
}

echo "Banco populado com sucesso!";