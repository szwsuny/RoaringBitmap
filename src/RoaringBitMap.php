<?php
/**
 *   Copyright (C) 2019 All rights reserved.
 *
 *   FileName      ：RoaringBitMap.class.php
 *   Author        ：sunzhiwei
 *   Email         ：sunzhiwei@fh21.com
 *   Date          ：2019年07月12日
 *   Description   ：php本身不能实现正常意义上，所以只是实现逻辑
 *   Tool          ：vim 8.0
 */

namespace SzwSuny;

use SzwSuny\Container\ManageContainer;

class RoaringBitMap 
{
    private $keys = []; //最大 65535 作为high 位 为了符合原内容 所以没有使用hash方式
    private $containers = []; // 存储容器  a = array b = bitmap r = run 这里不存对象所以多存了一个字母 用来表示启用的容器
    private $size = 0; //存储的基数数量


    public function __construct()
    {

    }


    /**
     * @brief 存入一个数字
     *
     * @param $int
     *
     * @return 
     */
    public function add($int)
    {
        list($high,$low) = $this->getHighLow($int);

        list($index,$insertIndex) = $this->findIndex($high); //寻找位置

        if($index == -1) //容器不存在 则创建一个容器
        {
            if(!isset($this->keys[$insertIndex]) || $this->keys[$insertIndex] < $high)
            {
                $insertIndex++;
            }


            array_splice($this->keys,$insertIndex,0,$high);
            array_splice($this->containers,$insertIndex,0,'a '.$low); //默认启用 数组容器 数组容器的结构用空格分隔 第一位是类型 后面是保存的数组 低位
            // array_splice($this->containers,$insertIndex,0,'b 0'); 
            $this->size++;
        } else 
        {
            $container = $this->containers[$index];
            $manageContainer = ManageContainer::getInstance(); //容器管理
            $manageContainer->set($container); //设置内容

            if(!$manageContainer->find($low)) //如果没找到就进行添加
            {
                $manageContainer->add($low);
                $this->containers[$index] = $manageContainer->getValues();
                $this->size++;
            }
        }
    }

    /**
     * @brief 删除某个数
     *
     * @param $int
     *
     * @return 
     */
    public function del($int)
    {
        list($high,$low) = $this->getHighLow($int);
        list($index,$insertIndex) = $this->findIndex($high);

        if($index == -1)
        {
            return true; //容器不存在 就当处理成功
        }

        $container = $this->containers[$index];
        $manageContainer = ManageContainer::getInstance();
        $manageContainer->set($container);

        if(!$manageContainer->find($low))
        {
            return true; //容器中也没找到
        }

        $manageContainer->del($low);

        if($manageContainer->getSize() < 1) //容器没有东西了
        {
            unset($this->keys[$index]);
            unset($this->containers[$index]);
            $this->keys = array_values($this->keys);
            $this->containers = array_values($this->containers);
        } else 
        {
            $this->containers[$index] = $manageContainer->getValues();
        }

        $this->size--;
    }


    /**
     * @brief 得到结果
     *
     * @return 
     */
    public function getValues()
    {
        return ['key'=>$this->keys,'container'=>$this->containers,'size'=>$this->size];
    }

    /**
     * @brief 寻找key 所在的位置序号 反馈数组 0 位 如果存在则返回正常序号 否则返回 -1  1位 反馈最后查找的序号用来插入新key使用
     *
     * @param $high
     *
     * @return 
     */
    private function findIndex($high)
    {
        $count = count($this->keys);

        if($count == 0)
        {
            return [-1,-1];
        }

        $ret = -1;
        $mid = 0;
        $left = 0;
        $right = $count - 1;

        while($left <= $right)
        {
            $mid = ceil(($left + $right) / 2);
            if($high > $this->keys[$mid])
            {
                $left = $mid + 1;
            } else if($high < $this->keys[$mid])
            {
                $right = $mid - 1;
            } else 
            {
                $ret = $mid;
                break;
            }
        }

        return [$ret,$mid];
    }

    /**
     * @brief 切分成 高低位
     *
     * @param $int
     *
     * @return 
     */
    private function getHighLow($int)
    {
        $high = $int >> 16;
        $low = ($high << 16) ^ $int;

        return [$high,$low];
    }
}
