<?php
/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/2/28
 * Time: 下午5:08
 */

namespace app\admin\Controller;
use app\builder\controller\tableBuilder;
use think\Request;

class User extends core
{

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $builder = new tableBuilder();

        $table = array('id' => 'grid', 'url' => 'user/test','pagination'=>true);

        $test1 = array('title' => 'ID', 'field' => 'id');
        $test2 = array('title' => 'uid', 'field' => 'uid');
        $test3 = array('title' => 'test1', 'field' => 'test1');
        $test4 = array('title' => 'test2', 'field' => 'test2');
        $test5 = array('title' => 'test3', 'field' => 'test3');
        $test6 = array('title' => 'test4', 'field' => 'test4');
        $test7 = array('title' => 'test5', 'field' => 'test5');
        $test8 = array('title' => 'test6', 'field' => 'test6');
        $test9 = array('field'=>'operate','button'=>$builder->addButton('edit')->addButton('delete')->getButton());
        $columns = array(
            array('column' => $test1),
            array('column' => $test2),
            array('column' => $test3),
            array('column' => $test4),
            array('column' => $test5),
            array('column' => $test6),
            array('column' => $test7),
            array('column' => $test8),
            array('column' => $test9,'type'=>'operate'),
        );

        $toolbar =array(
            'id'=>'tool_bar',
            'list'=>$builder->addButton('search')->addButton('create')->addButton('refresh')->getButton()
            );

        $builder->addTable($table,$columns,$toolbar);

        $userTable = $builder->getTable();

        $this->assign('table',$userTable);

        return view('./template/index_table.tpl');
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

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create_edit()
    {
        return view('create_edit');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }


    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}