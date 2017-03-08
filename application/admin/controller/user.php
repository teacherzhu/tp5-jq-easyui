<?php
/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/2/28
 * Time: 下午5:08
 */

namespace app\admin\Controller;

use app\builder\controller\indexBuilder;
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
//        return view('index');


        $vi = new indexBuilder();

        $this->assign('table',$vi->table);

//        dump($vi->table);

        return $this->fetch('./template/index_table.tpl');
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