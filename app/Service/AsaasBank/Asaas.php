<?php

namespace App\Service\AsaasBank;


class Asaas
{

    private $MinhaConta;
    private $Cliente;
    private $Cobranca;

    private $connection;

    public function __construct($token, $status = false) {
        $this->connection = new Connection($token, ((!empty($status)) ? $status : 'producao'));

        $this->MinhaConta   = new MinhaConta($this->connection);
        $this->Cliente      = new Cliente($this->connection);
        $this->Cobranca     = new Cobranca($this->connection);

    }

    public function MinhaConta(){
        $this->MinhaConta = new MinhaConta($this->connection);
        return $this->MinhaConta;
    }

    public function Cliente(){
        $this->Cliente = new Cliente($this->connection);
        return $this->Cliente;
    }

    public function Cobranca(){
        $this->Cobranca = new Cobranca($this->connection);
        return $this->Cobranca;
    }

}
