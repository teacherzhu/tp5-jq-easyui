{__NOLAYOUT__}
{present name="search"}
{notempty name="search"}
    <div id="search_dialog">
        <form id="search_from" method="post">
            {volist name="search.search_list" id="search_list_item"}
                <div>
                    <label>{$search_list_item.title}</label>
                    <input name={$search_list_item.name} class={$search_list_item.class}
                           data-options={$search_list_item.options}>
                </div>
            {/volist}
        </form>
    </div>
{/notempty}
{/present}
{present name="table"}
{notempty name="table"}
{notempty name="table.tool_bar"}
    <div id="{$table.tool_bar.id}">
        {foreach $table.tool_bar.list as $tool}
            <a href="#" controller="{$table.tool_bar.controller}" grid="{$table.id}"
               gridType="{$table.tool_bar.gridType}" class="{$tool.class}" onclick="{$tool.click}"
               data-options="{$tool.options}"></a>
        {/foreach}
    </div>
{/notempty}
    <table id="{$table.id}" class="{$table.class}" data-options="{$table.options}">
        <thead>
        <tr>
            {foreach $table.columns as $column}
                <th data-options="{$column.options}"></th>
            {/foreach}
        </tr>
        </thead>
    </table>
    <div id="{$Request.controller}_dialog" class="easyui-dialog" style="width:auto;height:auto"
         data-options="buttons:'#{$Request.controller}_buttons',collapsible:false,minimizable:false,maximizable:false,shadow:false,closed:true,modal:true"></div>
    <div id="{$Request.controller}_buttons">
        <a href="#" class="easyui-linkbutton" onclick="window.app.formController('{$Request.controller}')">Save</a>
        <a href="#" class="easyui-linkbutton" onclick="window.app.dialogController('{$Request.controller}_dialog',false)">Close</a>
    </div>
{/notempty}
{/present}

