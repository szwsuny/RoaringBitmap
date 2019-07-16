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

// for($i = 60000;$i<100000;$i++)
// {
    // echo $i . "\r";
    // $roar->add($i);
// }
//

$roar->add(1);
$roar->add(1000);
$roar->add(200000);
$roar->add(20000000);
$roar->add(20000000);
$roar->add(20000001);
$roar->add(20000004);
$roar->add(20000005);

// $roar->set(array (
  // 'key' =>
  // array (
    // 0 => 0,
    // 1 => 106,
    // 2 => 12207,
  // ),
  // 'container' =>
  // array (
    // 0 => 'a 0 4 64 60000',
    // 1 => 'a 53184',
    // 2 => 'a 2048',
  // ),
  // 'size' => 6,
// ));

$roar->runOptimize();


var_export($roar->get());
