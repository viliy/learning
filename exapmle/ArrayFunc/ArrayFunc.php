<?php
/**
 * @author: ZhaQiu
 * @time: 2019-04-19
 */

require_once __DIR__ . './../../src/Bootstrap.php';

use Zhaqq\Learning\ArrayFunc\ArrayFunc;

$example = [
    [
        'a' => 1,
        'b' => 2,
    ],
    [
        'a' => 3,
        'b' => 4,
    ],
    [
        'a' => 5,
        'b' => 6,
    ],
    [
        'a' => 7,
        'b' => 8,
    ],
];

$arrayMap = ArrayFunc::arrayMap(function ($item) {
    return [
        'a' => $item['a'] * $item['a'],
        'b' => $item['b'] * $item['b'],
    ];
}, $example);

var_dump($arrayMap);

$item = [
    'a' => 1,
    'b' => 2,
];

$a = 10;

extract($item);

var_dump($a);

