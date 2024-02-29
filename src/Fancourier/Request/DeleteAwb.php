<?php

namespace Fancourier\Request;

use Fancourier\Response\DeleteAwb as DeleteAwbResponse;

class DeleteAwb extends AbstractRequest implements RequestInterface
{
    protected $resource = 'awb';
    protected $verb = 'delete';

    private $awb;

    public function __construct()
    {
        parent::__construct();
        $this->response = new DeleteAwbResponse();
    }

    public function pack()
    {
        return ['awb' => $this->awb];
    }

    /**
     * @return mixed
     */
    public function getAwb()
    {
        return $this->awb;
    }

    /**
     * @param mixed $awb
     * @return DeleteAwb
     */
    public function setAwb($awb)
    {
        $this->awb = $awb;
        return $this;
    }
}
