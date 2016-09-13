// JavaScript Document
$(function(){
    $('#log_sub').click(function(){
        $('#log_phone').keyup(function(){
            $('.log_prompt span').replaceWith('<span></span>');
        });
        $('#log_pass').keyup(function(){
            $('.log_prompt span').replaceWith('<span></span>');
        });
        if($('#log_phone').val().length == 0){
            document.getElementById("log_phone").focus();
            $('.log_prompt span').replaceWith('<span style="color:#fa424c;">您还没有输入帐号！</span>');
            return false;
        }
        if($('#log_pass').val().length == 0){
            document.getElementById("log_pass").focus();
            $('.log_prompt span').replaceWith('<span style="color:#fa424c;">您还没有输入密码！</span>');
            return false;
        }
        hash = hex_md5('password='+$("#log_pass").val());
        //alert(hash);
        $.ajax({
            type:'post',
            url:'../Login/login_check_web',
            data:{
                phone : $('#log_phone').val(),
                password :hash
            },
            success:function(data){
                //alert(data);
                var jsonobj=eval('('+data+')');
                //console.log(jsonobj.error);
                if(jsonobj.error == 202){
                    alert(jsonobj.msg);
                    return false;
                }else if(jsonobj.error == 0){
                    window.location.href="http://www.51huole.cn/pc/index";
                }
            }
        });
    })
});