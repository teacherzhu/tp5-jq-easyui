<?php
/**
 * Created by PhpStorm.
 * User: 李
 * Date: 2017/3/23 0023
 * Time: 18:44
 */

namespace app\builder\model;


class formBuilder extends builder
{
    private $form = array(
        'id' => '',
        'method' => 'post',
        'formColumn' => array()
    );

    public function addForm($form, $columns = array())
    {
        $default_form = array(
            'method' => 'post',
        );

        if ($default_form && is_array($form)) {
            $default_form = array_merge($default_form, $form);
            if (isset($default_form['id'])) {
                unset($default_form['id']);
            }
        }
        $this->form['id'] = $form['id'];

        if (!empty($columns)) {
            foreach ($columns as $column) {
                if (isset($column['type'])) {
                    $this->addFormColumn($column['column'], $column['type']);
                } else {
                    $this->addFormColumn($column['column']);
                }
            }
        }


    }

    /**
     * @param string $type
     * @param array $column
     * @return $this
     */
    protected function addFormColumn($column, $type = 'self')
    {
        $default_column = array(
            'text' => '',
            'width' => '100',
            'class' => 'easyui-textbox',
            'hidden' => false,
            'options' => array()
        );
        if ($default_column && is_array($column)) {
            $default_column = array_merge($default_column, $column);
        }
        switch ($type){




        }

    }

}