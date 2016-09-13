<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
<title></title>
<link href="<?php echo $css; ?>css/style.css" type="text/css" rel="stylesheet" />
<script src="<?php echo $css; ?>js/TouchSlide.1.1.js" type="text/javascript"></script>

<script src="<?php echo $css; ?>js/jquery-1.11.2.min.js" type="text/javascript"></script>

</head>

<body>
<form action="login_save_web_md" method="post" onsubmit="return tijiao()">
<div id="header">
    <div class="top">
        <div class="title">
            注册 
            <div class="return"><a href="login"><img src="<?php echo $css; ?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="logIn">
        <div class="Name">
            <div class="icon"><span><img src="<?php echo $css; ?>images/log.jpg" width="70%" /></span></div>
            <input type="text" class="userN" name="phone" id="phone" onblur="blur_phone()" placeholder="请输入手机号" />
        </div>
        <div class="Name padding">
            <div class="icon"><span><img src="<?php echo $css; ?>images/log2.jpg" width="70%" /></span></div>
            <input type="password" class="userN" id="user_btn" onblur="blur_btn()" placeholder="请输入验证码" />
            <input class="verification" name="code" id="btn" type="button" value="获取验证码" />
        </div>
        <div class="Name">
            <div class="icon"><span><img src="<?php echo $css; ?>images/log1.jpg" width="70%" /></span></div>
            <input type="password" name="password" id="password" onblur="blur_password()" class="userN" placeholder="密   码" />
        </div>
        <div class="protocol">
            点击“注册”即表示同意<a href="Agreement"><span>《用户使用协议》</span></a>
        </div>
        <input type="submit" value="注 册" class="button" style="margin-top:0;" />
    </div>
</div>
    </form>
</body>
</html>
<script>
    var code="";
    function click_phone(){
        var phone = $("#phone").val();
        $.ajax({
            type: "POST",
            async : false,
            cache : false,
            dataType : "json",
            url: "../Login/index?phone="+phone,
            success: function(msg){
                if (msg.error != 0){
                    alert(msg.errorMsg);
                }else {
                    code = msg.results.code;
                    alert("短信发送成功");
                }
           }
        
        });
    }

    var wait=60;
    var phone = $("#phone").val();
    function time(o) {
        if (wait == 0) {
            o.removeAttribute("disabled");
            o.value="免费获取验证码";
            wait = 60;
        } else {
            o.setAttribute("disabled", true);
            o.value="重新发送("+wait+")";
            wait--;
            setTimeout(function() {
                    time(o)
                },
                1000)
        }

    }

    document.getElementById("btn").onclick=function(){
        var phone = $("#phone").val();
        if (phone == ''){
            alert("手机号码不能为空");
            return false;
        }else {
            time(this);click_phone(this);
        }
    }

    function blur_phone(){
        var phone = $("#phone").val();
        if (phone == ''){
            return false;
        }else{
            return true;
        }
    }

    function blur_btn(){
        var user_btn = $("#user_btn").val();
        if (user_btn == ''){
            return false;
        }else if(user_btn!=code){
            alert("输入正确的验证码");
            return false;
        }else{
            return true;
        }
    }

    function blur_password(){
        var myPass = new RegExp (/((?=.*\d)(?=.*\D)|(?=.*[a-zA-Z])(?=.*[^a-zA-Z]))^.{6,20}$/);
        var password = $("#password").val();
        if (password == ''){
            return false;
        }else if(!myPass.test(password)){
            return false;
        }else{
            return true;
        }
    }

    function tijiao(){
        if(!blur_phone()){
            alert("手机号码不能为空");
            return false;
        }else if(!blur_password()){
            alert("密码不能为空或者密码需包含字母数字或特殊字符且大于六位");
            return false;
        }else if(!blur_btn()){
            alert("验证码不能为空");
            return false;
        }else{
            return true;
        }
    }
    // $(function(){
    //     SID ="";
    //     $.ajax({
    //         type:'post',
    //         url:'../Web/login_save_web_md',
    //         dataType: 'jsonp',
    //         data:{
    //            phone:$('#Phone').val(),
    //            // password:$('#password').val(),
    //              },
    //         success:function(data){
    //             var sbian = JSON.parse(data);
    //             SID = sbian.results.phone;
    //                 },
    //             });
    //     $('.button').blur(function(){
    //         if($('#Phone').val()== SID){
    //             alert(SID);
    //           }else{
    //             return false;
    //           };
    //       });
    // });
</script>
