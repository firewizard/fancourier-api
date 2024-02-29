<?php

namespace Fancourier\Response;

class TrackAwb extends Generic implements ResponseInterface
{
    public function setBody($body)
    {
        $data = json_decode($body, true);
        if (empty($data['status'])) {
            $this->setErrorMessage($body);
            $this->setErrorCode(-1);
            return $this;
        }

        parent::setBody($data['data']);

        return $this;
    }
}
