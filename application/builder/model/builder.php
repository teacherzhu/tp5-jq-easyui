<?php
namespace app\builder\model;

/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/3/2
 * Time: 上午9:52
 */
class builder
{
    protected $button = array();

    protected $input = array();

    public function addInput($type = 'text', $attribute = array())
    {
        $default_class = 'easyui-textbox';
        $default_width = '180px';
        $default_height = '30px';
        $default_input = array('name' => '');
        $temp = array();
        if ($default_input && !empty($attribute)) {
            $default_input = array_merge($default_input, $attribute);
            if (isset($attribute['class'])) {
                $default_class = $attribute['class'];
            }
            if (isset($attribute['width'])) {
                $default_width = $attribute['width'];
            }
            if (isset($attribute['height'])) {
                $default_height = $attribute['height'];
            }
            unset($default_input['class']);
            unset($default_input['width']);
            unset($default_input['height']);
        }
        $temp['class'] = $default_class;
        $temp['width'] = $default_width;
        $temp['height'] = $default_height;
        switch ($type) {
            case 'text': // 文本框
//                <input class="easyui-textbox" style="width:100%;height:32px">
        }

    }

    /**
     * @param string $type
     * @param array $attribute
     * @return $this
     */
    public function addButton($type = 'self', $attribute = array())
    {
        $default_class = 'easyui-linkbutton';
        $default_href = '#';
        $default_click = "";
        $default_button = array(
            'text' => '',
            'iconCls' => '',
            'plain' => 'false',
            'iconAlign' => 'left',
            'disabled' => false
        );
        $temp = array();

        /**
         * 如果定义了属性数组则与默认的进行合并
         * 用户定义的同名数组元素会覆盖默认的值
         * 把'新增'踢走自己霸占title这个位置，其它的属性同样道理
         */
        if ($default_button && !empty($attribute)) {
            $default_button = array_merge($default_button, $attribute);
            if (isset($attribute['class'])) {
                $default_class = $attribute['class'];
            }
            if (isset($attribute['href'])) {
                $default_href = $attribute['href'];
            }
            if (isset($attribute['click'])) {
                $default_click = $attribute['click'];
            }
            unset($default_button['click']);
        }

        // 这个按钮定义好了把它丢进按钮池里
        $temp['href'] = $default_href;
        $temp['class'] = $default_class;
        $temp['click'] = $default_click;

        switch ($type) {
            case 'create': // 添加新增按钮
                $default_button['text'] = '新增';
                $default_button['iconCls'] = 'icon-add';
                $temp['click'] = "window.app.gridCreate()";
                break;
            case 'edit': // 添加编辑按钮
                $default_button['text'] = '编辑';
                $default_button['iconCls'] = 'icon-edit';
                $temp['click'] = "window.app.gridEdit(\\''+row.id+'\\')";
                break;
            case 'delete': // 添加删除按钮
                $default_button['text'] = '删除';
                $default_button['iconCls'] = 'icon-clear';
                $temp['click'] = "window.app.gridRemove(\\''+row.id+'\\')";
                break;
            case 'search': // 添加查询按钮
                $default_button['text'] = '搜索';
                $default_button['iconCls'] = 'icon-search';
                $temp['click'] = "window.app.gridSearch()";
                break;
            case 'refresh': // 添加查询按钮
                $default_button['text'] = '刷新';
                $default_button['iconCls'] = 'icon-reload';
                $temp['click'] = "window.app.gridReload()";
                break;
            default:
                break;
        }
        $temp['options'] = $this->setOptions($default_button);
        array_push($this->button, $temp);
        return $this;
    }

    public function getButton()
    {
        $res = $this->button;
        $this->button = array();
        return $res;
    }

    public function setOptions($options)
    {
        $str_options = '';
        if (is_array($options)) {
            foreach ($options as $k => $option) {

                if (is_bool($option)) {
                    if ($option) {
                        $str_options .= $k . ":true,";
                    } else {
                        $str_options .= $k . ":false,";
                    }
                } else if ('formatter' == $k) {
                    $str_options .= $k . ":" . $option . ",";
                } else {
                    $str_options .= $k . ":'" . $option . "',";
                }
            }
        }
        $str_options = substr($str_options, 0, strlen($str_options) - 1);
        return $str_options;
    }
}