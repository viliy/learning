<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-24
 */

namespace Zhaqq\Learning\Algorithm;


class Algorithm
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

    /**
     *
         function solution1($number)
        {
        $sum = 0;
        for ($i = 3; $i < $number; $i++) {
        if ($i % 3 === 0 || $i % 5 === 0) {
        $sum += $i;
        }
        }
        return $sum;
        }

        function solution2($number)
        {
        return array_sum(array_filter(range(1, $number - 1), function ($item) {
        return $item % 3 == 0 || $item % 5 == 0;
        }));
        }
     *
     *
     * @param $number
     * @return int
     */
    public static function solution($number)
    {
        $arr = [];
        $three = (int)floor(($number - 1) / 3);
        $five = (int)floor(($number - 1) / 5);
        if ($three >= 1) {
            for ($i = 1; $i <= $three; $i++) {
                $arr[] = $i * 3;
            }
        }
        if ($five >= 1) {
            for ($i = 1; $i <= $five; $i++) {
                $arr[] = $i * 5;
            }
        }

        return array_sum(array_unique($arr));
    }
}