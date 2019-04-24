<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-24
 */

namespace Zhaqq\Learning\Algorithm;

/**
 * If we list all the natural numbers below 10 that are multiples of 3 or 5, we get 3, 5, 6 and 9. The sum of these multiples is 23.
 *
 * Class Solution
 * @package Zhaqq\Learning\Divisors
 */
class Solution
{

    /**
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
                if ($five >= 1 && $i <= $five) {
                    $arr[] = $i * 5;
                }
            }
        }

        return array_sum(array_unique($arr));
    }

    public static function solution1($number)
    {
        $sum = 0;
        for ($i = 3; $i < $number; $i++) {
            if ($i % 3 === 0 || $i % 5 === 0) {
                $sum += $i;
            }
        }
        return $sum;
    }

    public static function solution2($number)
    {
        return array_sum(array_filter(range(1, $number - 1), function ($item) {
            return $item % 3 == 0 || $item % 5 == 0;
        }));
    }

    public static function solution3($number)
    {
        $i = 1;
        $sum = 0;
        $isFive = true;
        while (true) {
            if (($a = 3 * $i) >= $number) {
                break;
            }
            $sum += $a;
            if ($isFive) {
                $b = 5 * $i;
                if (($isFive = $b < $number) && 0 !== $b % 3) {
                    $sum += $b;
                }
            }
            $i++;
        }

        return $sum;
    }

    public static function solution5($number)
    {
        $i = 1;
        $sum = 0;
        while (true) {
            if (($a = 3 * $i) >= $number) {
                break;
            }
            $sum += $a;
            $b = 5 * $i;
            if ($b < $number && 0 !== $b % 3) {
                $sum += $b;
            }
            $i++;
        }

        return $sum;
    }

    public static function solution6($number)
    {
        $threes = floor(($number - 1) / 3);
        $fives = floor(($number - 1) / 5);
        $threesAndFives = floor(($number - 1) / 15);

        $callback = function ($static, $times) {
            return $static * ($times + 1) * $times / 2;
        };

        return $callback(3, $threes) + $callback(5, $fives) - $callback(15, $threesAndFives);
    }
}