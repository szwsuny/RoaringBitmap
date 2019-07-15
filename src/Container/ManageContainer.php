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

namespace SzwSuny\Container;


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
        case 'a':
            $this->container = $this->getArrayContainer();
            break;
        case 'b':
            $this->container = $this->getBitMapContainer();
            break;
        case 'r':
            $this->container = $this->getRunContainer();
        }

        $this->container->init(substr($values,2));
    }

    public function add($low)
    {
        $this->container->add($low);
    }

    public function find($low)
    {
        return $this->container->find($low);
    }

    public function getValues()
    {
        return $this->c_type . ' ' . $this->container->getValues();
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

