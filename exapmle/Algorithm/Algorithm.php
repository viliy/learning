<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-24
 */


require_once __DIR__ . './../../src/Bootstrap.php';

use Zhaqq\Learning\Algorithm\Algorithm;

var_dump(Algorithm::divisors(12));
var_dump(Algorithm::divisors(25));
var_dump(Algorithm::divisors(13));
var_dump(Algorithm::divisors(10));
var_dump(Algorithm::solution(10));