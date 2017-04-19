<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/3/9 0009
 * Time: 19:31
 */

namespace app\admin\model;


use app\admin\utils\groupUtil;
use think\Exception;
use think\Model;

class Base extends Model
{

    /**
     *
     * 默认检索条件
     * @return array
     */

    protected function searchMap()
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
     * @param bool $pagination
     * @param string $tableName
     * @return array|mixed
     */
    public function getDataList($request, $pagination = true, $tableName = '')
    {
        $map = $this->searchMap();
        $page = $request->has('page', 'post') ? $request->param('page') : 1;
        $rows = $request->has('rows', 'post') ? $request->param('rows') : 10;

        if ('' == $tableName) {
            $tableName = $this->table;
        }
        $data['total'] = db($tableName)->where($map)->count();
        if (0 == $data['total']) {
            $data['data'] = array();
            return $data;
        } else {
            if ($pagination) {
                $data['data'] = db($tableName)->where($map)->page($page, $rows)->select();
            } else {
                $data['data'] = db($tableName)->where($map)->select();
            }
            $data = $this->formatDataContent($data);
            $data = $this->formatDataStructure($data);
            return $data;
        }
    }

    /**
     * 校验数据是否合法
     * @param array $request
     *
     */
    protected function addCheckData($data)
    {
        $validate['flag'] = false;
        $validate['data'] = $data;
        $validate['Msg'] = '';
        return $data;
    }

    /**
     * 向数据中添加业务逻辑
     * @param array $data
     */
    protected function addBusinessLogic($data)
    {
        return $data;
    }

    /**
     * @param $request
     * @param bool $isValidate
     * @param string $tableName
     * @return array
     */
    public function createData($request, $isValidate = true, $tableName = '')
    {
        if ('' == $tableName) {
            $tableName = $this->table;
        }
        if ($isValidate) {
            $validate = $this->addCheckData($request->param());
        } else {
            $validate['flag'] = true;
        }
        if ($validate['flag']) {
            $createData = $this->addBusinessLogic($validate['data']);
            $this->startTrans();
            try {
                $res = db($tableName)->create($createData);
                if (false !== $res) {
                    $this->commit();
                    return message(200, '操作成功！', $res);
                }
            } catch (Exception $e) {
                $this->rollback();
                return message(400, $e->getMessage());
            }
        } else {
            return message(400, $validate['Msg']);
        }
    }



    /**
     * 校验数据是否合法
     * @param array $request
     *
     */
    protected function editCheckData($data)
    {
        $validate['flag'] = false;
        $validate['data'] = $data;
        $validate['Msg'] = '';
        return $data;
    }

    /**
     * 向数据中添加业务逻辑
     * @param array $data
     */
    protected function editBusinessLogic($data)
    {
        return $data;
    }

    /**
     * post请求为修改数据库get请求为查询数据库数据
     * 根据提供的group_id ,id 修改数据
     * 修改数据(根据不同界面业务逻辑需覆盖父函数)
     * @param $request
     * @param bool $isValidate
     * @param string $tableName
     * @return array
     */
    public function editData($request, $isValidate = true, $tableName = '')
    {
        if('' == $tableName){
            $tableName = $this->table;
        }
        if ($request->isGet()) {
            $param = $request->param();
            $res = db($tableName)->where('id',$param)->select();
            return $res;
        } else {
            if ($isValidate) {
                $validate = $this->editCheckData($request->param());
            } else {
                $validate['flag'] = true;
            }
            if ($validate['flag']) {
                $editData = $this->editBusinessLogic($validate['data']);
                $this->startTrans();
                try {
                    $res = db($tableName)->where('id',$editData['id'])->update($editData);
                    if (false !== $res) {
                        $this->commit();
                        return message(200, '操作成功！', $res);
                    }
                } catch (Exception $e) {
                    $this->rollback();
                    return message(400, $e->getMessage());
                }
            } else {
                return message(400, $validate['Msg']);
            }
        }
    }

    /**
     * 基础信息删除函数
     * 前台需传递参数
     * @param $request
     * @param string $tableName
     * @return array
     */
    public function deleteData($request,$tableName)
    {
    }


}