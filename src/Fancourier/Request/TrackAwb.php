<?php

namespace Fancourier\Request;

use Fancourier\Response\TrackAwb as TrackAwbResponse;

class TrackAwb extends AbstractRequest implements RequestInterface
{
    const MODE_LAST_STATUS = 1;
    const MODE_LAST = 2;
    const MODE_FULL = 3;
    const MODE_RECEIPT = 4;
    const MODE_JSON = 5;

    protected $resource = 'reports/awb/tracking';
    protected $verb = 'get';

    protected $awb;
    protected $displayMode = self::MODE_FULL;
    protected $lang = 'ro';

    public function __construct()
    {
        parent::__construct();
        $this->response = new TrackAwbResponse();

        return $this;
    }

    public function pack()
    {
        return [
            'awb' => is_array($this->awb) ? $this->awb : [$this->awb],
            'language' => $this->lang,
        ];
    }

    /**
     * @return mixed
     */
    public function getAwb()
    {
        return $this->awb;
    }

    /**
     * @param mixed $awb
     * @return TrackAwb
     */
    public function setAwb($awb)
    {
        $this->awb = $awb;
        return $this;
    }

    /**
     * @return mixed
     * @deprecated
     */
    public function getDisplayMode()
    {
        return $this->displayMode;
    }

    /**
     * @param mixed $displayMode
     * @return TrackAwb
     * @deprecated
     */
    public function setDisplayMode($displayMode)
    {
        $this->displayMode = $displayMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return TrackAwb
     */
    public function setLang($lang)
    {
        $lang = strtolower($lang);
        if (!in_array($lang, ['ro', 'en'])) {
            $lang = 'ro';
        }

        $this->lang = $lang;
        return $this;
    }
}
