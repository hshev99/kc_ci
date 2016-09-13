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
<form action="login_md" method="post" onsubmit="return tijiao()">
    <div id="header">
        <div class="top">
            <div class="title">
                登录
                <div class="return"><a href="index"><img src="<?php echo $css; ?>images/top.png" width="12" /> 返回</a></div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="logIn">
            <div class="Name">
                <div class="icon"><span><img src="<?php echo $css; ?>images/log.jpg" width="70%" /></span></div>
                <input type="text" name="phone" id="phone" class="userN" onblur="blur_phone()" placeholder="用户名/手机号" />
            </div>
            <div class="Name">
                <div class="icon"><span><img src="<?php echo $css; ?>images/log1.jpg" width="70%" /></span></div>
                <input type="password" name="password" id="password" onblur="blur_password()" class="userN" placeholder="密   码" />
            </div>
            <div class="logPrompt">
                <a href="login_forget_web">忘记密码？</a>
                <a href="registered">注册</a>
            </div>
            <input type="submit" value="登 录" class="button" />
        </div>
        <div class="other">
            <!-- <a href="login_qq"><img src="<?php echo $css; ?>images/icon1.jpg" width="100%" /></a> -->
            <a href="#"><img src="<?php echo $css; ?>images/icon1.jpg" width="100%" /></a>
            <a href="#"><img src="<?php echo $css; ?>images/icon2.jpg" width="100%" /></a>
            <a href="login_lib"><img src="<?php echo $css; ?>images/icon3.jpg" width="100%" /></a>
        </div>
        <div class="ProTit">其它方式登录</div>
    </div>
</form>
</body>
</html>
<script>
    function blur_phone(){
        var phone = $("#phone").val();
        if (phone == ''){
            return false;
        }else{
            return true;
        }
    }

    function blur_password(){
        var password = $("#password").val();
        if (password == ''){
            return false;
        }else{
            return true;
        }
    }

    function tijiao(){
        if(!blur_phone()){
            alert("用户名/手机号 不能为空");
            return false;
        }else if(!blur_password()){
            alert("密码不能为空");
            return false;
        }else{
            return true;
        }
    }
</script>