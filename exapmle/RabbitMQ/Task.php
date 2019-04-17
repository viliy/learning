<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-16
 */

require_once __DIR__ . './../../src/Bootstrap.php';

$task = new \Zhaqq\Learning\RabbitMQ\Task();


$msg = ($argv[1] ?? 'your mother boom') . ' ' .($argv[2] ?? 'boom');
echo 'sending msg....', $msg, PHP_EOL;
$task->sender($msg);
$task->destroy();
echo 'send complete.', PHP_EOL;
