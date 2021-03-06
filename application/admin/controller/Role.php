<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/3/15 0015
 * Time: 20:57
 */

namespace app\admin\Controller;


use app\builder\controller\tableBuilder;
use think\Request;

class Role extends core
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->Model = model('Role');
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $builder = new tableBuilder();
        $table = array('id' => 'grid', 'url' => 'role/dataList', 'pagination' => true);
        $column1 = array('title' => '用户组ID', 'field' => 'id');
        $column2 = array('title' => '用户组名称', 'field' => 'name');
        $column4 = array('title' => '创建时间', 'field' => 'create_time');
        $column5 = array('title' => '修改时间', 'field' => 'update_time');
        $column7 = array('title' => '用户组状态', 'field' => 'status');
        $column9 = array('field' => 'operate', 'button' => $builder->addButton('edit')->addButton('delete')->getButton());
        $columns = array(
            array('column' => $column1),
            array('column' => $column2),
            array('column' => $column4),
            array('column' => $column5),
            array('column' => $column7),
            array('column' => $column9, 'type' => 'operate'),
        );

        $toolbar = array('id' => 'tool_bar_role',
            'list' => $builder->addButton('search')->addButton('create')->addButton('refresh')->getButton());
        $builder->addTable($table, $columns, $toolbar);

        $userTable = $builder->getTable();

        $this->assign('table', $userTable);
        return view('./template/index_table.tpl');
    }

    public function searchView()
    {
    }

    public function resourcesView()
    {
        $request = Request::instance();
        $type = $request->param('type');
        return view('./template/index_form.tpl');


    }

}