<?php

namespace Fancourier\Request\Traits;

use Fancourier\Request\CreateAwb;

trait SendsFile
{
    protected $tempDir = '/tmp';

    public function send()
    {
        if (empty($this->verb)) {
            throw new \DomainException("No request verb implemented");
        }

        $file = $this->pack();
        $data = ['fisier' => new \CURLFile($file, 'text/csv', 'fisier.csv')] + $this->auth->pack();

        $responseString = $this->client->post($this->endpoint . $this->verb, $data);
        if (false === $responseString) {
            $this->response->setErrorCode(-1)->setErrorMessage($this->client->getError());
        } else {
            $this->response->setBody($responseString);
        }

        unlink($file);

        return $this->response;
    }

    /**
     * @return string
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    /**
     * @param string $tempDir
     * @return CreateAwb
     */
    public function setTempDir($tempDir)
    {
        $this->tempDir = $tempDir;
        return $this;
    }
}
