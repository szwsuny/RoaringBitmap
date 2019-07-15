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
            sort($this->array);
        }
    }

    public function del($low)
    {
        $left = 0;
        $right = count($this->array) - 1;

        while($left <= $right)
        {
            $mid = ceil(($left + $right) / 2);
            if($low > $this->array[$mid])
            {
                $left = $mid + 1;
            } else if($low < $this->array[$mid])
            {
                $right = $mid - 1;
            } else 
            {
                unset($this->array[$mid]);
                break;
            }
        }

        return true;
    }

    public function getSize()
    {
        return count($this->array);
    }

    public function find($low)
    {
        return in_array($low,$this->array);
    }

    public function getValues()
    {
        return implode(' ',$this->array);
    }

    public function getInts()
    {
        return $this->array;
    }
}
