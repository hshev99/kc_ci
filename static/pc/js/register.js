// JavaScript Document
$(function(){
        $('#telPhone').focus(function(){
            if($('#telPhone').val().length == 0){
                $('.phonePro span').replaceWith('<span>仅限大陆手机号</span>');
            }
        }).blur(function(){
            $('.phonePro span').replaceWith('<span></span>');
        });
        $('#passNum').focus(function(){
            if($('#passNum').val().length == 0){
                $('.passPro1 span').replaceWith('<span>密码需包含字母数字或特殊字符且大于六位</span>')
            }
        }).blur(function(){
            $('.passPro1 span').replaceWith('<span></span>');
        });
		$('#telPhone').keyup(function(){
			$('.phonePro span').replaceWith('<span>仅限大陆手机号</span>');
			});
        $('#passNum').keyup(function(){
            $('.passPro1 span').replaceWith('<span>密码需包含字母数字或特殊字符且大于六位</span>');
        });
    });
    /*判断手机号 判断验证码*/
    $(function(){
        $('#telPhone').blur(function(){
            var myNum = /^((1[3-8]{1})+\d{9})$/;
            var eMail =/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
            var numVal = myNum.test($("#telPhone").val());
            var emailVal = eMail.test($("#telPhone").val());
            if($('#telPhone').val().length == 0){

            }else if(numVal || emailVal) {
                document.getElementById("btn").onclick=function(){time(this);};
            }else{
                $('.phonePro span').replaceWith('<span style="color:#fa424c;">请输入有效的手机号码</span>');
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
    /*判断密码*/
    $(function(){
        $('#passNum').blur(function(){
            var myPass = new RegExp (/((?=.*\d)(?=.*\D)|(?=.*[a-zA-Z])(?=.*[^a-zA-Z]))^.{6,20}$/);
            if($('#passNum').val().length == 0){

            }else if($('#passNum').val().length > 0 && $('#passNum').val().length < 6){
                $('.passPro1 span').replaceWith('<span style="color:#fa424c;">长度只能在6-20个字符之间</span>');
                return false;
            }else if(!myPass.test($("#passNum").val())){
                $('.passPro1 span').replaceWith('<span style="color:#fa424c;">密码需包含字母数字或特殊字符且大于六位</span>');
                return false;
            }
        });
    });
    $(function(){
        $('#subBut').click(function(){

        })
    });
$(function(){
    SID ="";
    $('#btn').click(function(){
        $.ajax({
            type:'get',
            url:'../Login/index?phone='+$('#telPhone').val(),
            success:function(data){
                var sbian = JSON.parse(data);
                SID = sbian.results.code;
            }
        })
    });
    $('#userVer').blur(function(){
        if($('#userVer').val()== SID){
        }else if($('#userVer').val().length == 0){
        }else{
            $('.ver1 span').replaceWith('<span style="color:#fa424c">验证码不正确</span>');
            return false;
        }
    });
    $('#userVer').keyup(function(){
        $('.ver1 span').replaceWith('<span></span>');
    });
    $('#subBut').click(function(){
        var myNum = /^((1[3-8]{1})+\d{9})$/;
        if($('#telPhone').val().length == 0){
            document.getElementById("telPhone").focus();
            $('.phonePro span').replaceWith('<span style="color:#fa424c;">手机号不能为空</span>');
            return false;
        }else if(!myNum.test($("#telPhone").val())){
            document.getElementById("telPhone").focus();
            return false;
        }
        if($('#userVer').val().length == 0){
            document.getElementById("userVer").focus();
            $('.ver1 span').replaceWith('<span style="color:#fa424c;">验证码不能为空</span>');
            return false;
        }else if($('#userVer').val()== SID){

        }else{
            document.getElementById("userVer").focus();
            $('.ver1 span').replaceWith('<span style="color:#fa424c">验证码不正确</span>');
            return false;
        }
        var myPass = new RegExp (/((?=.*\d)(?=.*\D)|(?=.*[a-zA-Z])(?=.*[^a-zA-Z]))^.{6,20}$/);
        if($('#passNum').val().length == 0){
            document.getElementById("passNum").focus();
            $('.passPro1 span').replaceWith('<span style="color:#fa424c;">密码不能为空</span>');
            return false;
        }else if(!myPass.test($("#passNum").val())){
            document.getElementById("passNum").focus();
            return false;
        }
        $('.reg_prompt').css('display','block')
    });
    $('.press a').click(function(){
        hash = hex_md5('password='+$("#passNum").val());
        obj=document.getElementsByName('sel');
        for(var i = 0; i < obj.length; i ++){
            if(obj[i].checked){
               chaol=obj[i].value;
            }
        }
        $.ajax({
            type:'post',
            url:'../Login/pc_login_save_web',
            data:{
                phone : $('#telPhone').val(),
                password : hash,
                code : $('#userVer').val(),
                type : chaol
            },
            success:function(data){
                var jsonobj=eval('('+data+')');
                console.log(jsonobj.error);
                if(jsonobj.error != 0){
                    alert(jsonobj.msg);
                    return false;
                }

            }
        })
    });
});