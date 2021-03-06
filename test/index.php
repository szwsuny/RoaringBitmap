<?php
/**
*   Copyright (C) 2019 All rights reserved.
*
*   FileName      ：index.php
*   Author        ：sunzhiwei
*   Email         ：sunzhiwei@fh21.com
*   Date          ：2019年07月12日
*   Description   ：
*   Tool          ：vim 8.0
*/

require __DIR__ . '/../vendor/autoload.php';

use SzwSuny\RoaringBitmap\Container\BitMapContainer;

use SzwSuny\RoaringBitmap\Container\RunContainer;

use SzwSuny\RoaringBitmap\RoaringBitMap;

$roar = new RoaringBitMap();

// for($i = 65530;$i< 131060;$i = $i + 2)
// {
    // echo $i . "\r";
    // $roar->add($i);
// }


$roar->set(array (
  'key' =>
  array (
    0 => 0,
    1 => 106,
    2 => 12207,
  ),
  'container' =>
  array (
    0 => 'b 31 4 64 60000',
    1 => 'a 53184 11223',
    2 => 'a 2048',
  ),
  'size' => 6,
));

$roar2 = new RoaringBitMap();
$roar2->set(array(
  'key' =>
  array (
    0 => 0,
    1 => 106,
    2 => 12207,
  ),
  'container' =>
  array (
    0 => 'a 0 4 64 60000',
    1 => 'a 53184 11223',
    2 => 'a 2048',
  ),
  'size' => 6,
));

$roar3 = $roar->and($roar2);

var_dump($roar3->get());

