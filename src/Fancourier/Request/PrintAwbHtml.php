<?php

namespace Fancourier\Request;

class PrintAwbHtml extends PrintAwb implements RequestInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->setPdf(false);
    }
}
