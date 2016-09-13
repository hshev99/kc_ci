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
        <form name="form1" onsubmit="return check()" action="" method="post">
            <ul>
                <li><input type="text" class="nameText" id="username" name="name" value="<?php echo $user_info['name']?>"/><span>姓名</span></li>
                <li><input type="tel" class="nameText" id="userTel" name="phone" value="<?php echo $user_info['phone']?>" /><span>联系方式</span></li>
				<?php if ($user_login['type'] ==6 || $user_login['type']==7){?>
                <li>
                    <div class="t_0100_3">
                        <span style="top:0; margin-top:0">出场费用</span>
                        <div class="r_img"><img src="<?php echo $css?>images/main15.jpg" />
                        </div>
                    </div>
                    <div class="tel">
               		 <div style="float:left; width:100%; position:relative; height:40px; line-height:40px;"><input type="tel" class="nameText" id="" name="history_price" value="<?php echo $user_info['history_price']?>" style="padding-right:50px; height:40px; line-height:40px;" /><span>原价</span><em style="position:absolute; z-index:11; right:3%; height:40px; top:0px; font-size:14px; line-height:40px; font-style:normal;">万/场</em></div>
                     <div style="float:left; width:100%; position:relative;  height:40px; line-height:40px;"><input type="tel" class="nameText" id="userTel" name="price" value="<?php echo $user_info['price']?>" style="padding-right:50px; height:40px; line-height:40px;" /><span>现价</span><em style="position:absolute; z-index:11; right:3%; height:40px; top:0px; font-size:14px; line-height:40px; font-style:normal;">万/场</em></div>
                    </div>
                </li>
                <li>
                    <div class="t_0100_3">
                        <span style="top:0; margin-top:0">特殊要求</span>
                        <div class="r_img"><img src="<?php echo $css?>images/main15.jpg" />
                        </div>
                        <div style="float:right; padding-right:10px; box-sizing:border-box;"><?php echo $user_info['special']?></div>
                    </div>
                    <div class="tel">
                        <textarea name="special" id="special" style="float:left; width:100%; border:1px solid #ccc; border-radius:5px;"  placeholder="如有不能接受的演出，请在此处标记"  value="<?php echo $user_info['special']?>"></textarea>
                    </div>
                </li>
                <?php }?>
                <li>
                    <div class="t_0100_3">
                        <span style="top:0; margin-top:0">所在地</span>
                        <div class="r_img"><img src="<?php echo $css?>images/main15.jpg" />
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
        <?php if ($user_login['type'] ==6 || $user_login['type']==7){?>
        document.getElementById("special").value="<?php echo $user_info['special']?>";
        <?php }?>
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
        var username=document.getElementById("username").value;
		var userTel=document.getElementById("userTel").value;
        if(username==''){
            alert('用户名不能为空'); 
			return false;
        }
		if(userTel==''){
            alert('联系方式不能为空');
			return false;
        }
    }
	
</script>
