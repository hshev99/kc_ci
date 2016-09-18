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
    $('#user_new_pass').focus(function(){
        if($('#user_new_pass').val().length == 0){
            $('.log_pass span').replaceWith('<span>密码需包含字母数字或特殊字符且大于六位</span>')
        }
    }).blur(function(){
        $('.log_pass span').replaceWith('<span></span>');
    });
    $('#user_name_pass').blur(function(){
        var myNum = /^((1[3-8]{1})+\d{9})$/;
        var numVal = myNum.test($("#user_name_pass").val());
        if($('#user_name_pass').val().length == 0){

        }else if(numVal) {
            document.getElementById("btn").onclick=function(){time(this);};
        }else{
            $('.log_prompt span').replaceWith('<span style="color:#fa424c;">请输入有效的手机号码</span>');
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
    /*判断密码*/
    $(function(){
        $('#user_new_pass').blur(function(){
            var myPass = new RegExp (/((?=.*\d)(?=.*\D)|(?=.*[a-zA-Z])(?=.*[^a-zA-Z]))^.{6,20}$/);
            if($('#user_new_pass').val().length == 0){

            }else if($('#user_new_pass').val().length > 0 && $('#user_new_pass').val().length < 6){
                $('.log_pass span').replaceWith('<span style="color:#fa424c;">长度只能在6-20个字符之间</span>');
                return false;
            }else if(!myPass.test($("#user_new_pass").val())){
                $('.log_pass span').replaceWith('<span style="color:#fa424c;">密码需包含字母数字或特殊字符且大于六位</span>');
                return false;
            }
        });
        $('#user_new1_pass').blur(function(){
            if($('#user_new1_pass').val() != $('#user_new_pass').val()){
                $('.log_pass_new span').replaceWith('<span style="color:#fa424c;">两次密码不一致</span>');
            }
        })
    });

    SID ="";
    $('#btn').click(function(){
        $.ajax({
            type:'post',
            url:'../login/getSmsCode',
            data:{phone:$('#user_name_pass').val()},
            success:function(data){
                var sbian = JSON.parse(data);
                SID = sbian.results.code;
            }
        })
    });
    // $('#user_code').blur(function(){
    //     if($('#user_code').val()== SID){
    //     }else if($('#user_code').val().length == 0){
    //     }else{
    //         $('.log_code span').replaceWith('<span style="color:#fa424c">验证码不正确</span>');
    //         return false;
    //     }
    // });
    // $('#user_code').keyup(function(){
    //     $('.log_code span').replaceWith('<span></span>');
    // });

    $('#pre_submit').click(function(){

    })
});





















