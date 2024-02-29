<?php

namespace Fancourier\Request;

use Fancourier\Client;
use Fancourier\Response\Generic;

abstract class AbstractRequest implements RequestInterface
{
    const TYPE_RECIPIENT = 'destinatar';
    const TYPE_SENDER = 'expeditor';

    const SERVICE_STANDARD = 'Standard';
    const SERVICE_REDCODE = 'RedCode';
    const SERVICE_CAIET_SARCINI = 'Caiet Sarcini';
    const SERVICE_LOCO_SAMEDAY_1H = 'Loco Sameday 1H';
    const SERVICE_LOCO_SAMEDAY_2H = 'Loco Sameday 2H';
    const SERVICE_LOCO_SAMEDAY_4H = 'Loco Sameday 4H';
    const SERVICE_LOCO_SAMEDAY_6H = 'Loco Sameday 6H';
    const SERVICE_CONT_COLECTOR = 'Cont Colector';
    const SERVICE_LOCO_SAMEDAY_1H_CONT_COLECTOR = 'Loco Sameday 1H-Cont Colector';
    const SERVICE_LOCO_SAMEDAY_2H_CONT_COLECTOR = 'Loco Sameday 2H-Cont Colector';
    const SERVICE_LOCO_SAMEDAY_4H_CONT_COLECTOR = 'Loco Sameday 4H-Cont Colector';
    const SERVICE_LOCO_SAMEDAY_6H_CONT_COLECTOR = 'Loco Sameday 6H-Cont Colector';
    const SERVICE_RED_CODE_CONT_COLECTOR = 'Red code-Cont Colector';
    const SERVICE_PRODUSE_ALBE = 'Produse Albe';
    const SERVICE_PRODUSE_ALBE_CONT_COLECTOR = 'Produse Albe-Cont Colector';
    const SERVICE_TRANSPORT_MARFA = 'Transport Marfa';
    const SERVICE_TRANSPORT_MARFA_CONT_COLECTOR = 'Transport Marfa-Cont Colector';
    const SERVICE_TRANSPORT_MARFA_PRODUSE_ALBE = 'Transport Marfa Produse Albe';
    const SERVICE_TRANSPORT_MARFA_PRODUSE_ALBE_CONT_COLECTOR = 'Transport Marfa Produse Albe-Cont Colector';

    const OPTION_EPOD = 1;
    const OPTION_OPEN = 2;
    const OPTION_FANHQ = 4;
    const OPTION_SATURDAY = 8;

    protected $endpoint = 'https://api.fancourier.ro/';

    protected $resource;

    protected $verb = 'post';

    protected $authToken;

    /** @var Client */
    protected $client;

    /** @var Generic */
    protected $response;

    public function __construct()
    {
        $this->client = new Client();
        $this->response = new Generic();
    }

    protected function authenticate($username, $password)
    {
        $response = $this->client->post($this->endpoint . 'login', [
            'username' => $username,
            'password' => $password,
        ]);

        if ($response && ($response = json_decode($response, true))) {
            if ('success' == $response['status'] && !empty($response['data']['token'])) {
                $this->authToken = $response['data']['token'];
            }
        }

        return $this;
    }

    /**
     * @return Generic
     */
    public function send($username, $password, $clientId = null)
    {
        if (empty($this->resource)) {
            throw new \DomainException("Resource not defined");
        }

        if (!in_array($this->verb, ['post', 'get', 'delete'])) {
            throw new \DomainException("Invalid verb, should be post, get or delete");
        }

        if (empty($this->authToken)) {
            $this->authenticate($username, $password);
        }

        if (empty($this->authToken)) {
            throw new \Exception('Authentication failed');
        }

        $this->client->setBearerToken($this->authToken);

        $data = $this->pack();

        if ($clientId) {
            $data['clientId'] = $clientId;
        }

        $responseString = $this->client->{$this->verb}($this->endpoint . ltrim($this->resource, '/'), $data);
        if (!$responseString) {
            $this->response->setErrorCode(-1)->setErrorMessage($this->client->getError());
        } else {
            $this->response->setBody($responseString);
        }

        return $this->response;
    }

    /**
     * @return array
     */
    protected function packOptions($options)
    {
        $options = (int)$options;
        
        $opts = [];
        if ($options & static::OPTION_EPOD) {
            $opts[] = "X"; //'ePOD';
        }

        if ($options & static::OPTION_OPEN) {
            $opts[] = "A"; //'Deschidere la livrare';
        }

        if ($options & static::OPTION_FANHQ) {
            $opts[] = "D"; //'Livrare din sediul FAN Courier';
        }

        if ($options & static::OPTION_SATURDAY) {
            $opts[] = "S"; //'Livrare sambata';
        }

        return $opts;
    }
}
