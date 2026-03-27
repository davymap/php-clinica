<?php

namespace Luizlins\Projeto01\Dominio\Modulos;

use DateTimeImmutable;
use InvalidArgumentException;

class Paciente
{
    public function __construct(
        private ?int $id,
        private string $cpf,
        private string $nome,
        private array $telefone,
        private DateTimeImmutable $dataNascimento
    ) {
        $this->cpf = $this->validarCpf($cpf);
    }

    public function recuperarId(): ?int
    {
        return $this->id;
    }

    public function definirId(int $id): void
    {
        $this->id = $id;
    }

    public function recuperarCpf(): string
    {
        return $this->cpf;
    }

    public function recuperarNome(): string
    {
        return $this->nome;
    }

    public function recuperarTelefone(): array
    {
        return $this->telefone;
    }

    public function recuperarDataNascimento(): DateTimeImmutable
    {
        return $this->dataNascimento;
    }

    private function validarCpf(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            throw new InvalidArgumentException('CPF inválido');
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new InvalidArgumentException('CPF inválido');
        }

        for ($i = 9; $i < 11; $i++) {
            $soma = 0;
            for ($j = 0; $j < $i; $j++) {
                $soma += $cpf[$j] * (($i + 1) - $j);
            }

            $digito = ((10 * $soma) % 11) % 10;

            if ($cpf[$i] != $digito) {
                throw new InvalidArgumentException('CPF inválido');
            }
        }

        return $cpf;
    }
}