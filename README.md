## mastercard-php-sdk

##### composer地址：https://packagist.org/packages/mastercard-priceless-specials-api/php
##### 安装方式：`composer require anduin/mastercard`
安装后的目录结构
![](http://medoc.3tichina.com/Public/Uploads/2019-11-11/5dc923376dae2.png)
##### 使用方法：tests/demo.php
```php
<?php

require_once '../vendor/autoload.php';

use mastercard\Api;
use Mastercard\Developer\OAuth\Utils\AuthenticationUtils;
use Mastercard\Developer\OAuth\OAuth;
use Mastercard\Developer\Signers\CurlRequestSigner;

$signingKey = AuthenticationUtils::loadSigningKey(
                '3ti_prd_key-production.p12',
                '3ti_prd_key', 
                'q1w2e3r4t5');
$consumerKey = 'OH4q7S64RsAQAacQvT6rMgCFjhW9lfq3blaxdq95aac57d39!78ca1d91925b4c7c9088f13c1a4b51460000000000000000';


$signer = new CurlRequestSigner($consumerKey, $signingKey);






try {
    $api = new Api('Aiken_Digital', 'https://api.mastercard.com');
    $info = $api->getSignRequest($signer,'getLanguages');
    //getLanguages
    // var_dump($info);die;
    

    //getCountries
    $getCountries = $api->getSignRequest($signer,'getCountries');
    // var_dump($getCountries);die;
    

    //getCategories
    $lan = current($info['data'])['languageCode'];

    $Categories = $api->getSignRequest($signer,'getCategories', ['language' => $lan]);
    // var_dump($Categories);die;
    

    //getMerchants
    $array = current($Categories['data']); //获取第一个数组
    $getMerchants = $api->getSignRequest($signer,'getMerchants', [
        'merchant_name' => $array['categoryName'],
        'merchant_id' => $array['categoryId'],
        'country_code' => current($getCountries['data'])['countryCode'],
    ]);
    // var_dump($getMerchants);
    
    //getMastercardProducts
    $getMastercardProducts = $api->getSignRequest($signer,'getMastercardProducts', ['language' => $lan]);
    // var_dump($getMastercardProducts);
    
    //getPrograms
    $getPrograms = $api->getSignRequest($signer,'getPrograms', ['language' => $lan, 'eligible_markets' => '']);
    // var_dump($getPrograms);
    

    //getBenefits
    $getBenefits = $api->getSignRequest($signer,'getBenefits', [
        'language' => '',
        'category' => '',
        'eligible_markets' => '',
        'destination_markets' => '',
        'mastercard_product' => '',
        'last_modified_date' => '',
        'coordinates' => '',
        'merchant_name' => '',
        'benefit_title' => '',
        'limit' => '10',
        'offset' => '0',
        'sort' => ''
    ]);
    // var_dump($getBenefits);
    

    //getOffers
    $getOffers = $api->getSignRequest($signer,'getOffers', [
        'language' => '',
        'category' => '',
        'eligible_markets' => '',
        'destination_markets' => '',
        'mastercard_product' => '',
        'program' => '',
        'tags' => '',
        'last_modified_date' => '',
        'coordinates' => '',
        'merchant_name' => '',
        'card_product_id' => '',
        'issuer_id' => '',
        'offer_title' => '',
        'merchant_type' => '',
        'limit' => '10',
        'offset' => '0',
        'sort' => ''
    ]);
    //    var_dump($getOffers);
    //getTags
    $getTags = $api->getSignRequest($signer,'getTags');
    var_dump($getTags);
} catch (Exception $exc) {
    echo $exc->getMessage();
}


```