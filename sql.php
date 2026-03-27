<?php

$caminhoBanco = __DIR__ . "/banco.sqlite";
$pdo = new PDO("sqlite:$caminhoBanco");

$pdo->exec("
    CREATE TABLE medicos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        crm TEXT,
        nome TEXT,
        especialidade TEXT
    );

    CREATE TABLE pacientes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        nome VARCHAR(160) NOT NULL,
        telefone VARCHAR(11) NULL,
        data_nascimento TIMESTAMP,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
");
