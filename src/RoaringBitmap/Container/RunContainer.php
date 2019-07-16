<?php
/**
*   Copyright (C) 2019 All rights reserved.
*
*   FileName      ：RunContainer.class.php
*   Author        ：sunzhiwei
*   Email         ：sunzhiwei@fh21.com
*   Date          ：2019年07月12日
*   Description   ：
*   Tool          ：vim 8.0
*/

namespace SzwSuny\RoaringBitmap\Container;

class RunContainer 
{
    private $array = [];

    public function init($values)
    {
        $this->array = explode(' ',$values);
    }

    public function add($low)
    {
        $ints = $this->getInts();
        $ints[] = $low;
        $this->array = $this->to($ints);
    }

    public function del($low)
    {
        $ints = $this->getInts();
        $left = 0;
        $right = count($ints) - 1;

        while($left <= $right)
        {
            $mid = ceil(($left + $right) / 2);
            if($low > $ints[$mid])
            {
                $left = $mid + 1;
            } else if($low < $ints[$mid])
            {
                $right = $mid - 1;
            } else 
            {
                unset($ints[$mid]);
                break;
            }
        }

        $this->array = $this->to($ints);

        return true;
    }

    public function getSize()
    {
        return count($this->getInts());
    }

    public function find($low)
    {
        return in_array($low,$this->getInts());
    }

    public function getValues()
    {
        return implode(' ',$this->array);
    }

    public function getInts()
    {
        $ints = [];

        foreach($this->array as $value)
        {
            list($start,$count) = explode(',',$value);

            $ints[] = $start;
            for($i = 0;$i<$count;$i++)
            {
                $ints[] = $start + $i + 1;
            }
        }

        return $ints;
    }

    public function to($ints)
    {
        sort($ints);

        $values = [];
        $start = null;
        $count = 0;
        foreach($ints as $int)
        {
            if($start == null)
            {
                $start = $int;
                $count = 0;
                continue;
            }

            if(($start + $count + 1) == $int)
            {
                $count++;
            } else 
            {
                $values[] = $start . ',' . $count;
                $start = $int;
                $count = 0;
            }
        }

        $values[] = $start . ',' . $count;

        return $values;
    }
}
