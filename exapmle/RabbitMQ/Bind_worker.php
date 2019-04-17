<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-17
 */
require_once __DIR__ . './../../src/Bootstrap.php';

use Zhaqq\Learning\RabbitMQ\MQ;

$exchange = 'direct_logs';

MQ::channel()->exchange_declare($exchange, MQ::EXCHANGE_TYPE_DIRECT, false, false, false);

list($queue_name, ,) = MQ::channel()->queue_declare("", false, false, true, false);

$severities = array_slice($argv, 1);
if(empty($severities )) {
    file_put_contents('php://stderr', "Usage: $argv[0] [info] [warning] [error]\n");
    exit(1);
}

foreach($severities as $severity) {
    MQ::channel()->queue_bind($queue_name, $exchange, $severity);
}

echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function($msg){
    echo ' [x] ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

MQ::channel()->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count(MQ::channel()->callbacks)) {
    MQ::channel()->wait();
}

MQ::channel();