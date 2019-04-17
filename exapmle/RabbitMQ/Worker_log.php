<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-17
 */


require_once __DIR__ . './../../src/Bootstrap.php';

use Zhaqq\Learning\RabbitMQ\MQ;

$exchange = 'logs';

MQ::channel()->exchange_declare($exchange, MQ::EXCHANGE_TYPE_FANOUT, false, false, false);

list($queue_name, ,) = MQ::channel()->queue_declare("", false, false, true, false);

MQ::channel()->queue_bind($queue_name, $exchange);

echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

$callback = function($msg){
    echo ' [x] ', $msg->body, "\n";
};

MQ::channel()->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count(MQ::channel()->callbacks)) {
    MQ::channel()->wait();
}

MQ::destroy();