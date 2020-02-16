<?php

namespace Mozafar\WHMCS;

use Mozafar\WHMCS\Exceptions\WHMCSException;

class ApiClient
{
    protected $apiUrl;
    protected $identifier;
    protected $secret;
    protected $responsetype;
    protected $paymentMethod;

    public function __construct()
    {
        $this->apiUrl = config('whmcs.api_url', '');
        $this->identifier = config('whmcs.identifier', '');
        $this->secret = config('whmcs.secret', '');
        $this->responsetype = 'json';
        $this->paymentMethod = '';
    }

    public function makeRequest($params)
    {
        $params['identifier'] = $this->identifier;
        $params['secret'] = $this->secret;
        $params['responsetype'] = $this->responsetype;
        $params['paymentmethod'] = $this->paymentMethod;
        try {
            $client = new \GuzzleHttp\Client(['timeout'  => 10]);
            $headers = [
            ];
            $res = $client->request('POST', $this->apiUrl, [
                'headers' => $headers,
                'form_params' => $params
            ]);
            $result = json_decode($res->getBody(), true);
            if ($result === null) {
                throw new WHMCSException('Invalid WHMCS response');
            }
            if (isset($result['result']) && $result['result'] == 'error') {
                throw new WHMCSException($result['message']);
            }
            return $result;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
