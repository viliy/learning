<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-16
 */

namespace Zhaqq\Learning\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class MQ
{
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
