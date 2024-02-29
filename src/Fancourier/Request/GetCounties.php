<?php

namespace Fancourier\Request;

class GetCounties extends AbstractRequest implements RequestInterface
{
    protected $resource = 'reports/counties';
    protected $verb = 'get';

    public function pack()
    {
        return [];
    }
}
