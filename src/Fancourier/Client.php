<?php

namespace Fancourier;

class Client
{
    private $curl;

    private $error;

    private $useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:122.0) Gecko/20100101 Firefox/122.0';

    private $bearerToken;

    public function __construct()
    {
    }

    public function post($url, array $data)
    {
        return $this->request('post', $url, $data);
    }

    public function get($url, array $data = [])
    {
        return $this->request('get', $url, $data);
    }

    public function delete($url, array $data = [])
    {
        return $this->request('delete', $url, $data);
    }

    public function request($method, $url, array $data)
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);

        $headers = ["Accept: application/json"];
        if ($this->bearerToken) {
            $headers[] = "Authorization: Bearer {$this->bearerToken}";
        }

        $data = http_build_query($data);
        switch (strtolower($method)) {
            case 'post':
                curl_setopt($this->curl, CURLOPT_POST, 1);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
                break;

            case 'get':
                if ($data) {
                    $url .= '?' . $data;
                }
                break;

            case 'delete':
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
                break;
        }

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($this->curl, CURLOPT_URL, $url);
        $response = curl_exec($this->curl);

        if (!curl_error($this->curl) && $response) {
            curl_close($this->curl);
            return $response;
        }

        $this->setError(curl_error($this->curl));

        curl_close($this->curl);
        return false;
    }

    public function setOption($option, $value)
    {
        curl_setopt($this->curl, $option, $value);
        return $this;
    }

    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setBearerToken($token)
    {
        $this->bearerToken = $token;
        return $this;
    }
}
