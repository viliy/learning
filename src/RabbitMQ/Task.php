<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-16
 */

namespace Zhaqq\Learning\RabbitMQ;


use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Message\AMQPMessage;

class task
{
    /**
     * @var \AMQPChannel
     */
    protected $channel;

    /**
     * @var AbstractConnection
     */
    protected $connection;


    public function sender($message, $key = 'task_queue')
    {
        // 第三个参数表示是否持久化 防止崩溃后丢失
        MQ::channel()->queue_declare($key, false, true, false, false);

        $msg = new AMQPMessage(
            $message,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        MQ::channel()->basic_publish($msg, '', $key);
    }

    public function destroy()
    {
        MQ::destroy();
    }
}