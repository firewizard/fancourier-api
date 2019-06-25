<?php

namespace Fancourier\Response;

class CreateAwb extends Generic implements ResponseInterface
{
    public function setBody($body)
    {
        if (empty($body)) {
            $this->setErrorMessage("Empty response");
            $this->setErrorCode(-1);
            return $this;
        }

        $body = str_getcsv($body);
        if (count($body) == 1) {
            $this->setErrorMessage($body[0]);
            $this->setErrorCode(0);
            return $this;
        }

        if ($body[1] && !empty($body[2])) {
            parent::setBody($body[2]);
            return $this;
        }

        $this->setErrorMessage(empty($body[2]) ? '' : $body[2]);
        $this->setErrorCode(-2);

        return $this;
    }
}
