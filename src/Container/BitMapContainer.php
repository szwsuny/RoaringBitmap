<?php
/**
 *   Copyright (C) 2019 All rights reserved.
 *
 *   FileName      ：BitMapContainer.class.php
 *   Author        ：sunzhiwei
 *   Email         ：sunzhiwei@fh21.com
 *   Date          ：2019年07月12日
 *   Description   ：64位数字存储 php 没法做更好的二进制位运算 只能存成数字 这样就需要 1024 个数字 来存 65535 个数字
 *   Tool          ：vim 8.0
 */

namespace SzwSuny\Container;

class BitMapContainer 
{
    private $array = [];

    private $_INT_MAX_LENGTH_ = 64;

    public function init($values)
    {
        $this->array = explode(' ',$values);
    }

    public function add($low)
    {
        list($index,$sp) = $this->findIndex($low); //数组都是0开始数

        if(!isset($this->array[$index])) //如果不存在就区补位
        {
            $diff = $index - count($this->array);
            $this->array = array_pad($this->array,$diff + 1,0);
        }

        $num = 1 << $sp;
        $this->array[$index] = $this->array[$index] | $num;
    }

    public function del($low)
    {
        list($index,$sp) = $this->findIndex($low);

        if(isset($this->array[$index]))
        {
            $num = 1 << $sp;
            $this->array[$index] = $this->array[$index] - $num;
            $this->delLastZore();
        }
    }

    public function getSize()
    {
        return count($this->getInts());
    }

    public function find($low)
    {
        list($index,$sp) = $this->findIndex($low);

        if(isset($this->array[$index]))
        {
            $value = $this->array[$index];

            $num = 1 << $sp;
            $newNum = $value & $num;

            return $newNum == $num;


        }

        return false;
    }

    public function getValues()
    {
        return implode(' ',$this->array);
    }

    private function delLastZore()
    {
        $count = count($this->array);
        for($i = $count - 1;$i >= 0; $i--)
        {
            if($this->array[$i] != 0)
            {
                break;
            }

            if($this->array[$i] == 0)
            {
                unset($this->array[$i]);
            }
        }
    }

    /**
     * @brief 获得这个数字 / 64 后应该放在的位置
     *
     * @param $low
     *
     * @return 
     */
    private function findIndex($low)
    {
        return [
            intval($low / $this->_INT_MAX_LENGTH_),
            $low % $this->_INT_MAX_LENGTH_
        ];
    }

    public function getInts()
    {
        $ints = [];
        foreach($this->array as $key=>$bit)
        {
            if($bit == 0)
            {
                continue;
            }

            $lastNum = $key * $this->_INT_MAX_LENGTH_;
            for($i = 0;$i < $this->_INT_MAX_LENGTH_;$i++)
            {
                $num = 1 << $i;
                if($num == ($bit & $num))
                {
                    $ints[] = $lastNum + $i;
                }
            }
        }

        return $ints;
    }
}
