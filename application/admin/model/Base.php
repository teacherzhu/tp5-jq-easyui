<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/3/9 0009
 * Time: 19:31
 */

namespace app\admin\model;


use app\admin\utils\groupUtil;
use think\Model;

class Base extends Model
{

    /**
     *
     * 默认检索条件
     * @return array
     */

    protected function search()
    {
        return array();
    }

    /**
     * 格式化indexData函数返回数据的结构
     * @param $data
     * @return mixed
     */
    protected function formatDataStructure($data)
    {
        return $data;
    }


    /**
     *
     * 格式化indexData函数返回数据的内容
     *
     * @param $data
     * @return mixed
     */
    protected function formatDataContent($data)
    {
        return $data;
    }


    /**
     * 基础信息默认查询方式
     * @param array $request
     * @return array|mixed
     */
    public function getDataList($request)
    {
        $Utils = new groupUtil();
        dump($request->param());
    }

    public function createData($request)
    {

    }

    /**
     * post请求为修改数据库get请求为查询数据库数据
     * 根据提供的group_id ,id 修改数据
     * 修改数据(根据不同界面业务逻辑需覆盖父函数)
     */
    public function editData($request)
    {
    }

    /**
     * 基础信息删除函数
     * 前台需传递参数  id
     */
    public function deleteData($id)
    {
    }


}