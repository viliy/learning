<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-17
 */

namespace Zhaqq\Learning\RabbitMQ;


class MQManager
{
    /**
     * @var
     */
    protected $MQ =null;

    private function __construct($MQ)
    {
        if ($MQ instanceof MQ) {

        }
    }

    public static function connection($MQ)
    {
        return new static($MQ);
    }
}