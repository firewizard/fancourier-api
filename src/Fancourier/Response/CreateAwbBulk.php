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

        $this->body = [];

        $body = preg_replace("/\r|\r\n/", "\n", trim($body));
        foreach (explode("\n", $body) as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $response = new CreateAwb();
            $response->setBody($line);
            $this->body[] = $response;
        }

        return $this;
    }
}
