var App = function () {
    var debug = true;
    var initFunction = function () {
        $('#menu').tree({
            url: '/admin/base/get_menu',
            onLoadError: function (data) {
                console.log(data);
            }
        });
    };
    var errorFunction = function (data) {
        try {
            var dataJSON = JSON.parse(data);

            $.messager.alert('错 误', dataJSON.Msg, 'error');

        } catch (e) {
            $.messager.alert('错 误', '数据格式错误！', 'error');
        }
    };
    return {
        init: initFunction,
        error: errorFunction,
        SLog: function () {
            if (debug) {
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
         * @param uniqueId 唯一键
         * @param singleSelect 是否为单选
         * @param pagination   是否进行分页
         */
        initDataGridTable: function (object) {
            var toolbar = object.toolbar ? object.toolbar : '';
            var method = object.method ? object.method : 'post';
            var height = object.height ? object.height : 750;
            var uniqueId = object.uniqueId ? object.uniqueId : 'id';
            var singleSelect = object.singleSelect ? false : true;
            var pagination = object.pagination ? false : true;
            $("#contentTable").bootstrapTable({
                url: object.url,         //请求后台的URL（*）
                columns: object.columns,
                method: method,                      //请求方式（*）
                toolbar: toolbar,                //工具按钮用哪个容器
                height: height,
                singleSelect: singleSelect,                  //单选选项
                uniqueId: uniqueId,                     //每一行的唯一标识，一般为主键列
                pagination: pagination,                   //是否显示分页（*）
                pageNumber: 1,                       //初始化加载第一页，默认第一页
                pageSize: 20,                       //每页的记录行数（*）
                pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
                cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
                sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
                showRefresh: true,                  //是否显示刷新按钮
                minimumCountColumns: 2,             //最少允许的列数
                clickToSelect: true                //是否启用点击选中行

            });
        },

        menuClick: function (node) {
            if ($('#LeftMenu').tree('isLeaf', node.target)) {//判断是否是叶子节点
                rule = node.attributes.rule;
                var strs = new Array();
                strs = rule.split("/"); //字符分割
                var cname = strs[1];
                var tit = node.text;
                var url = node.attributes.url;
                var icon = node.iconCls;
                if (url) {
                    updateTabs(cname, url, tit, icon);
                }
            }
        },

        updateTabs: function (model_name, url, title, icon) {
            if ($('#tabs_' + model_name).length > 0) {
                index = $('#MainTabs').tabs('getTabIndex', $('#tabs_' + model_name));
                $('#MainTabs').tabs('select', index);
                Selected_tabs = $('#MainTabs').tabs('getSelected');
                options_s = {};
                options_s.href = url;
                options_s.bodyCls = "tabs_box";
                options_s.title = title;
                options_s.iconCls = icon;

                $('#MainTabs').tabs('update', {
                    tab: Selected_tabs,
                    options: options_s
                });
                Selected_tabs.panel('refresh');
            } else {
                options_s = {};
                options_s.id = 'tabs_' + model_name;
                options_s.title = tit;
                options_s.href = url;
                options_s.closable = true;
                options_s.bodyCls = "tabs_box";
                if (icon != null) {
                    options_s.iconCls = icon
                } else {
                    options_s.iconCls = 'iconfont icon-viewlist'
                }
                $('#MainTabs').tabs('add', options_s);
            }
        },


        gridAjax: function (url, grid) {
            $.post(url, {}, function (res) {
                if (!res.status) {
                    $.messager.show({title: '错误提示', msg: res.info, timeout: 2000, showType: 'slide'});
                } else {
                    $('#' + Datagrid).datagrid('reload');
                    $.messager.show({title: '成功提示', msg: res.info, timeout: 1000, showType: 'slide'});
                }
            })
        },

        checkboxGridAjax: function (url, grid) {
            var rows = $('#' + Datagrid).datagrid('getSelections');
            if (rows.length == 0) {
                $.messager.show({title: '错误提示', msg: '至少选择一行记录！', timeout: 2000, showType: 'slide'});
            } else {
                var id_arr = [];
                for (var i = 0; i < rows.length; i++) {
                    id_arr.push(rows[i].id);
                }
                ids = id_arr.join(',');
                $.post(url, {ids: ids}, function (res) {
                    if (!res.status) {
                        $.messager.show({title: '错误提示', msg: res.info, timeout: 2000, showType: 'slide'});
                    } else {
                        $('#' + Datagrid).datagrid('reload');
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
                    updateTabs(Model_name, res.url + '&cachedata=' + new Date().getTime(), '', 'iconfont icon-viewlist');
                }
            })
        },

        gridRemove: function (Data_from_url, Datagrid_data, type) {
            $.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
                if (flag) {
                    $.post(Data_from_url, {}, function (res) {
                        if (!res.status) {
                            $.messager.show({title: '错误提示', msg: res.info, timeout: 2000, showType: 'slide'});
                        } else {
                            if ('tree' == type) {
                                $('#' + Datagrid_data).treegrid('reload');
                            }
                            else {
                                $('#' + Datagrid_data).datagrid('reload');
                            }
                            $.messager.show({title: '成功提示', msg: res.info, timeout: 1000, showType: 'slide'});
                        }
                    })
                }
            })
        },
        /* 刷新页面 */
        gridReload: function (Data_Box, type) {
            if ('tree' == type) {
                $('#' + Data_Box).treegrid('reload');
            }
            else {
                $('#' + Data_Box).datagrid('reload');
            }
        },

        /**
         * 初始化一个对话框
         */
        initDialog: function (object) {
        },

        dialogShow: function (id) {
        },
        dialogClose: function (id) {
        }
    }
}();
