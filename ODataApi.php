<?php
/**
 *
 * github https://github.com/Primenko/ODataApi.git
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
    private $header = [];

    /**
     * @var boolean $compress
     */
    private $compress = false;

    /**
     * @var string $compressType  ''|deflate|gzip|identity|deflate,gzip
     */
    public $compressType = '';

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
     * @param array $header
     */
    public function setHeader(array $header)
    {
        if (!empty($this->header))
            $this->header = $header;
        else
            $this->header = array_merge($this->header, $header);
    }

    /**
     * @param $gzip
     */
    public function setCompress($bool = false, $type = '')
    {
        if ($bool) {
            $this->compress = $bool;
            $this->compressType = $type;
        }
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

        if (!empty($this->urlParams) && !$metaData)
            $url .= $this->urlParams;

        if ($metaData)
            $url .= '/$metadata';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($this->compress)
            if (PHP_VERSION > 7)
                curl_setopt($ch,CURLOPT_ENCODING, $this->compressType);
            else
                $this->header = array_merge($this->header, ['Accept-Encoding: '.$this->compressType]);

        if (!empty($this->header))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);

        $data = curl_exec($ch);
        curl_close($ch);

        if (preg_match('/"code":500/', $data)) {
            echo $this->urlParams . "\n";
            throw new \Exception($data);
            exit;
        }

        if (preg_match('/"code":401/', $data)) {
            echo $this->urlParams . "\n";
            throw new \Exception($data);
            exit;
        }

        if ($this->compress)
            $data = gzdecode($data);

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
