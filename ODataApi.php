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

    public function getHash()
    {
        return $this->hash;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function query()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);

        if (!empty($this->header))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}