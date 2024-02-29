<?php

namespace Fancourier\Request;

use Fancourier\Response\TrackAwbBulk as TrackAwbBulkResponse;

class TrackAwbBulk extends TrackAwb implements RequestInterface
{
    const STANDARD_XML_FULL = 1; //not implemented yet
    const STANDARD_XML_SIMPLE = 2; //not implemented yet
    const STANDARD_XML_DETAILS = 3; //not implemented yet
    const STANDARD_JSON = 4;

    public function __construct()
    {
        parent::__construct();
        $this->response = new TrackAwbBulkResponse();
    }

    /**
     * @return mixed
     * @deprecated
     */
    public function getStandard()
    {
        return $this->standard;
    }

    /**
     * @param mixed $standard
     * @return TrackAwbBulk
     * @deprecated
     */
    public function setStandard($standard)
    {
        $this->standard = $standard;
        return $this;
    }

    /**
     * @return array
     */
    public function getAwbs()
    {
        return $this->getAwb();
    }

    /**
     * @param array $awbs
     * @return TrackAwbBulk
     */
    public function setAwbs(array $awbs)
    {
        return $this->setAwb($awbs);
    }
}
