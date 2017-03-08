{block name="body"}
    <!-- 搜索框 -->
    {present name="search"}
        <div id="search_dialog">
            <form id="search_from" method="post">
                {volist name="search.search_list" id="search_list_item"}
                    <div>
                        <label>{$search_list_item.title}</label>
                        <input name="{$search_list_item.name}" class="{$search_list_item.class}"
                               data-options="{$search_list_item.options}">
                    </div>
                {/volist}
            </form>
        </div>
    {/present}

    {present name="table"}
        <!-- 工具栏按钮 -->
    {present name="table.tool_bar"}
        <div id="{$table.tool_bar.id}">
            {volist name="table.tool_bar.list" id="list"}
                {*<a href="{$button.href}" class="{$button.class}" data-options="{$button.options}" onclick="{$button.click}"></a>*}
            {/volist}
        </div>
    {/present}
        <table id="{$table.id}" class="easyui-datagrid">
            <thead>
            <tr>
                {volist name="table.table_list" id="column"}
                    <th data-options="{$column.options}"></th>
                {/volist}
            </tr>
            </thead>
        </table>
    {/present}
{/block}
{block name="body-js"}
    <script type="text/javascript">
        function edit_fuc(id) {
            alert(id);
        }
    </script>
{/block}