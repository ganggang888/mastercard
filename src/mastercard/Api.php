<?php
/**
 * mastercard-specials-customer-service
 */
namespace mastercard;

class Api
{
    private $clientID = NULL;
    private $url = NULL;
    private $version = 'v1';
    private $list = [
        
    ];
    private $signingKey = NULL;
    
    /**
     * Construct function
     * @param type $clientID clientId 
     * @param type $url url
     */
    public function __construct($clientID = '',$url = '',$version = 'v1') 
    {
        $this->url = $url;
        $this->clientID = $clientID;
        $this->list = [
            'getLanguages'=>"/priceless/specials/{$this->version}/languages",

            'getCategories'=>"/priceless/specials/{$this->version}/categories",
            'getMerchants'=>"/priceless/specials/{$this->version}/merchants",
            'getCountries'=>"/priceless/specials/{$this->version}/countries",
            'getMastercardProducts'=>"/priceless/specials/{$this->version}/mastercard-products",
            'getPrograms'=>"/priceless/specials/{$this->version}/programs",
            'getBenefits'=>"/priceless/specials/{$this->version}/benefits",
            'getOffers'=>"/priceless/specials/{$this->version}/offers",
            'getTags'=>"/priceless/specials/{$this->version}/get-all-tags",
        ];
    }

    /**
     * Url request
     * @param string $params params
     * @return array
     */
    public function getInfo($params = '')
    {
        $url = $this->url.$this->list[$params];
        return $this->getResult($url);
    }
    
    /**
     * Get request
     * @param string $params url name
     * @param array $parment url paramss example : ['a'=>1,'b'=>2]
     * @return array
     */
    public function getRequest($params = '',$parment = [])
    {
        $url = $this->url.$this->list[$params];
        return $this->getResult($url,$parment);
    }
    
    /**
     * post request
     * @param type $api
     * @param array $params
     * @param type $timeout
     * @return array
     */
    public function postRequest($api, array $params = array(), $timeout = 30) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-OpenApi-ClientId:{$this->clientID}"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    
    /**
     * 
     * @param type $get_user_info_url
     * @return type
     */
    function getResult($get_user_info_url = '', $params = [])
    {
        if ($params) {
            $get_user_info_url .= "?".http_build_query($params);
        }
        
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$get_user_info_url);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-OpenApi-ClientId:{$this->clientID}"
        ));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        return $json_obj;
    }


    /**
     * Get request
     * @param string $params url name
     * @param array $parment url paramss example : ['a'=>1,'b'=>2]
     * @return array
     */
    public function getSignRequest($signer = '',$params = '',$parment = [])
    {
        $url = $this->url.$this->list[$params];
        return $this->signGetResult($signer,$url,$parment);
    }

    /**
     * signGetResult
     * @param  [object] $signer      [object signer]
     * @param  string $baseUri     [baseUri]
     * @param  [array] $queryParams [queryParams]
     * @return [type]              [type]
     */
    function signGetResult($signer,$baseUri = '', $queryParams = [])
    {
        $method = 'GET';
        $uri = $baseUri . '?' . http_build_query($queryParams);
        $handle = curl_init($uri);
        $headers = array(
            'Content-Type: application/json',
            'X-OpenApi-ClientId:{$this->clientID}'
        );
        curl_setopt_array($handle, array(CURLOPT_RETURNTRANSFER => 1));
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
        $signer->sign($handle, $method,$headers);
        $result = curl_exec($handle);
        curl_close($handle);
        return json_decode($result,true);
    }
}

