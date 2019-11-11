## mastercard-php-sdk

##### composer地址：https://packagist.org/packages/anduin/mastercard
##### 安装方式：`composer require anduin/mastercard`
安装后的目录结构
![](http://medoc.3tichina.com/Public/Uploads/2019-11-11/5dc923376dae2.png)
##### 使用方法：tests/demo.php
```php
<?php

require_once '../vendor/autoload.php';

use mastercard\Api;
use \Exception;

try {
    $api = new Api('Aiken_Digital', 'https://specials.priceless.com');

    //getLanguages
    $info = $api->getInfo('getLanguages');
    //var_dump($info);
    

    //getCountries
    $getCountries = $api->getInfo('getCountries');
    //var_dump($getCountries);
    

    //getCategories
    $lan = current($info['data'])['languageCode'];

    $Categories = $api->getRequest('getCategories', ['language' => $lan]);
    //var_dump($Categories);
    

    //getMerchants
    $array = current($Categories['data']); //获取第一个数组
    $getMerchants = $api->getRequest('getMerchants', [
        'merchant_name' => $array['categoryName'],
        'merchant_id' => $array['categoryId'],
        'country_code' => current($getCountries['data'])['countryCode'],
    ]);
    //var_dump($getMerchants);
    
    //getMastercardProducts
    $getMastercardProducts = $api->getRequest('getMastercardProducts', ['language' => $lan]);
    //var_dump($getMastercardProducts);
    
    //getPrograms
    $getPrograms = $api->getRequest('getPrograms', ['language' => $lan, 'eligible_markets' => '']);
    //var_dump($getPrograms);
    

    //getBenefits
    $getBenefits = $api->getRequest('getBenefits', [
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
    //var_dump($getBenefits);
    

    //getOffers
    $getOffers = $api->getRequest('getOffers', [
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
    $getTags = $api->getRequest('getTags');
    var_dump($getTags);
} catch (Exception $exc) {
    echo $exc->getMessage();
}


```