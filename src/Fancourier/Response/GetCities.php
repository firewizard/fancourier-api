<?php

namespace Fancourier\Response;

class GetCities extends Generic implements ResponseInterface
{
    public function setBody($body)
    {
        if (empty($body)) {
            $this->setErrorMessage("Empty response");
            $this->setErrorCode(-1);
            return $this;
        }

        $body = json_decode($body, true);
        if ('success' != ($body['status'] ?? null)) {
            $this->setErrorMessage($body['message'] ?? "Invalid response");
            $this->setErrorCode(-2);
            return $this;
        }

        parent::setBody($body['data']);

        return $this;
    }
}
