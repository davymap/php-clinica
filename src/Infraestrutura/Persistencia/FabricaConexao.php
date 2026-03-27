<?php

namespace Luizlins\Projeto01\Infraestrutura\Persistencia;

use PDO;

class FabricaConexao {

    public static function criarConexao()
    {
        $caminhoBanco = __DIR__ . "/../../../banco.sqlite";
        return new PDO("sqlite:$caminhoBanco");
    }

}