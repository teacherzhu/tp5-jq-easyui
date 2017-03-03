<?php
namespace app\builder\controller;
/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/3/2
 * Time: 上午10:02
 */
class indexBuilder
{


    public $builder;

    public $table;

    public function __construct()
    {
        $this->builder = new tableBuilder();
        $this->setTable();
    }


    /**
     * 设置下方table
     */
    private function setTable()
    {

        $test1 = array('title' => 'ID','field'=>'id');
        $test2 = array('title' => 'uid','field'=>'uid','width'=>'120');
        $test3 = array('title' => 'test1','field'=>'test1','width'=>'120');
        $test4 = array('title' => 'test2','field'=>'test2','width'=>'120');
        $test5 = array('title' => 'test3','field'=>'test3','width'=>'120');
        $test6 = array('title' => 'test4','field'=>'test4','width'=>'120');
        $test7 = array('title' => 'test5','field'=>'test5','width'=>'120');
        $test8 = array('title' => 'test6','field'=>'test6','width'=>'120');

        $table = array('id' => 'grid', 'url' => 'test');

        $columns = array(
            array('type'=>'checkbox', 'column'=>$test1),
            array('type'=>'', 'column'=>$test2),
            array('type'=>'', 'column'=>$test3),
            array('type'=>'', 'column'=>$test4),
            array('type'=>'', 'column'=>$test5),
            array('type'=>'', 'column'=>$test6),
            array('type'=>'', 'column'=>$test7),
            array('type'=>'', 'column'=>$test8),
        );
        $this->builder->addTable($table,$columns);

        $this->table = $this->builder->getTable();
//        dump('');
    }


}