<?php
/**
 *
 * github https://github.com/Primenko/ODataApi.php
 *
 */

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
    public function query($metaData = false)
    {
        $url = $this->url;
        $ch = curl_init();

        if (!empty($this->urlParams) && !$metaData)
            $url .= $this->urlParams;

        if ($metaData)
            $url .= '/$metadata';


        curl_setopt($ch, CURLOPT_URL, $url);

        if (!empty($this->header))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @return bool|string
     */
    public function queryTypes()
    {
        $url = $this->url;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        if (!empty($this->header))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @return mixed
     */
    public function getMetaData()
    {
        return $this->query(true);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->query();
    }
}
