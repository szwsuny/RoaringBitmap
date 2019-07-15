<?php
/**
*   Copyright (C) 2019 All rights reserved.
*
*   FileName      ：ArrayContainer.class.php
*   Author        ：sunzhiwei
*   Email         ：sunzhiwei@fh21.com
*   Date          ：2019年07月12日
*   Description   ：
*   Tool          ：vim 8.0
*/

namespace SzwSuny\Container;

class ArrayContainer 
{
    private $array = [];

    public function init($values)
    {
        $this->array = explode(' ',$values);
    }

    public function add($low)
    {
        if(!$this->find($low))
        {
            $this->array[] = $low;
        }
    }

    public function getValues()
    {
        sort($this->array);
        return implode(' ',$this->array);
    }

    public function find($low)
    {
        return in_array($low,$this->array);
    }
}
