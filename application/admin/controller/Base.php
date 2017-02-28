<?php
/*
* 后台公共控制器
* Auth : li
* Time : 2017年02月24日17:22:21
* QQ : 184117183
* Email : 184117183@qq.com
*/

namespace app\admin\Controller;

use app\admin\model\Rule;
use app\admin\model\User;
use think\Controller;

class Base extends Controller
{
    /**
     * 后台用户登录
     */
    public function login()
    {
        if (is_login()) {
            return redirect(config('user_index'));
        }
        if (IS_POST) {
            $param = get_param();
            $res = (new User())->login($param);

            if(is_array($res)){
                return json_encode($res);
            }
            else{
                return $res;
            }
        } else {
            return view('login');
        }

    }

    public function index()
    {
        if (is_login()) {
            return view('index');
        } else {
            return view('login');
        }
    }

    public function get_menu()
    {
        if (is_login()) {
            $rule = new Rule();
            return $rule->getRule();
        } else {
            $this->logout();
            return redirect(config('user_login'));
        }
    }

    /* 退出登录 */
    public function logout()
    {
        return (new User())->logout();
    }


}