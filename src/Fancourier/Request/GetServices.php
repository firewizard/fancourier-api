<?php

namespace Fancourier\Request;

class GetServices extends AbstractRequest implements RequestInterface
{
    protected $resource = 'reports/services';
    protected $verb = 'get';

    public function pack()
    {
        return [];
    }
}
