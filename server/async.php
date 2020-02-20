<?php
/**
 * 异步的客户端
 */
$host = '0.0.0.0';  // 需要请求的服务端地址
$port = 9501;       // 服务端的端口
$sock_type = SWOOLE_SOCK_TCP;   // 使用tcp协议,客户端与服务端需要协议一致(健壮的业务应该是服务端接受多种协议)
$sync = SWOOLE_SOCK_ASYNC;
$client = new Swoole\Client($sock_type, $sync);  // 定义异步连接


$client->on("connect", function ($client) {
    $client->send("我要连接服务器");
});

/**
 * 接受服务端的请求数据
 */
$client->on('receive', function ($client, $data) {
    echo "服务端发送了{$data}" . PHP_EOL;
});


$client->on('error', function ($client) {
    echo "连接失败" . PHP_EOL;
});
$client->on('close', function ($client) {
    echo "结束连接" . PHP_EOL;
});

$client->connect($host, $port);

echo "测试异步连接";