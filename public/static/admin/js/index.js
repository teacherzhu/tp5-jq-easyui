(function ($, window) {
    var app = {
        debug: true,
        init: function () {
            window.app.SLog('------------------init    start-----------------------');
            $('#menu').tree({
                onClick: function (node) {
                    // window.app.SLog(node.target,$('#menu').tree('isLeaf', node.target));
                    if ($('#menu').tree('isLeaf', node.target)) {//判断是否是叶子节点
                        var rule = node.attributes.rule;
                        var str = rule.split("/"); //字符分割
                        var title = node.text;
                        var url = node.attributes.url;
                        var icon = node.iconCls;

                        var options_s = {};
                        if ($('#tabs_' + str[1]).length > 0) {

                            var index = $('#mainTabs').tabs('getTabIndex', $('#tabs_' + str[1]));

                            $('#mainTabs').tabs('select', index);
                            var selectedTabs = $('#mainTabs').tabs('getSelected');
                            options_s.href = url;
                            options_s.title = title;
                            options_s.iconCls = icon;

                            $('#mainTabs').tabs('update', {
                                tab: selectedTabs,
                                options: options_s
                            });
                            selectedTabs.panel('refresh');
                        } else {
                            options_s.id = 'tabs_' + str[1];
                            options_s.title = title;
                            options_s.href = url;
                            options_s.closable = true;
                            if (icon != null) {
                                options_s.iconCls = icon
                            } else {
                                options_s.iconCls = ''
                            }
                            $('#mainTabs').tabs('add', options_s);
                        }

                    }
                },
                onLoadError: function (data) {
                    window.app.error(data);
                }
            });
            window.app.SLog('------------------init    end-----------------------');
        },
        success: function (data) {
            try {

                var dataJSON = JSON.parse(data);

                $.messager.show({title: '成功', msg: dataJSON.Msg, timeout: 2000, showType: 'slide'});

            } catch (e) {
                $.messager.alert('错 误', '数据格式错误！', 'error');
            }
        },
        error: function (data) {
            try {
                var dataJSON = JSON.parse(data);

                $.messager.alert('错 误', dataJSON.Msg, 'error');

            } catch (e) {
                $.messager.alert('错 误', '数据格式错误！', 'error');
            }
        },
        SLog: function () {
            if (this.debug) {
                $.each(arguments, function (index, val) {
                    console.log('debug------------>', val);
                });
            }
        },
        /**
         * 初始化一个datagrid
         * @param url   远程加载数据地址
         * @param columns 表格列名称
         * @param toolbar 表格上方工具条ID
         * @param method  远程数据加载方式‘post & get’
         * @param height  表格高度
         * @param singleSelect 是否为单选
         * @param pagination   是否进行分页
         */
        initDataGridTable: function (object) {
            var toolbar = object.toolbar ? object.toolbar : '';
            var method = object.method ? object.method : 'post';
            var height = object.height ? object.height : 750;
            var singleSelect = object.singleSelect ? false : true;
            var pagination = object.pagination ? false : true;
            $(object.grid).datagrid({
                url: object.url,         //请求后台的URL（*）
                columns: object.columns,
                method: method,                      //请求方式（*）
                toolbar: toolbar,                //工具按钮用哪个容器
                height: height,
                singleSelect: singleSelect,                  //单选选项
                fit: true,
                fitColumns: true,
                striped: true,
                border: false,
                pagination: pagination,
                pageSize: 20,
                pageList: [10, 20, 50],
                pageNumber: 1,
                sortName: 'id',
                sortOrder: 'desc'
            });
        },

        // menuClick: function (node) {
        //     if ($('#LeftMenu').tree('isLeaf', node.target)) {//判断是否是叶子节点
        //         rule = node.attributes.rule;

        //         if (url) {
        //             updateTabs(cname, url, tit, icon);
        //         }
        //     }
        // },


        gridAjax: function (url, grid) {
            $.post(url, {}, function (res) {
                if (!res.status) {
                    $.messager.show({title: '错误提示', msg: res.info, timeout: 2000, showType: 'slide'});
                } else {
                    $('#' + grid).datagrid('reload');
                    $.messager.show({title: '成功提示', msg: res.info, timeout: 1000, showType: 'slide'});
                }
            })
        },

        checkboxGridAjax: function (url, grid) {
            var rows = $('#' + grid).datagrid('getSelections');
            if (rows.length == 0) {
                $.messager.show({title: '错误提示', msg: '至少选择一行记录！', timeout: 2000, showType: 'slide'});
            } else {
                var id_arr = [];
                for (var i = 0; i < rows.length; i++) {
                    id_arr.push(rows[i].id);
                }
                var ids = id_arr.join(',');
                $.post(url, {ids: ids}, function (res) {
                    if (!res.status) {
                        $.messager.show({title: '错误提示', msg: res.info, timeout: 2000, showType: 'slide'});
                    } else {
                        $('#' + grid).datagrid('reload');
                        $.messager.show({title: '成功提示', msg: res.info, timeout: 1000, showType: 'slide'});
                    }
                })

            }
        },

        //搜索
        doSearch: function (search_from, grid) {
            $('#' + search_from).dialog({
                width: 600,
                height: 350,
                title: '搜索',
                modal: true,
                buttons: [{
                    text: '搜索',
                    iconCls: 'icon-search',
                    handler: function () {
                        var queryParams = $('#' + grid).datagrid('options').queryParams;
                        $.each($('#' + search_from).serializeArray(), function () {
                            queryParams[this['name']] = this['value'];
                        });
                        $('#' + grid).datagrid('reload');
                    }
                }]
            })
        },

        /* 提交表单 */
        fromSubmit: function (Model_name) {
            $.post($('#' + Model_name + '_Submit_From').attr("action"), $('#' + Model_name + '_Submit_From').serialize(), function (res) {
                if (!res.status) {
                    $.messager.show({title: '错误提示', msg: res.info, timeout: 2000, showType: 'slide'});
                } else {
                    $.messager.show({title: '成功提示', msg: res.info, timeout: 1000, showType: 'slide'});
                }
            })
        },
        getAttributes: function (event) {
            var info = {};
            if (event) {

                info.controller = event.target.attributes.controller.value;
                info.gridID = event.target.attributes.grid.value;
                info.gridType = event.target.attributes.gridType.value;
                return info;
            }
            else {
                window.app.error();
            }
        },
        gridEdit: function (id) {
            if (id) {


            }
            else {
                $.messager.alert('错 误', '参数错误！', 'error');
            }
        },

        gridRemove: function (id) {
            var info = window.app.getAttributes(event);
            $.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
                if (flag) {
                    if (info) {
                        $.post(info.controller + '/delete', {'id': id}, function (res) {
                            if (200 == res.code) {
                                window.app.Reload(info.gridID, info.gridType);
                                window.app.success(res);
                            } else {
                                window.app.error(res);
                            }
                        });
                    }
                    else {
                        window.app.error();
                    }
                }
            })
        },
        /* 刷新页面 */
        gridReload: function () {
            window.app.SLog(event);
            var info = window.app.getAttributes(event);
        },
        /* 刷新页面 */
        Reload: function (Data_Box, type) {
            if ('tree' == type) {
                $('#' + Data_Box).treegrid('reload');
            }
            else {
                $('#' + Data_Box).datagrid('reload');
            }
        }
    };
    return window.app = window.app || app;
})($, window);
