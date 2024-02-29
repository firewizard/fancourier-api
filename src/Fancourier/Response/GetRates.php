<?php

namespace Fancourier\Response;

class GetRates extends Generic implements ResponseInterface
{
    public function setBody($body)
    {
        if (empty($body)) {
            $this->setErrorMessage('Unknown error');
            $this->setErrorCode(-1);
        }

        $body = json_decode($body, true);
        if ('success' != ($body['status'] ?? null)) {
            $this->setErrorMessage($body['message'] ?? 'Invalid response');
            $this->setErrorCode(-2);
        }

        if (empty($body['data']['total'])) {
            $this->setErrorMessage('Invalid response, missing total amount');
            $this->setErrorCode(-3);
        }

        parent::setBody($body['data']['total']);

        return $this;
    }
}
