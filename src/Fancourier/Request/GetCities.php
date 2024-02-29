<?php

namespace Fancourier\Request;

use Fancourier\Response\GetCities as GetCitiesResponse;

class GetCities extends AbstractRequest implements RequestInterface
{
    protected $resource = 'reports/localities';
    protected $verb = 'get';

    protected $county;

    public function __construct($county = null)
    {
        parent::__construct();
        $this->response = new GetCitiesResponse();

        if ($county) {
            $this->county = $county;
        }
    }

    public function pack()
    {
        return array_filter(['county' => $this->county]);
    }
}
