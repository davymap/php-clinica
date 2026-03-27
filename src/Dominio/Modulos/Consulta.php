<?php

namespace Luizlins\Projeto01\Dominio\Modulos;

use DateTimeImmutable;

class Consulta
{
    public function __construct(
        private Medico $medico,
        private Paciente $paciente,
        private DateTimeImmutable $data,
        private float $valor
    ) {}

    public function recuperarMedico(): Medico
    {
        return $this->medico;
    }

    public function recuperarPaciente(): Paciente
    {
        return $this->paciente;
    }

    public function recuperarData(): DateTimeImmutable
    {
        return $this->data;
    }

    public function recuperarValor(): float
    {
        return $this->valor;
    }
}