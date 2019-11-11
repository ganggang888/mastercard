<?php
/**
 * mastercard-specials-customer-service
 */
namespace mastercard;
class Api
{
    private $clientID = NULL;
    private $url = NULL;
    private $list = [
        'getLanguages'=>'/specials/api/v1/languages',
        'getCategories'=>'/specials/api/v1/categories',
        'getMerchants'=>'/specials/api/v1/merchants',
        'getCountries'=>'/specials/api/v1/countries',
        'getMastercardProducts'=>'/specials/api/v1/mastercard-products',
        'getPrograms'=>'/specials/api/v1/programs',
        'getBenefits'=>'/specials/api/v1/benefits',
        'getOffers'=>'/specials/api/v1/offers',
        'getTags'=>'/specials/api/v1/get_all_tags',
    ];
    
    /**
     * Construct function
     * @param type $clientID clientId 
     * @param type $url url
     */
    public function __construct($clientID = '',$url = '') 
    {
        $this->url = $url;
        $this->clientID = $clientID;
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
}

