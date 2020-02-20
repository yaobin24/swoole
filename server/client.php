<?php
/**
 * swoole实现tcp的同步客户端
 */
$host = '0.0.0.0';  // 需要请求的服务端地址
$port = 9501;       // 服务端的端口
$sock_type = SWOOLE_SOCK_TCP;   // 使用tcp协议,客户端与服务端需要协议一致(健壮的业务应该是服务端接受多种协议)
$client = new Swoole\Client($sock_type);

// 连接服务器
if (!$client->connect($host, $port)) {
    echo "连接失败";
    exit;
}

// 发送信息给服务端
$client->send("我要连接服务器");

// 接受来自server的数据
$result = $client->recv();
echo $result;

// 开始测试: php server/client.php
