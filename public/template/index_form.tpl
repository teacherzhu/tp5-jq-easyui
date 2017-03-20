{__NOLAYOUT__}
{present name="form"}
{notempty name="form"}
    <form id="{$Request.controller}_form" method="post">

        {if condition="(count($form)/2) egt 4"}
            <div style="width:50%;float:left">

            </div>
            <div style="width:50%;float:left">

            </div>
        {else}
            <div style="width:100%;float:left">
                {volist name="form" id="formList"}
                    <div></div>
                    {if condition="$formList.visiable eq true"}
                    <label>{$formList.text}</label>
                    <input id="inp_{$formList.name}" type="text" name="{$formList.name}"/>

                    <span> * </span>
                    {/if}
                {/volist}
            </div>
        {/if}
    </form>
{/notempty}
{/present}