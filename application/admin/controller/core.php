<?php
/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/2/28
 * Time: 下午5:09
 */

namespace app\admin\Controller;

use think\Controller;
use think\Request;

class core extends Controller
{
    protected $Model = null;

    public function _initialize()
    {
        if (!is_login()) {
            $this->redirect(config('user_login'), 302);
        }
    }



    /**
     * 获取数据
     * @param Request $request
     * @return JSON $res
     */
    public function dataList(Request $request)
    {
        $res = $this->Model->getDataList($request);
        return $res;
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function create(Request $request)
    {
        $res = $this->Model->createData($request);
        return json_encode($res);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //editData
        $res = $this->Model->editData($request);
        return json_encode($res);
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $res = $this->Model->deleteData($id);
        return json_encode($res);
    }


}