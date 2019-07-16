<?php
/**
 *   Copyright (C) 2019 All rights reserved.
 *
 *   FileName      ：ManageContainer.php
 *   Author        ：sunzhiwei
 *   Email         ：sunzhiwei@fh21.com
 *   Date          ：2019年07月12日
 *   Description   ：容器管理层
 *   Tool          ：vim 8.0
 */

namespace SzwSuny\RoaringBitmap\Container;

use SzwSuny\RoaringBitmap\RoaringConfig;

class ManageContainer {

    private static $instance = NULL;
    private $runContainer,$arrayContainer,$bitmapContainer;

    private $c_type;
    private $container;
    /**
     *	构造方法
     */
    protected function __construct()
    {
    }

    /**
     *	获取单例
     */
    public static function getInstance()
    {
        if(!self::$instance instanceof ManageContainer){
            self::$instance = new ManageContainer();
        }
        return self::$instance;
    }

    public function set($values)
    {
        $this->c_type = substr($values,0,1);
        switch($this->c_type)
        {
        case RoaringConfig::__ARRAY_PREFIX__:
            $this->container = $this->getArrayContainer();
            break;
        case RoaringConfig::__BITMAP_PREFIX__:
            $this->container = $this->getBitMapContainer();
            break;
        case RoaringConfig::__RUN_PREFIX__:
            $this->container = $this->getRunContainer();
        }

        $this->container->init(substr($values,2));
    }

    public function add($low)
    {
        $this->container->add($low);
    }

    public function del($low)
    {
        $this->container->del($low);
    }

    public function getSize()
    {
        return $this->container->getSize();
    }

    public function getInts()
    {
        return $this->container->getInts();
    }

    public function find($low)
    {
        return $this->container->find($low);
    }

    public function getValues()
    {
        return $this->c_type . ' ' . $this->container->getValues();
    }

    public function runOptimize()
    {
        $ints = $this->getInts();

        $array = $ints;
        $bitmap = $this->getBitMapContainer()->to($ints);
        $run = $this->getRunContainer()->to($ints);

        $array_length = count($array);
        $bitmap_length = count($bitmap);
        $run_length = count($run) * 2;

        $lengths = [$array_length,$bitmap_length,$run_length];

        $minValue = null;
        $index = 0;
        foreach($lengths as $key=>$length)
        {
            if($minValue == null)
            {
                $minValue = $length;
                $index = $key;
                continue;
            }

            if($length < $minValue)
            {
                $minValue = $length;
                $index = $key;
            }
        }

        $prefix = [RoaringConfig::__ARRAY_PREFIX__,RoaringConfig::__BITMAP_PREFIX__,RoaringConfig::__RUN_PREFIX__][$index];
        $values = [$array,$bitmap,$run][$index];
        $this->set($prefix . ' ' . implode(' ',$values));
    }

    private function getRunContainer()
    {
        if($this->runContainer == null)
        {
            $this->runContainer = new RunContainer();
        }

        return $this->runContainer;
    }

    private function getArrayContainer()
    {
        if($this->arrayContainer == null)
        {
            $this->arrayContainer = new ArrayContainer();
        }

        return $this->arrayContainer;
    }

    private function getBitMapContainer()
    {
        if($this->bitmapContainer == null)
        {
            $this->bitmapContainer = new BitMapContainer();
        }

        return $this->bitmapContainer;
    }

}

