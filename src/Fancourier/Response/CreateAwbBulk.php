<?php

namespace Fancourier\Response;

class CreateAwbBulk extends Generic implements ResponseInterface
{
    public function setBody($body)
    {
        if (empty($body)) {
            $this->setErrorMessage("Empty response");
            $this->setErrorCode(-1);
            return $this;
        }

        $body = json_decode($body, true);
        if (empty($body['response'][0])) {
            $this->setErrorMessage("Invalid response");
            $this->setErrorCode(-2);
            return $this;
        }

        if (empty($body['response'][0]['awbNumber'])) {
            $this->setErrorMessage(implode('; ', $body['response'][0]['errors'] ?? ['Unknown error']));
            $this->setErrorCode(-3);
            return $this;
        }

        $awbs = [];
        foreach ($body['response'] as $response) {
            if ($response['awbNumber']) {
                $awbs[] = $response['awbNumber'];
            }
        }

        parent::setBody($awbs);
        return $this;
    }
}
