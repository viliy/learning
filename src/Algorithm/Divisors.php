<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-24
 */

namespace Zhaqq\Learning\Algorithm;


class Divisors
{

    public static function divisors($integer)
    {
        $mid = intval(floor($integer / 2));
        for ($i = $mid; $i > 1; $i--) {
            $remainder = $integer / $i;
            if (is_int($remainder)) {
                $arr[] = $remainder;
            }
        }

        return $arr ?? "$integer is prime";
    }
}