<?php

namespace Fancourier\Request;

use Fancourier\Response\GetRates as GetRatesResponse;

class GetRates extends AbstractRequest implements RequestInterface
{
    protected $resource = 'reports/awb/internal-tariff';
    protected $verb = 'get';

    private $paymentType = self::TYPE_RECIPIENT;
    private $city;
    private $region;
    private $envelopes = 0;
    private $parcels = 0;
    private $weight;
    private $length = 0.1;
    private $width = 0.1;
    private $height = 0.1;
    private $declaredValue;
    private $reimbursementPaymentType = self::TYPE_RECIPIENT;
    private $options = '';
    private $service = self::SERVICE_STANDARD;

    public function __construct()
    {
        parent::__construct();
        $this->response = new GetRatesResponse();
    }

    public function pack()
    {
        return [
            'info' => [
                'service' => $this->service,
                'payment' => $this->paymentType,
                'weight' => $this->weight,
                'options' => $this->packOptions($this->getOptions()),
                'dimensions' => [
                    'length' => $this->length,
                    'width' => $this->width,
                    'height' => $this->height,
                ],
                'packages' => [
                    'parcel' => $this->parcels,
                    'envelope' => $this->envelopes,
                ],
                'declaredValue' => $this->declaredValue,
            ],
            'recipient' => [
                'locality' => $this->city,
                'county' => $this->region,
            ],
            'sender' => [
                'locality' => null,
                'county' => null,
            ],
        ];
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return GetRates
     */
    public function setPaymentType($paymentType)
    {
        if ($paymentType != self::TYPE_RECIPIENT && $paymentType != self::TYPE_SENDER) {
            throw new \InvalidArgumentException("Invalid paymentType value");
        }

        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return GetRates
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     * @return GetRates
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return int
     */
    public function getEnvelopes()
    {
        return $this->envelopes;
    }

    /**
     * @param int $envelopes
     * @return GetRates
     */
    public function setEnvelopes($envelopes)
    {
        $this->envelopes = $envelopes;
        return $this;
    }

    /**
     * @return int
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param int $parcels
     * @return GetRates
     */
    public function setParcels($parcels)
    {
        $this->parcels = $parcels;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     * @return GetRates
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return GetRates
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return GetRates
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return GetRates
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeclaredValue()
    {
        return $this->declaredValue;
    }

    /**
     * @param mixed $declaredValue
     * @return GetRates
     */
    public function setDeclaredValue($declaredValue)
    {
        $this->declaredValue = $declaredValue;
        return $this;
    }

    /**
     * @return string
     * @deprecated
     */
    public function getReimbursementPaymentType()
    {
        return $this->reimbursementPaymentType;
    }

    /**
     * @param string $type
     * @return GetRates
     * @deprecated
     */
    public function setReimbursementPaymentType($type)
    {
        if ($type != self::TYPE_RECIPIENT && $type != self::TYPE_SENDER) {
            throw new \InvalidArgumentException("Invalid reimbursementPaymentType value");
        }

        $this->reimbursementPaymentType = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $options
     * @return GetRates
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return GetRates
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }
}
