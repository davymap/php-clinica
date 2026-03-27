<?php

namespace Luizlins\Projeto01\Infraestrutura\Repositorios;

use DateTimeImmutable;
use Luizlins\Projeto01\Dominio\Modulos\Paciente;
use Luizlins\Projeto01\Dominio\Repositorios\RepositorioPacienteInterface;
use Luizlins\Projeto01\Infraestrutura\Persistencia\FabricaConexao;
use PDO;
use PDOStatement;

class RepositorioPaciente implements RepositorioPacienteInterface
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = FabricaConexao::criarConexao();
    }

    public function listar(): array
    {
        $stmt = $this->conexao->query("SELECT * FROM pacientes;");
        return $this->hidratacao($stmt);
    }

    public function inserir(Paciente $paciente): bool
    {
        $stmt = $this->conexao->prepare(
            "INSERT INTO pacientes (cpf, nome, telefone, data_nascimento)
             VALUES (:cpf, :nome, :telefone, :data_nascimento);"
        );

        $telefones = $paciente->recuperarTelefone();
        $telefone = !empty($telefones) ? (string)$telefones[0] : null;

        $sucesso = $stmt->execute([
            ':cpf' => $paciente->recuperarCpf(),
            ':nome' => $paciente->recuperarNome(),
            ':telefone' => $telefone,
            ':data_nascimento' => $paciente->recuperarDataNascimento()->format('Y-m-d'),
        ]);

        $paciente->definirId((int)$this->conexao->lastInsertId());

        return $sucesso;
    }

    public function deletar(Paciente $paciente): bool
    {
        $stmt = $this->conexao->prepare("DELETE FROM pacientes WHERE id = ?;");
        $stmt->bindValue(1, $paciente->recuperarId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function atualizar(Paciente $paciente): bool
    {
        $stmt = $this->conexao->prepare(
            "UPDATE pacientes
             SET cpf = :cpf, nome = :nome, telefone = :telefone, data_nascimento = :data_nascimento
             WHERE id = :id;"
        );

        $telefones = $paciente->recuperarTelefone();
        $telefone = !empty($telefones) ? (string)$telefones[0] : null;

        return $stmt->execute([
            ':cpf' => $paciente->recuperarCpf(),
            ':nome' => $paciente->recuperarNome(),
            ':telefone' => $telefone,
            ':data_nascimento' => $paciente->recuperarDataNascimento()->format('Y-m-d'),
            ':id' => $paciente->recuperarId(),
        ]);
    }

    public function recuperar(Paciente $paciente): ?Paciente
    {
        $stmt = $this->conexao->prepare("SELECT * FROM pacientes WHERE id = ?;");
        $stmt->bindValue(1, $paciente->recuperarId(), PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Paciente(
            $dados['id'],
            $dados['cpf'],
            $dados['nome'],
            [],
            new DateTimeImmutable($dados['data_nascimento'])
        );
    }

    private function hidratacao(PDOStatement $stmt): array
    {
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];

        foreach ($dados as $p) {
            $lista[] = new Paciente(
                $p['id'],
                $p['cpf'],
                $p['nome'],
                [],
                new DateTimeImmutable($p['data_nascimento'])
            );
        }

        return $lista;
    }
}