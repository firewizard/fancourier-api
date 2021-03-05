<?php

namespace Fancourier\Response;

class GetRates extends Generic implements ResponseInterface
{
    public function setBody($body)
    {
        if (is_numeric($body)) {
            parent::setBody($body);
            return $this;
        }

        $this->setErrorMessage('Unknown error');
        $this->setErrorCode(-1);
        
        if (preg_match('/(.*?)\((\d+)\)/', $body, $matches)) {
            $this->setErrorMessage($matches[1] ?: 'Unknown error');
            $this->setErrorCode($matches[2]);
        }
        
        return $this;
    }
}
