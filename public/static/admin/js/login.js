/**
 * Created by txkj on 17/2/28.
 */
$(function () {
    $('#login_form').form({
        url: 'login',
        onSubmit: function () {
            var flag = true;
            flag = $('#username').textbox('isValid');

            if (!flag) {
                $.messager.show({
                    title:'错误',
                    msg:'请输入用户名',
                    showType:'fade',
                    style:{
                        right:'',
                        bottom:''
                    }
                });
                return flag;
            }
            flag = $('#password').textbox('isValid');
            if (!flag) {
                $.messager.show({
                    title:'错误',
                    msg:'请输入密码',
                    showType:'fade',
                    style:{
                        right:'',
                        bottom:''
                    }
                });
                return flag;
            }
            return flag;
        },
        success: function (data) {
            try{
                data = JSON.parse(data);
                if(200 == data.Code){
                    location.href = data.Msg;
                }
                else{
                    $.messager.show({
                        title:'错误',
                        msg:data.Msg,
                        showType:'fade',
                        style:{
                            right:'',
                            bottom:''
                        }
                    });
                }
            }
            catch (e){
                $.messager.show({
                    title:'错误',
                    msg:'网络错误！',
                    showType:'fade',
                    style:{
                        right:'',
                        bottom:''
                    }
                });
            }
        }
    });

    $("#sub").on('click', function (e) {
        $('#login_form').submit();
    });


    $("body").keydown(function (e) {
        var curKey = e.which;
        if (curKey == 13) {
            $("#sub").click();
        }
    });
});