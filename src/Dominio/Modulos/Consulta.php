<?php

namespace Luizlins\Projeto01\Dominio\Modulos;

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Dominio\Modulos\Paciente;
use DateTimeImmutable;

class Consulta {

    function __construct(
        private Medico $medico,
        private Paciente $paciente,
        private DateTimeImmutable $data,
        private float $valor
    ) {}

}