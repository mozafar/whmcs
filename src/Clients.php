<?php

namespace Mozafar\WHMCS;

use Mozafar\WHMCS\Contracts\ClientsInterface;

class Clients implements ClientsInterface
{
    protected $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }
    public function getClients($params)
    {
        $params['action'] = 'GetClients';
        return $this->apiClient->makeRequest($params);
    }
}
