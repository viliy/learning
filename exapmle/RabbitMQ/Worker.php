<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-16
 */

require_once __DIR__ . './../../vendor/autoload.php';

$work = new \Zhaqq\Learning\RabbitMQ\Worker();

echo 'Worker.....' . PHP_EOL;
try {
    $work->received();
    while ($work->watcher()) {
        $work->wait();
    };
} catch (\Exception $e) {
    echo $e->getMessage();
}
