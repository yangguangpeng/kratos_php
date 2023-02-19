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
$request->setUserId(100);

$metadata = ['Authorization'=>['Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.PyJpI17-b9uKZnUGk5YEzRPDYsA-8cNiT7crKGIHfBs']];
//$metadata = [];

//调用远程服务
$get = $client->GetDemo($request,$metadata)->wait();

list($reply, $status) = $get;

if ($reply) {
    //数组
    $getdata = $reply->getResult();
    var_dump($getdata);
} else {
    var_dump($status);
}

