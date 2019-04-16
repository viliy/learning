<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-16
 */

require_once __DIR__ . './../../src/Bootstrap.php';

$task = new \Zhaqq\Learning\RabbitMQ\Task();

echo 'start sending....', PHP_EOL;
$task->sender('your mother boom');
$task->destroy();
echo 'send complete.', PHP_EOL;

