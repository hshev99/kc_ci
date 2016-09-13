<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>特殊要求</title>
    <link href="<?php echo $css?>css/style.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo $css?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/PCASClass.js" type="text/javascript"></script>
</head>

<body class="back">
<div id="header">
    <div class="top">
        <div class="title">
            特殊要求
            <div class="return"><a href="singer"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="infoEdit">
        <form name="form1" onsubmit="return check()" action="" method="post">
            <ul> 
                    <div class="t_0100_3">
                        <span style="top:0; margin-top:0">特殊要求</span>
                        <div class="r_img"><img src="<?php echo $css?>images/main15.jpg" />
                            <div class="pf_20"><img src="<?php echo $css?>images/main14.jpg" /></div>
                        </div>
                        <div style="float:right; padding-right:10px; box-sizing:border-box;"><?php echo $user_info['special']?></div>
                    </div>
                    <div class="tel">
                        <textarea name="special" id="special" style="float:left; width:100%; border:1px solid #ccc; border-radius:5px;" value="<?php echo $user_info['special']?>"></textarea>
                    </div>
                </li>
                <input type="submit" value="完成" class="subPlay" />
            </ul>
        </form>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    function check()
    {
        /******  应用名称   ******/
        var username=document.getElementById("username").value;
        if(username==''){
            alert('用户名不能为空');
            return false;
        }
    }
    function check()
    {
        /******  联系方式   ******/
        var userTel=document.getElementById("userTel").value;
        if(userTel==''){
            alert('联系方式不能为空');
            return false;
        }
    }
</script>
