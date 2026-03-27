<?php

namespace Luizlins\Projeto01\Infraestrutura\Configuracoes;

class Telefone
{

    public function __construct(private string $numero)
    {
        $digitos = preg_replace('/\D/', '', $numero);
        
        if (strlen($digitos) !== 11) {
            throw new Exception("Formato de telefone inválido", 1);
        }
        
        $this->numero = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1)$2-$3', $digitos);
    }
    
}