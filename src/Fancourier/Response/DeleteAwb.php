<?php

namespace Fancourier\Response;

class DeleteAwb extends Generic implements ResponseInterface
{
    public function setBody($body)
    {
        if (empty($body)) {
            $this->setErrorMessage("Empty response");
            $this->setErrorCode(-1);
            return $this;
        }

        $body = json_decode($body, true);
        if (empty($body['status']) || 'success' != $body['status']) {
            $this->setErrorMessage("Error deleting AWB");
            $this->setErrorCode(-2);
            return $this;
        }

        parent::setBody(true);
        return $this;
    }
}
