<?php
namespace app\builder\controller;

/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/3/2
 * Time: 上午9:52
 */
class builder
{
    protected $extra_css = '';
    protected $extra_js = '';
    protected $_template; // 模板路径
    protected $button = array();
    protected $treeColumn = array();

    /**
     * @param string $type
     * @param array $attribute
     * @return $this
     */
    protected function addButton($type = 'self', $attribute = array())
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
                $temp['click'] = '';
                break;
            case 'edit': // 添加编辑按钮
                $default_button['text'] = '编辑';
                $default_button['iconCls'] = 'icon-edit';
                $temp['click'] = "edit_fuc(\\''+row.id+'\\')";
                break;
            case 'delete': // 添加删除按钮
                $default_button['text'] = '删除';
                $default_button['iconCls'] = 'icon-clear';
                $temp['click'] = '';
                break;
            case 'search': // 添加查询按钮
                $default_button['text'] = '搜索';
                $default_button['iconCls'] = 'icon-search';
                $temp['click'] = '';
                break;
            case 'refresh': // 添加查询按钮
                $default_button['text'] = '刷新';
                $default_button['iconCls'] = 'icon-reload';
                $temp['click'] = '';
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
                if ('formatter' == $k) {
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