<?php


namespace ODataApi;

/**
 * Class ODataApi
 * @package ODataApi
 */
class ODataApi
{
    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $header;

    /**
     * @var string
     */
    private $urlParams;

    // using in API OData
    public $filter;
    public $orderby;
    public $format; // json | atom

    /**
     * @param string $hash
     */
    public function __construct($url, $hash)
    {
        $this->hash = $hash;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @param $urlParams
     */
    public function setUrlParams($urlParams)
    {
        $this->urlParams = $urlParams;
    }

    /**
     * @return bool|string
     */
    public function query()
    {
        $url = $this->url;
        $ch = curl_init();

        if (!empty($this->urlParams))
            $url .= $this->urlParams;

        curl_setopt($ch, CURLOPT_URL, $url);

        if (!empty($this->header))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}