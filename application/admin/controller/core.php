<?php
/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/2/28
 * Time: 下午5:09
 */

namespace app\admin\Controller;

use think\Controller;

class core extends Controller
{
    public function _initialize()
    {
        if(!is_login()){
            $this->redirect(config('user_login'),302);
        }
    }


}