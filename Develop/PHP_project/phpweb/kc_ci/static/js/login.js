// JavaScript Document
$(function(){
    $('#sub').click(function(){
        $('#user_name').keyup(function(){
            $('.log_prompt span').replaceWith('<span></span>');
        });
        $('#user_pass').keyup(function(){
            $('.log_pass span').replaceWith('<span></span>');
        });
        if($('#user_name').val().length==0){
            document.getElementById("user_name").focus();
            $('.log_prompt span').replaceWith('<span style="color:#fa424c;">您还没有输入帐号！</span>');
            return false;
        }
        if($('#user_pass').val().length==0){
            document.getElementById("user_pass").focus();
            $('.log_pass span').replaceWith('<span style="color:#fa424c;">您还没有输入密码！</span>');
            return false;
        }
        $.ajax({
            type:'post',
            url:'../login/getAdminUser',
            data:{
                login_name:$('#user_name') .val(),
                password:$('#user_pass').val()
            },
            success:function(data){
                var user_info=eval('('+data+')');
                if(user_info.error == 102){
                    alert(user_info.errorMsg);
                    return false;
                }else if(user_info.error == 0){
                    window.location.href="http://www.51huole.cn/pc/index";
                }
            }
        })
    });
});





















