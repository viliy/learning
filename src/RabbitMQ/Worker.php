<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-16
 */

namespace Zhaqq\Learning\RabbitMQ;

class Worker
{

    /**
     * @param string $key
     * @throws \ErrorException
     */
    public function received($key = 'task_queue')
    {
        MQ::channel()->queue_declare($key, false, true, false, false);

        $callback = function ($msg) {
            echo " [x] Received " . $msg->body . "\n";
            sleep(substr_count($msg->body, '.'));
            echo  " [x] Done" . "\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        MQ::channel()
            ->basic_qos(null, 1, null);
        MQ::channel()
            ->basic_consume($key, '', false, false, false, false, $callback);

    }


    /**
     * @return int
     */
    public function watcher()
    {
        $count =  count(MQ::channel()->callbacks);
        var_dump($count);

        return $count;
    }

    /**
     * @throws \ErrorException
     */
    public function wait()
    {
        MQ::channel()->wait();
    }
}