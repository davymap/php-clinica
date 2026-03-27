# 📋 Sistema de Gestão Médica em PHP

Um projeto educacional de **Programação Orientada a Objetos (POO)** e arquitetura de software em PHP.

---

## 📌 O que é este projeto?

Este é um sistema simples para gerenciar:
- **Médicos** (CRM, nome, especialidade)
- **Pacientes** (CPF, nome, telefone, data de nascimento)
- **Consultas** (médico, paciente, data e valor)

O objetivo é **aprender** como estruturar um projeto PHP profissional usando boas práticas de desenvolvimento.

---

## 🎯 O que você vai aprender

✅ **Programação Orientada a Objetos (POO)**
- Classes, herança e interfaces
- Encapsulamento e getters/setters

✅ **Padrões de Arquitetura**
- Domain-Driven Design (DDD) - organização do código por camadas
- Repository Pattern - abstrair o acesso a dados
- Factory Pattern - criação de objetos de forma centralizada

✅ **Banco de Dados**
- Como conectar PHP ao SQLite com PDO
- Operações CRUD (Create, Read, Update, Delete)
- Prepared Statements para segurança

✅ **Autoloading com Composer**
- PSR-4 - como organizar namespaces
- Carregamento automático de classes

---

## 📂 Estrutura do Projeto

```
PROJETO-01/
│
├── composer.json                    # Configuração do Composer
├── banco.sqlite                     # Banco de dados SQLite
│
├── index.php                        # Exemplo: criar objetos
├── sql.php                          # Exemplo: criar tabelas no banco
├── inserir-medico.php               # Exemplo: adicionar médico
├── listar-medicos.php               # Exemplo: listar médicos
├── atualizar-medico.php             # Exemplo: modificar médico
├── remover-medico.php               # Exemplo: deletar médico
│
└── src/                             # Código da aplicação
    │
    ├── Dominio/                     # REGRAS DE NEGÓCIO (independent)
    │   ├── Modulos/                 # Entidades (o coração do sistema)
    │   │   ├── Medico.php           # Classe: representa um médico
    │   │   ├── Paciente.php         # Classe: representa um paciente
    │   │   └── Consulta.php         # Classe: representa uma consulta
    │   │
    │   └── Repositorios/            # Contratos (interfaces)
    │       └── RepositorioMedicoInterface.php
    │
    └── Infraestrutura/              # DETALHES TÉCNICOS (implementação)
        ├── Configuracoes/           # Utilitários
        │   └── Telefone.php         # Validar e formatar telefones
        │
        ├── Persistencia/            # Conexão com banco
        │   └── FabricaConexao.php   # Factory para PDO
        │
        └── Repositorios/            # Implementações (acesso a dados)
            └── RepositorioMedico.php
```

> **💡 Dica:** A pasta `Dominio` contém regras de negócio (independente de tecnologia). A pasta `Infraestrutura` contém implementações técnicas (banco, cache, etc).

---

## 🔧 Requisitos

- **PHP 8.0+** (com tipagem forte)
- **Composer** (gerenciador de dependências)
- **SQLite3** (banco de dados leve)

---

## 🚀 Como Usar

### 1️⃣ Instalação

```bash
# Acesse a pasta do projeto
cd PROJETO-01

# Instale as dependências
composer install

# Atualize o autoload
composer dump-autoload
```

### 2️⃣ Criar as Tabelas do Banco

```bash
# Execute o arquivo que cria as tabelas
php sql.php

# Ou manualmente com SQLite:
sqlite3 banco.sqlite < schema.sql
```

As tabelas criadas são:

**Tabela: medicos**
| id | crm | nome | especialidade |
|---|---|---|---|
| 1 | CRM/PI 1111 | Antonio Carlos | Otorrino |

**Tabela: pacientes**
| id | cpf | nome | telefone | data_nascimento |
|---|---|---|---|---|
| 1 | 12345678901 | Maria Silva | (86) 99999-9999 | 1990-05-15 |

### 3️⃣ Executar os Exemplos

**Criar um médico:**
```bash
php inserir-medico.php
```

**Listar médicos:**
```bash
php listar-medicos.php
```

**Atualizar um médico:**
```bash
php atualizar-medico.php
```

**Remover um médico:**
```bash
php remover-medico.php
```

**Visualizar objetos de exemplo:**
```bash
php index.php
```

---

## 📚 Conceitos Principais

### 🏗️ Domain-Driven Design (DDD)

A aplicação é dividida em duas camadas principais:

**Camada de Domínio** (`src/Dominio/`)
- Contém as **regras de negócio**
- Não depende de tecnologias (MySQL, Redis, etc)
- Exemplo: classe `Medico` com dados e regras

**Camada de Infraestrutura** (`src/Infraestrutura/`)
- Contém **implementação técnica**
- Lida com banco de dados, cache, API externa, etc
- Exemplo: `RepositorioMedico` que acessa SQLite

```
┌─────────────────────┐
│   Aplicação (UI)    │
└──────────┬──────────┘
           │
┌──────────▼──────────┐
│  DOMÍNIO (Regras)   │  ← Medico, Paciente, Consulta
└──────────┬──────────┘
           │
┌──────────▼─────────────────┐
│ INFRAESTRUTURA (Tecnologia)│  ← PDO, SQLite, Banco
└────────────────────────────┘
```

### 📦 Repository Pattern

Em vez de usar `PDO` diretamente, usamos um **repositório**:

```php
// ❌ ERRADO - Lógica de banco espalhado
$stmt = $conexao->prepare("SELECT * FROM medicos");

// ✅ CORRETO - Repositório centraliza isso
$repositorio = new RepositorioMedico();
$medicos = $repositorio->listar();
```

**Benefícios:**
- Código mais limpo
- Fácil testar (trocar implementação)
- Fácil mudar de banco de dados

### 🏭 Factory Pattern

Centraliza a criação de objetos:

```php
// Em vez de usar PDO diretamente
$pdo = FabricaConexao::criarConexao();
// O código fica mais limpo e organizado
```

---

## 🎓 Arquivos Explicados

### `Medico.php` - Classe de Domínio
```php
class Medico {
    function __construct(
        private ?int $id,
        private ?string $crm,
        private ?string $nome,
        private ?string $especialidade
    ) {}
    
    // Getters para acessar dados
    public function recuperarNome() { ... }
}
```
**Aprenda:** Propriedades privadas, encapsulamento, getters

### `RepositorioMedicoInterface.php` - Contrato
```php
interface RepositorioMedicoInterface {
    public function listar(): array;
    public function inserir(Medico $medico): bool;
    public function deletar(Medico $medico);
    public function atualizar(Medico $medico);
}
```
**Aprenda:** Interfaces definem contratos (o que a classe deve fazer)

### `RepositorioMedico.php` - Implementação
```php
class RepositorioMedico implements RepositorioMedicoInterface {
    public function listar(): array {
        $sql = "SELECT * FROM medicos";
        return $this->conexao->query($sql);
    }
}
```
**Aprenda:** PDO, prepared statements, hidratação de dados

### `Telefone.php` - Value Object
```php
class Telefone {
    public function __construct(private string $numero) {
        $digitos = preg_replace('/\D/', '', $numero);
        if (strlen($digitos) !== 11) {
            throw new Exception("Inválido");
        }
    }
}
```
**Aprenda:** Validação, formatação, value objects

---

## 💡 Fluxo de Uma Operação

### Adicionar um médico:

```
1. inserir-medico.php
      ↓
2. Criar objeto: $medico = new Medico(null, "CRM/PI 1111", "Dr. Silva", "Cardio")
      ↓
3. Chamar repositório: $repositorio->inserir($medico)
      ↓
4. RepositorioMedico executa SQL: INSERT INTO medicos (...)
      ↓
5. Banco salva os dados
      ↓
6. Retorna sucesso true/false
```

---

## 🔐 Segurança

Este projeto usa **Prepared Statements** para proteger contra SQL Injection:

```php
// ❌ INSEGURO
$sql = "SELECT * FROM medicos WHERE nome = '" . $nome . "'";

// ✅ SEGURO
$stmt = $conexao->prepare("SELECT * FROM medicos WHERE nome = ?");
$stmt->execute([$nome]);
```

---

## 📝 Exemplo de Uso Completo

```php
<?php
require_once "vendor/autoload.php";

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

// 1. Criar um médico
$medico = new Medico(
    null,
    "CRM/PI 2024",
    "Dr. João Silva",
    "Cardiologista"
);

// 2. Usar o repositório
$repositorio = new RepositorioMedico();

// 3. Inserir no banco
$sucesso = $repositorio->inserir($medico);

if ($sucesso) {
    echo "Médico inserido com ID: " . $medico->recuperarId();
} else {
    echo "Erro ao inserir!";
}

// 4. Listar todos
$todos = $repositorio->listar();
foreach ($todos as $med) {
    echo $med->recuperarNome() . " - " . $med->recuperarEspecialidade();
}
```

---

## 🎯 Próximos Passos para Aprender

1. **Adicione validação** nas classes
2. **Implemente tratamento de erros** com try/catch
3. **Crie testes unitários** com PHPUnit
4. **Implemente logging** de operações
5. **Use migrations** para versionamento do banco
6. **Crie uma API REST** com o repositório

---

## 📚 Referências

- [PHP Orientado a Objetos](https://www.php.net/manual/pt_BR/language.oop5.php)
- [Composer PSR-4](https://getcomposer.org/doc/)
- [PDO - PHP Data Objects](https://www.php.net/manual/pt_BR/book.pdo.php)
- [Domain-Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design)
- [Repository Pattern](https://refactoring.guru/design-patterns/repository)

---

## 👨‍💼 Autor

**LuizLins** - Projeto educacional para aprendizado de POO e arquitetura em PHP

**Email:** luizmagao@gmail.com

---

## 📝 Licença

Este projeto é de código aberto e pode ser usado livremente para fins educacionais.
    especialidade TEXT NOT NULL
);

# Insira dados de exemplo
INSERT INTO medicos (crm, nome, especialidade) VALUES ('CRM/PI 24546', 'Luiz Lins', 'Oftalmologista');
INSERT INTO medicos (crm, nome, especialidade) VALUES ('CRM/PI 12345', 'Maria Silva', 'Cardiologista');

# Saia do SQLite
.exit
```

Alternativamente, execute o script `medico.php` para criar a tabela:
```bash
php medico.php
```

## Executando o Projeto

### Exemplos de Uso

#### 1. Script Principal (`index.php`)
Demonstra a criação de objetos de domínio e uma consulta.
```bash
php index.php
```
Este script cria instâncias de `Medico`, `Paciente`, `Telefone` e `Consulta`, e faz um `var_dump` da consulta.

#### 2. Operações CRUD com Médicos
- **Listar médicos**:
  ```bash
  php recuperar-medicos.php
  ```
- **Inserir médico**:
  ```bash
  php inserir-medico.php
  ```
- **Atualizar médico** (exemplo com ID 2):
  ```bash
  php atualizar-medico.php
  ```
- **Remover médico** (exemplo com ID 1):
  ```bash
  php remover-medico.php
  ```

#### 3. Conexão Simples (`conexao.php`)
```bash
php conexao.php
```
Apenas conecta ao banco e imprime "Conectei".

## Classes Principais e Exemplos de Código

### Classe `Medico`
```php
<?php
namespace Luizlins\Projeto01\Dominio\Modulos;

class Medico {
    public function __construct(
        private ?int $id,
        private string $crm,
        private string $nome,
        private string $especialidade
    ) {}

    // Getters e setters
    public function recuperarId(): ?int { return $this->id; }
    public function definirId(int $id) { $this->id = $id; }
    public function recuperarCRM(): string { return $this->crm; }
    public function recuperarNome(): string { return strtoupper($this->nome); }
    public function recuperarEspecialidade(): string { return $this->especialidade; }
}
```

**Estudo**: Observe o uso de propriedades privadas e métodos de acesso. O nome é sempre retornado em maiúsculo.

### Classe `Paciente`
```php
<?php
namespace Luizlins\Projeto01\Dominio\Modulos;

use DateTimeImmutable;

class Paciente {
    public function __construct(
        private string $cpf,
        private string $nome,
        private array $telefone,  // Array de objetos Telefone
        private DateTimeImmutable $dataNascimento
    ) {}
    // Nota: Esta classe não possui getters implementados no código atual.
}
```

**Estudo**: Usa `DateTimeImmutable` para datas imutáveis. Telefones são um array de objetos `Telefone`.

### Classe `Consulta`
```php
<?php
namespace Luizlins\Projeto01\Dominio\Modulos;

class Consulta {
    public function __construct(
        private Medico $medico,
        private Paciente $paciente,
        private DateTimeImmutable $data,
        private float $valor
    ) {}
    // Nota: Sem getters implementados.
}
```

**Estudo**: Composição de objetos (Medico e Paciente).

### Classe `Telefone` (Value Object)
```php
<?php
namespace Luizlins\Projeto01\Infraestrutura\Configuracoes;

class Telefone {
    public function __construct(private string $numero) {
        $digitos = preg_replace('/\D/', '', $numero);
        if (strlen($digitos) !== 11) {
            throw new Exception("Formato de telefone inválido");
        }
        $this->numero = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1)$2-$3', $digitos);
    }
}
```

**Estudo**: Validação de formato brasileiro (11 dígitos) e formatação automática.

### Repositório `RepositorioMedico`
Implementa operações CRUD usando PDO preparado para evitar SQL Injection.

**Método `inserir`**:
```php
public function inserir(Medico $medico): bool {
    $stmt = $this->conexao->prepare("INSERT INTO medicos (crm, nome, especialidade) VALUES (:crm, :nome, :especialidade)");
    $sucesso = $stmt->execute([
        ':crm' => $medico->recuperarCRM(),
        ':nome' => $medico->recuperarNome(),
        ':especialidade' => $medico->recuperarEspecialidade(),
    ]);
    $medico->definirId($this->conexao->lastInsertId());
    return $sucesso;
}
```

**Estudo**: Uso de prepared statements e hidratação de objetos.

## Esquema do Banco de Dados

### Tabela `medicos`
```sql
CREATE TABLE medicos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    crm TEXT NOT NULL,
    nome TEXT NOT NULL,
    especialidade TEXT NOT NULL
);
```

**Sugestões para Expansão**:
- Adicionar tabelas para `pacientes` e `consultas`.
- Implementar relacionamentos (foreign keys).

## Pontos de Estudo e Melhorias Sugeridas

### Conceitos Aprendidos
1. **Namespaces e Autoloading PSR-4**: Como organizar código em pastas.
2. **Injeção de Dependência**: `FabricaConexao` cria conexões.
3. **Imutabilidade**: Uso de `DateTimeImmutable`.
4. **Validação**: Classe `Telefone` valida entrada.
5. **Padrões de Projeto**: Repository abstrai persistência.

### Melhorias Possíveis
- **Completar as Classes**: Adicionar getters a `Paciente` e `Consulta`.
- **Implementar `recuperar`**: Método não implementado em `RepositorioMedico`.
- **Tratamento de Erros**: Adicionar try-catch nas operações de banco.
- **Testes Unitários**: Usar PHPUnit para testar classes.
- **Expandir o Domínio**: Adicionar mais entidades e regras de negócio.
- **API REST**: Transformar em uma API com rotas para CRUD.
- **Migrations**: Usar ferramentas como Doctrine para gerenciar schema.

### Exercícios para Estudantes
1. Implemente getters para `Paciente` e `Consulta`.
2. Crie um repositório para `Paciente` seguindo o padrão.
3. Adicione validação de CPF na classe `Paciente`.
4. Implemente o método `recuperar` no repositório.
5. Crie um script para popular o banco com dados fictícios.

## Contribuição

Este projeto é didático. Sugestões de melhorias são bem-vindas via pull requests ou issues.

## Autor

Luiz Lins (luizmagao@gmail.com)
