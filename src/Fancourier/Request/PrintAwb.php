<?php

namespace Fancourier\Request;

class PrintAwb extends AbstractRequest implements RequestInterface
{
    protected $resource = 'awb/label';
    protected $verb = 'get';

    private $awb;
    private $pageSize = 'A6';
    private $label;
    private $pdf = true;

    private $lang = 'ro';

    public function pack()
    {
        return [
            'awbs' => is_array($this->awb) ? $this->awb : [$this->awb],
            'pdf' => $this->pdf,
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
     * @return PrintAwb
     */
    public function setAwb($awb)
    {
        $this->awb = $awb;
        return $this;
    }

    /**
     * @return string
     * @deprecated
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param string $pageSize
     * @return PrintAwb
     * @deprecated
     */
    public function setPageSize($pageSize)
    {
        $pageSize = strtoupper($pageSize);
        if (!in_array($pageSize, ['A4', 'A5', 'A6'])) {
            $pageSize = 'A6';
        }

        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * @return mixed
     * @deprecated
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return PrintAwb
     * @deprecated
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * @return PrintAwb
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

    /**
     * @return bool
     */
    public function isPdf()
    {
        return $this->pdf;
    }

    /**
     * @param bool $asPdf
     * @return PrintAwb
     */
    public function setPdf(bool $asPdf)
    {
        $this->pdf = $asPdf;
        return $this;
    }
}
