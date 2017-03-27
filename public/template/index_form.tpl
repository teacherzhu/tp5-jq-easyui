{__NOLAYOUT__}
{present name="form"}
{notempty name="form"}
    <form id="{$Request.controller}_form" method="post">

        {if condition="count($form) egt 5"}
            <div style="width:50%;float:left">

            </div>
            <div style="width:50%;float:left">

            </div>
        {else}
            <div style="width:100%;float:left">
                {volist name="formList" id="list"}
                {if condition="$list.visiable eq true"}
                    <div>
                        <label>{$list.text}</label>
                        <input id="inp_{$list.name}" type="text" name="{$list.name}"/>
                    </div>
                {else}
                    <input id="inp_{$list.name}" type="text" name="{$list.name}" type="hidden"/>
                {/if}
                {/volist}
            </div>
        {/if}
    </form>
{/notempty}
{/present}