<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>基本信息</title>
    <link href="<?php echo $css?>css/style.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo $css?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/PCASClass.js" type="text/javascript"></script>
</head>

<body class="back">
<div id="header">
    <div class="top">
        <div class="title">
            基本信息
            <div class="return"><a href="singer"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="infoEdit">
        <form name="form1" onsubmit="return check()" action="SingerManagementAdd_info" method="post">
            <ul>
                <li><input type="text" class="nameText" id="username" name="name" value="<?php echo $user_info['name']?>"/><span>姓名</span></li>
                <li><input type="tel" class="nameText" id="userTel" name="phone" value="<?php echo $user_info['phone']?>" /><span>联系方式</span></li>
                <?php if ($user_login['type'])?>
                <li><input type="tel" class="nameText" id="userTel" name="price" value="<?php echo $user_info['price']?>" /><span>出场费用</span></li>
                <li>
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
                <li>
                    <div class="t_0100_3">
                        <span style="top:0; margin-top:0">所在地</span>
                        <div class="r_img"><img src="<?php echo $css?>images/main15.jpg" />
                            <div class="pf_20"><img src="<?php echo $css?>images/main14.jpg" /></div>
                        </div>
                        <div style="float:right; padding-right:10px; width:100%; text-align:right; box-sizing:border-box;"><?php echo $user_info['home']?></div>
                    </div>
                    <div class="tel">
                        <select name="home_1"></select>
                        <select name="home_2"></select>
                        <select name="home_3"></select>
                    </div>
                </li>
                <input type="submit" value="完成" class="subPlay" />
            </ul>
        </form>
    </div>
    <script type="text/javascript">
        document.getElementById("special").value="<?php echo $user_info['special']?>";
        <?php if (!empty($user_info['home'])){?>
        new PCAS("home_1","home_2","home_3","<?php echo empty(explode('-',$user_info['home'])[0]) ? "北京市" : explode('-',$user_info['home'])[0];?>","<?php echo empty(explode('-',$user_info['home'])[1]) ? "北京市" : explode('-',$user_info['home'])[1]?>","<?php echo empty(explode('-',$user_info['home'])[2]) ? "朝阳区" : explode('-',$user_info['home'])[2]?>");
        <?php }else{?>
        new PCAS("home_1","home_2","home_3","北京市","北京市","朝阳区");
        <?php }?>

        $(document).ready(function(){
            $(".t_0100_3").click(function(){
                $(this).next().slideToggle();
            });
        });
    </script>
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
