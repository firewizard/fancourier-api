<?php

namespace Fancourier\Request;

interface RequestInterface
{
    public function send($username, $password, $clientId = null);

    public function pack();
}
