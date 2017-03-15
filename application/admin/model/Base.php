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
        $map = $this->search();

        $page = $request->has('page', 'post') ? $request->param('page') : 1;
        $rows = $request->has('rows', 'post') ? $request->param('rows') : 10;

        $db = $this->where($map);

        if ('User' == $request->controller() || 'Group' == $request->controller()) {
            $Utils = new groupUtil();
            $groupId = get_group_id();
            $groupIds = $Utils->getAllChildID($groupId);
            $db = $db->where('group_id', 'in', $groupIds);
        }
        $data['total'] = $db->count();
        if (0 == $data['total']) {
            $data['data'] = array();
        } else {
            if ('User' == $request->controller()) {
                $db = $db->where($map)->where('group_id', 'in', $groupIds)->page($page, $rows);
            } else {
                $db = $db->where($map)->page($page, $rows);
            }
            $data['data'] = $db->select();
        }

        $data = $this->formatDataContent($data);
        $data = $this->formatDataStructure($data);

        return $data;
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

        if ($request->isGet()) {

            $Utils = new GroupInfoUtils();
            //获取检索条件
            $id = I('get.ID');
            $data = $this->where(array('id' => $id,))->find(); //查找语句

            if ($data) {
                return returnSuccess('查询成功', $data);
            } else {
                return returnError($this->getError());
            }
        }
    }

    /**
     * 基础信息删除函数
     * 前台需传递参数  id
     */
    public function deleteData($id)
    {
    }


}