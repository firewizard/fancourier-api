<?php

namespace Fancourier\Request;

use Fancourier\Auth;
use Fancourier\Client;
use Fancourier\Response\Generic;

abstract class AbstractRequest implements RequestInterface
{
    const TYPE_RECIPIENT = 'destinatar';
    const TYPE_SENDER = 'expeditor';

    const SERVICE_STANDARD = 'standard';

    protected $endpoint = 'https://www.selfawb.ro/';

    protected $verb;

    /** @var Auth */
    protected $auth;

    /** @var Client */
    protected $client;

    /** @var Generic */
    protected $response;

    public function __construct()
    {
        $this->client = new Client();
        $this->response = new Generic();
    }

    public function authenticate(Auth $auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * @return Generic
     */
    public function send()
    {
        if (empty($this->verb)) {
            throw new \DomainException("No request verb implemented");
        }

        $data = array_merge(
            $this->auth->pack(),
            $this->pack()
        );

        $responseString = $this->client->post($this->endpoint . $this->verb, $data);
        if (false === $responseString) {
            $this->response->setErrorCode(-1)->setErrorMessage($this->client->getError());
        } else {
            $this->response->setBody($responseString);
        }

        return $this->response;
    }
}
