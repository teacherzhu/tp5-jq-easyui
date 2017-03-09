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


}