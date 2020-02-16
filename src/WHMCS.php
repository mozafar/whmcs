<?php

use GuzzleHttp\Client;
use Mozafar\WHMCS\Exceptions\WHMCSException;

class WHMCS
{
    protected $apiUrl;
    protected $identifier;
    protected $secret;
    protected $responsetype;

    public function __construct()
    {
        $this->apiUrl = config('whmcs.api_url', '');
        $this->identifier = config('whmcs.identifier', '');
        $this->secret = config('whmcs.secret', '');
        $this->responsetype = config('whmcs.responsetype', 'json');
    }

    protected function makeRequest($params)
    {
        $params['username'] = $this->identifier;
        $params['password'] = $this->secret;
        $params['responsetype'] = $this->responsetype;
        $params['paymentmethod'] = $this->paymentMethod;

        try {
            $client = new Client(['timeout'  => 30]);

            $headers = [
            ];

            $res = $client->request('POST', $this->apiUrl, [
                'headers' => $headers,
                'form_params' => $params
            ]);

            $result = json_decode($res->getBody());
            $result = get_object_vars($result);
            if (isset($result['result']) && $result['result'] == 'error') {
                if (strpos($result['message'], 'Registrar Error Message') !== false) {
                    throw new WHMCSException($result['error']);
                }
                $message = $result['message'];
                $trans = __("messages.$message");
                $message = "messages.$message" == $trans ? $message : $trans;
                if (strpos($result['message'], 'Email or Password Invalid') !== false) {
                    throw new WHMCSException($message);
                }
                throw new WHMCSException($message);
            }
            $result = json_decode(json_encode($result), true);
            return $result;
        } catch (\Throwable $e) {
            throw new WHMCSException($e->getMessage());
        }
    }
}
