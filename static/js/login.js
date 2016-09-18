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
                    document.getElementById("user_name").focus();
                    $('.user_prompt span').replaceWith('<span style="color:#fa424c;">'+user_info.errorMsg+'</span>');
                    //alert(user_info.errorMsg);
                    return false;
                }else if(user_info.error == 0){
                    window.location.href="/index/index";
                }
            }
        })
    });
});
/*判断手机号 判断验证码*/
$(function(){
    $('#user_name_pass').blur(function(){
        var myNum = /^((1[3-8]{1})+\d{9})$/;
        var numVal = myNum.test($("#user_name_pass").val());
        if($('#user_name_pass').val().length == 0){

        }else if(numVal) {
            document.getElementById("btn").onclick=function(){time(this);};
        }else{
            $('.user_prompt span').replaceWith('<span style="color:#fa424c;">请输入有效的手机号码</span>');
            return false;
        }
    });

    var wait=60;
    function time(o) {
        if (wait == 0) {
            o.removeAttribute("disabled");
            o.value="获取验证码";
            wait = 60;
        } else {
            o.setAttribute("disabled", true);
            o.value="重新发送(" + wait + ")";
            wait--;
            setTimeout(function() {
                time(o)
            }, 1000)
        }
    }

});





















