<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-16
 */

namespace Zhaqq\Learning\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class MQ
 * @package Zhaqq\Learning\RabbitMQ
 */
class MQ
{

    const EXCHANGE_TYPE_FANOUT = 'fanout';

    const EXCHANGE_TYPE_DIRECT = 'direct';

    /**
     * @var array
     */
    protected static $config = [];

    /**
     * @var AMQPStreamConnection
     */
    protected static $AMQPStream = null;

    /**
     * @var AMQPChannel
     */
    protected static $channel = null;

    /**
     * @var null
     */
    protected static $message = null;

    /**
     * @return AMQPStreamConnection
     */
    public static function connection()
    {
        $config = self::getConfig();

        if (is_null(self::$AMQPStream)) {
            self::$AMQPStream = new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['user'],
                $config['password']
            );
        }
        if (!self::$AMQPStream->isConnected()) {
            self::$AMQPStream->reconnect();
        }

        return self::$AMQPStream;
    }

    /**
     * @return AMQPChannel
     */
    public static function channel()
    {
        if (empty(self::$channel)) {
            self::$channel = self::connection()->channel();
        }

        return self::$channel;
    }

    /**
     * @param $message
     * @param int $deliveryMode
     * @return AMQPMessage
     */
    public static function message($message, $deliveryMode = AMQPMessage::DELIVERY_MODE_PERSISTENT)
    {
        return new AMQPMessage(
            $message,
            [
                'delivery_mode' => $deliveryMode
            ]
        );
    }

    /**
     * @param $key
     * @param bool $passive
     * @param bool $durable
     * @param bool $exclusive
     * @param bool $autoDelete
     * @return mixed|null
     */
    public static function queueDeclare($key, $passive = false, $durable = true, $exclusive = false, $autoDelete = false)
    {
        return self::channel()->queue_declare($key, $passive, $durable, $exclusive, $autoDelete);
    }

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        if (empty(self::$config)) {
            self::setConfig();
        }

        return self::$config;
    }

    /**
     * @param array $config
     */
    public static function setConfig()
    {
        self::$config = include __DIR__ . '/config.php';
    }

    public static function destroy()
    {
        if (!is_null(self::$AMQPStream) && self::$AMQPStream instanceof AMQPStreamConnection) {
            self::$AMQPStream->channel()->close();
            self::$AMQPStream->close();
        }
    }
}
