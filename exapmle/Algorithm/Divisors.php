<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-24
 */

require_once __DIR__ . './../../src/Bootstrap.php';

use Zhaqq\Learning\Algorithm\Divisors;

var_dump(Divisors::divisors(12));
var_dump(Divisors::divisors(25));
var_dump(Divisors::divisors(13));
var_dump(Divisors::divisors(10));
