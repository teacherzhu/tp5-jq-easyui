<?php
/**
 * Created by PhpStorm.
 * User: txkj
 * Date: 17/3/3
 * Time: 下午2:11
 */

namespace app\builder\controller;


class tableBuilder extends builder
{
    private $tableID = '';
    private $toolID = '';
    private $table = array(
        'id' => '',
        'class' => 'easyui-datagrid',
        'tool_bar' => array(
            'id' => '',
            'list' => array()
        ),
        'columns' => array(),
        'options' => array(),
    );

    /**
     * @param array $table
     * @param string $type
     * @param array $columns array('columns'=>array(),type='self')
     * @param array $tool_bar
     */
    public function addTable($table, $columns = array(), $tool_bar = array(), $type = 'self')
    {

        $default_table = array(
            'url' => '',
            'toolbar' => '',
            'method' => 'post',
            'border' => false,
            'singleSelect' => true,
            'pagination' => false,
            'rownumbers' => true,
            'fit' => true,
            'fitColumns' => true,
            'autoRowHeight' => false,
            'emptyMsg' => '表格结果为空'

        );
        if ($default_table && is_array($table)) {
            $default_table = array_merge($default_table, $table);
            if (isset($default_table['id'])) {
                unset($default_table['id']);
            }
        }
        $this->table['id'] = $table['id'];
        $this->tableID = $table['id'];
        if (!empty($tool_bar)) {
            $this->toolID = $tool_bar['id'];
            $default_table['toolbar'] = "#" . $this->toolID;
            $this->table['tool_bar']['list'] = $tool_bar['list'];
        }


        $this->table['options'] = $this->setOptions($default_table);

        if (!empty($columns)) {
            foreach ($columns as $column) {
                if (isset($column['type'])) {
                    $this->addTableColumn($column['column'], $column['type']);
                } else {
                    $this->addTableColumn($column['column']);
                }

            }
        }

    }

    public function getTable()
    {
        $res = $this->table;
        $this->table = array();
        return $res;
    }

    /**
     * @param string $type
     * @param array $column
     * @return $this
     */
    protected function addTableColumn($column, $type = 'self')
    {
        $default_column = array(
            'title' => '',
            'field' => '',
            'width' => '100',
            'align' => 'center',
            'halign' => 'center',
            'sortable' => false,
            'order' => 'desc',
            'resizable' => false,
            'hidden' => false,
            'checkbox' => false
        );
        if ($default_column && is_array($column)) {
            $default_column = array_merge($default_column, $column);

            if (isset($column['button'])) {
                unset($default_column['button']);
            }
        }
        switch ($type) {
            case 'checkbox': // 添加新增按钮
                $default_column['checkbox'] = true;
                break;
            case 'operate': // 添加新增按钮
                $default_column['title'] = '操作';
                unset($default_column['style']);
                unset($default_column['checkbox']);
                unset($default_column['resizable']);
                unset($default_column['order']);
                unset($default_column['sortable']);
                unset($default_column['halign']);
                unset($default_column['hidden']);
                $default_column['width'] = '' . count($column['button']) * 100;
                $html = '';
                $default_column['formatter'] = 'function(value,row,index){';
                foreach ($column['button'] as $k => $button) {
                    $options = preg_replace('/\'/', "", $button['options']);
                    $options = str2arr($options);
                    $options = substr($options[0], 5);
                    $html .= "<a href=" . $button['href'] . " grid=".$this->tableID." gridType=table class=" . $button['class'] . " onclick=" . $button['click'] . ">" . $options . "</a>&nbsp&nbsp";
                }
                $default_column['formatter'] .= "return '<div class=\'operate\'>" . $html . "</div>';}";
                break;
            default:
                break;
        }

        $temp['options'] = $this->setOptions($default_column);
        array_push($this->table['columns'], $temp);
        return $this;
    }

}