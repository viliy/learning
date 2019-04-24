<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-24
 */


require_once __DIR__ . './../../src/Bootstrap.php';

use Zhaqq\Learning\Algorithm\Solution;

$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {
    Solution::solution(100);
}
$startEnd = microtime(true);

$a['a'] = $startEnd - $startTime;

$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {
    Solution::solution1(100);
}
$startEnd = microtime(true);

$a['b'] = $startEnd - $startTime;

$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {

    Solution::solution2(100);
}
$startEnd = microtime(true);

$a['c'] = $startEnd - $startTime;
$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {

    Solution::solution3(100);
}
$startEnd = microtime(true);

$a['d'] = $startEnd - $startTime;
$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {
    Solution::solution5(100);
}
$startEnd = microtime(true);

$a['e'] = $startEnd - $startTime;


$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {
    Solution::solution(10);
}
$startEnd = microtime(true);

$b['a'] = $startEnd - $startTime;

$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {
    Solution::solution1(10);
}
$startEnd = microtime(true);

$b['b'] = $startEnd - $startTime;

$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {

    Solution::solution2(10);
}
$startEnd = microtime(true);

$b['c'] = $startEnd - $startTime;
$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {

    Solution::solution3(10);
}
$startEnd = microtime(true);

$b['d'] = $startEnd - $startTime;
$startTime = microtime(true);
for ($i = 1; $i < 1000; $i++) {
    Solution::solution5(10);
}
$startEnd = microtime(true);

$b['e'] = $startEnd - $startTime;


asort($a);
asort($b);
var_dump($a, $b);

echo Solution::solution(100),PHP_EOL;
echo Solution::solution5(100),PHP_EOL;
echo Solution::solution(1000),PHP_EOL;
echo Solution::solution5(1000),PHP_EOL;
