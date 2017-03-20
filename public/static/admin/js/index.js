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

        getAttributes: function (event) {
            var info = {};
            if (event) {
                info.controller = $(event).attr('controller');
                info.gridID = $(event).attr('grid');
                return info;
            }
            else {
                window.app.error();
            }
        },
        gridCreate: function () {
            if ($(event.target).parent().parent().is('a')) {
                var info = window.app.getAttributes($(event.target).parent().parent());
                window.app.SLog(info);

                /**
                 * 调整dialog后显示
                 */
                var resourcesUrl = info.controller + '/resourcesView/type/create';
                window.app.dialogController(info.controller + '_dialog', true, resourcesUrl);


            }
        },
        gridEdit: function (id) {
            if ($(event.target).is('a')) {
                var info = window.app.getAttributes(event.target);
                if (id) {
                    window.app.SLog(info, id);
                    var resourcesUrl = info.controller + '/resourcesView/type/edit/ID/' + id;
                    window.app.dialogController(info.controller + '_dialog', true, resourcesUrl);
                }
            }
        },

        gridRemove: function (id) {
            if ($(event.target).is('a')) {
                var info = window.app.getAttributes(event.target);
                $.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
                    if (flag) {
                        if (info) {
                            $.post(info.controller + '/delete', {'id': id}, function (res) {
                                if (200 == res.code) {
                                    window.app.reload(info.gridID);
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
            }
        },
        /* 刷新页面 */
        gridReload: function () {
            if ($(event.target).parent().parent().is('a')) {
                var info = window.app.getAttributes($(event.target).parent().parent());
                window.app.reload(info.gridID);
            }
        },
        /* 刷新页面 */
        reload: function (gridID) {
            if ($('#' + gridID).hasClass('easyui-treegrid')) {
                $('#' + gridID).treegrid('reload');
            }
            else {
                $('#' + gridID).datagrid('reload');
            }
        },
        /*控制dialog打开关闭*/
        dialogController: function (dialogID, state, url) {
            this.SLog(dialogID, state, url);
            if (true === state) {
                $('#' + dialogID).dialog('center');
                $('#' + dialogID).dialog('open');
                if (url) {
                    $('#' + dialogID).dialog('refresh', url);
                }
            }
            else {
                $('#' + dialogID).dialog('close'); // close a window
            }
        }

    };
    return window.app = window.app || app;
})($, window);
