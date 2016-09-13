<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>登录修改密码</title>
    <link href="<?php echo $css?>css/style.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo $css?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/PCASClass.js" type="text/javascript"></script>
</head>

<body class="back">
<div id="header">
    <div class="top">
        <div class="title">
            修改密码
            <div class="return"><a href="singer"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="infoEdit">
        <form name="form1" action="old_pwd" method="post">
            <ul>
                <li><input type="password" class="nameText" id="" name="old_password" value=""/><span>原密码</span></li>
                <li><input type="password" id="passNum" class="nameText" id="" name="password" value="" /><span>新密码</span></li>
                <li><input type="password" id="newPass" class="nameText" id="" name="new_password" value="" /><span>确认密码</span></li>
                <input type="submit" value="保存" class="subPlay" id="subBut" />
            </ul>
        </form>
    </div>
</div>
<script>
 $(function(){
        SID ="";
        $('#subBut').click(function(){
			var myPass = new RegExp (/((?=.*\d)(?=.*\D)|(?=.*[a-zA-Z])(?=.*[^a-zA-Z]))^.{6,20}$/);
            if($('#passNum').val().length == 0){
                document.getElementById("passNum").focus();
				alert('密码不能为空');
				return false;
            }else if(!myPass.test($("#passNum").val())){
				document.getElementById("passNum").focus();
				alert('密码需包含字母数字或特殊字符且大于六位');
                return false;
            };  
			if($('#newPass').val() == $('#passNum').val()){
				}else{alert('两次密码输入不一致')}     
        })
    })
</script>
</body>
</html>
