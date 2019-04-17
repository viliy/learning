<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-17
 */

require_once __DIR__ . './../../src/Bootstrap.php';

use PhpAmqpLib\Message\AMQPMessage;
use Zhaqq\Learning\RabbitMQ\MQ;

$exchange = 'logs';

MQ::channel()->exchange_declare($exchange, MQ::EXCHANGE_TYPE_FANOUT, false, false, false);

$data = isset($argv['1']) ? implode(' ', array_slice($argv, 1)) : "info: Hello World!";

$msg = new AMQPMessage($data);

MQ::channel()->basic_publish($msg, $exchange);

echo " [x] Sent ", $data, "\n";

MQ::destroy();