<?php
namespace app\builder\controller;

/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/3/2
 * Time: 下午2:46
 */
class index
{
    public function index()
    {

        $vi = new indexBuilder();

        return view('index',
            [
                'table' => $vi->table
            ]);


    }

    public function test(){

        $test =array(array('id'=>'value11', 'uid'=>'value12','test1'=>'1111','test2'=>'2222','test3'=>'3333','test4'=>'44444','test5'=>'55555','test6'=>'55555'),
        array('id'=>'value112', 'uid'=>'value12','test1'=>'1111','test2'=>'2222','test3'=>'3333','test4'=>'44444','test5'=>'55555','test6'=>'55555'),
        array('id'=>'value113', 'uid'=>'value12','test1'=>'1111','test2'=>'2222','test3'=>'3333','test4'=>'44444','test5'=>'55555','test6'=>'55555'),
        array('id'=>'value114', 'uid'=>'value12','test1'=>'1111','test2'=>'2222','test3'=>'3333','test4'=>'44444','test5'=>'55555','test6'=>'55555'),
        array('id'=>'value115', 'uid'=>'value12','test1'=>'1111','test2'=>'2222','test3'=>'3333','test4'=>'44444','test5'=>'55555','test6'=>'55555'),
        array('id'=>'value116', 'uid'=>'value12','test1'=>'1111','test2'=>'2222','test3'=>'3333','test4'=>'44444','test5'=>'55555','test6'=>'55555'),
         array('id'=>'value117', 'uid'=>'value12','test1'=>'1111','test2'=>'2222','test3'=>'3333','test4'=>'44444','test5'=>'55555','test6'=>'55555'));
        echo json_encode($test);







    }

}