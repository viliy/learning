<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-17
 */
require_once __DIR__ . './../../src/Bootstrap.php';

use PhpAmqpLib\Message\AMQPMessage;
use Zhaqq\Learning\RabbitMQ\MQ;

$exchange = 'direct_logs';

MQ::channel()->exchange_declare($exchange, MQ::EXCHANGE_TYPE_DIRECT, false, false, false);

$severity = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'info';

$data = implode(' ', array_slice($argv, 2));
if(empty($data)) $data = "Hello World!";

$msg = new AMQPMessage($data);

MQ::channel()->basic_publish($msg, $exchange, $severity);

echo " [x] Sent ",$severity,':',$data," \n";

MQ::destroy();