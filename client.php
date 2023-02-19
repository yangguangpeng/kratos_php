<?php

require __DIR__ . '/vendor/autoload.php';

//引入 composer 的自动载加
use Api\Helloworld\V1\GetDemoRequest;
use \Grpc\ChannelCredentials;

class BaseClient extends \Grpc\BaseStub
{

    public function __construct($hostname, $opts, $channel = null)
    {
        parent::__construct($hostname, $opts, $channel);
    }

    public function GetDemo(\Api\Helloworld\V1\GetDemoRequest $argument, $metadata = [], $options = [])
    {
        return $this->_simpleRequest('/api.helloworld.v1.Demo/GetDemo',
            $argument,
            ['\Api\Helloworld\V1\GetDemoReply', 'decode'],
            $metadata, $options);
    }
}


//用于连接 服务端
$client = new BaseClient('127.0.0.1:8080', [
    'credentials' => ChannelCredentials::createInsecure()
]);
//
//实例化 TestRequest 请求类
$request = new GetDemoRequest();
$request->setUserId(1);

//调用远程服务
$get = $client->GetDemo($request)->wait();


list($reply, $status) = $get;

//数组
$getdata = $reply->getResult();

var_dump($getdata);