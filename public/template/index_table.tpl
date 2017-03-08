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
        <table id={$table.id} class=easyui-datagrid data-options={$table.options}>
            <thead>
            <tr>
                {volist name="table.columns" id="column"}
                    <th data-options={$column.options}></th>
                {/volist}
            </tr>
            </thead>
        </table>
    {/present}
{/block}