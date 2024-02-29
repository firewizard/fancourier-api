<?php

namespace Fancourier\Request;

use Fancourier\Response\CreateAwbBulk as CreateAwbBulkResponse;

/**
 * Class CreateAwb
 * @package Fancourier\Request
 * @SuppressWarnings(PHPMD)
 */
class CreateAwbBulk extends CreateAwb implements RequestInterface
{
    protected $requests = [];

    public function __construct()
    {
        AbstractRequest::__construct();
        $this->response = new CreateAwbBulkResponse();
    }

    public function pack()
    {
        if (empty($this->requests)) {
            throw new \Exception("Cannon create AWBs from an empty list");
        }

        $finalPayload = ['shipments' => []];
        foreach ($this->requests as $request) {
            $payload = $request->pack();
            $finalPayload['shipments'][] = $payload['shipments'][0];
        }

        return $finalPayload;
    }

    public function append(CreateAwb $request)
    {
        $this->requests[] = $request;
        return $this;
    }
}
