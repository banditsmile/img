<?php
include 'bce-php-sdk-0.9.16\BaiduBce.phar'; // 下载地址: https://cloud.baidu.com/doc/Developer/index.html

use BaiduBce\Auth\BceV1Signer;
use BaiduBce\BceBaseClient;
use BaiduBce\Http\BceHttpClient;
use BaiduBce\Http\HttpHeaders;
use BaiduBce\Http\HttpMethod;
use BaiduBce\Http\HttpContentTypes;


class ApiCenterClient extends BceBaseClient
{
    private $signer;
    private $httpClient;

    function __construct(array $config)
    {
        parent::__construct($config, 'apiexplorer');
        $this->signer = new BceV1Signer();
        $this->httpClient = new BceHttpClient();
    }

    private function sendRequest($httpMethod, array $varArgs, $path)
    {
        $defaultArgs = array(
            'config' => array(),
            'body' => null,
            'headers' => array(),
            'params' => array(),
        );

        $args = array_merge($defaultArgs, $varArgs);
        if (empty($args['config'])) {
            $config = $this->config;
        } else {
            $config = array_merge(
                array(),
                $this->config,
                $args['config']
            );
        }
        if (!isset($args['headers'][HttpHeaders::CONTENT_TYPE])) {
            $args['headers'][HttpHeaders::CONTENT_TYPE] = HttpContentTypes::JSON;
        }
        $response = $this->httpClient->sendRequest(
            $config,
            $httpMethod,
            $path,
            $args['body'],
            $args['headers'],
            $args['params'],
            $this->signer
        );

        $result = $this->parseJsonResult($response['body']);
        $result->metadata = $this->convertHttpHeadersToMetadata($response['headers']);
        return $result;
    }

    public function demo($options = array())
    {
        list($config) = $this->parseOptions($options, 'config');

        $headers = array();
        $headers['Content-Type'] = 'application/json;charset=UTF-8';

        $params = array();

        $params['access_token'] = '24.5752ebfedc24ce00ae74b9678026f77e.2592000.1651978846.282335-25925289';
        $params['url'] = 'https://baidu-ai.bj.bcebos.com/image-process/%E5%9B%BE%E5%83%8F%E4%BF%AE%E5%A4%8D.jpeg';

        $body = "{\"url\": \"https:\/\/baidu-ai.bj.bcebos.com\/image-process\/%E5%9B%BE%E5%83%8F%E4%BF%AE%E5%A4%8D.jpeg\", \"rectangle\": [{\"width\": 300, \"top\": 132, \"height\": 100, \"left\": 397}]}";

        return $this->sendRequest(
            HttpMethod::POST,
            array(
                'config' => $config,
                'params' => $params,
                'body' => $body,
                'headers' => $headers,
            ),
            '/rest/2.0/image-process/v1/inpainting'
        );
    }
}

$configs = array(
    'credentials' => array(
        'ak' => 'Y2GqEdSa24EeRiK426VllUYM',
        'sk' => 'mVyhtNMUp4awBb7IGzXGDfGTV1aTluC0',
    ),
    'endpoint' => 'https://aip.baidubce.com',
);

$client = new ApiCenterClient($configs);
$res = $client->demo(array());
print_r($res);