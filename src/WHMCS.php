<?php

namespace Mozafar\WHMCS;

use Mozafar\WHMCS\Contracts\ClientsInterface;
use Mozafar\WHMCS\Contracts\WHMCSContract;

class WHMCS implements WHMCSContract
{
    protected $clients;

    public function __construct(ClientsInterface $clients)
    {
        $this->clients = $clients;
    }

    public function getClients($params)
    {
        return $this->clients->getClients($params);
    }
}
