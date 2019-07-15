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

use SzwSuny\RoaringBitMap;

$roar = new RoaringBitMap();
$roar->add(10000120);
$roar->add(1);
$roar->add(100001);
$roar->add(12312312312);


var_dump($roar->getValues());
