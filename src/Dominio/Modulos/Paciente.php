<?php

namespace Luizlins\Projeto01\Dominio\Modulos;

use DateTimeImmutable;

class Paciente {

    function __construct(
        private string $cpf,
        private string $nome,
        private array $telefone,
        private DateTimeImmutable $dataNascimento
    ) {}

}