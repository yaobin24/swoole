<?php
/**
 * swoole的tcp服务端
 */

$host = '0.0.0.0';
$port = 9501;
$mode = SWOOLE_PROCESS;
$sock_type = SWOOLE_SOCK_TCP;   // 使用tcp协议

// 初始化swoole服务，并定义监听地址、端口、运行模式、以及通讯协议
$service = new Swoole\Server($host, $port, $mode, $sock_type);

// 设置服务的参数
$service->set(array(
//    'max_request' => 50,        // 最大连接数
//    'daemonize' => false,        // 守护进程
//    'reactor_num' => 2,         // 线程数
//    'worker_num' => 4,          //进程数
));

/**
 * 监听连接事件
 * $fd 客户端连接的唯一标示
 * $reactor_id 线程id
 */
$service->on('connect', function ($service, $fd, $reactor_id) {
    echo "客户端请求了连接:$fd" . PHP_EOL;
});

/**
 * 接受客户端的请求数据
 */
$service->on('receive', function ($service, $fd, $reactor_id, $data) {
    echo "{$fd}:发送了{$data}" . PHP_EOL;
    $service->send($fd, "客户端接受到了请求。");
});


/**
 * 客户端连接关闭
 */
$service->on('close', function ($service, $fd, $reactor_id) {
    echo "{$fd}——{$reactor_id}:关闭了请求" . PHP_EOL;
});


//启动服务器
$service->start();
// 开始测试: php server/service.php
// 测试使用，未开启常驻进程。mac测试：使用control+C 关闭.
// 查看端口进程 lsof -i : 9501
// 结束进程 ： kill -9 7进程id
