<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-19
 */

namespace Zhaqq\Learning\ArrayFunc;

/**
 * Class ArrayFunc
 * @package Zhaqq\Learning\ArrayFunc
 */
class ArrayFunc
{

    public static function arrayMap(callable $func, array $array)
    {
        return array_map($func, $array);
    }
}
