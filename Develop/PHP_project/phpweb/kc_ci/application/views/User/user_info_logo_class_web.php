<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title></title>
    <link href="<?php echo $css;?>css/style.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo $css;?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css;?>js/jquery-1.11.2.min.js" type="text/javascript"></script>

</head>

<body class="back">
<div id="header">
    <div class="top">
        <div class="title">
            风格标签
            <div class="return"><a href="javascript :;" onClick="javascript :history.back(-1);"><img src="<?php echo $css;?>images/top.png" width="12" /> 返回</a></div>
            <div class="complete"><a href="javascript:void(0)" onclick="document.getElementById('tform').submit()">完成</a></div>
        </div>
    </div>
</div>
<form action="save_user_info_logo_class?uid=<?php echo $uid?>" method="post" id="tform"><input type="hidden" name="uid" value="<?php echo $uid?>" />
<div id="content">
    <div class="labelList">
        <ul id="tul">

            <?php foreach ($style as $val){;?>
                <li onclick="myasd(this)" class="<?php if ($val['status'] >0 ){echo 'on';}?>" value="<?php echo $val['id']?>"><input type="hidden" id="logo" name="logo[]" value="<?php if ($val['status']){ echo $val['id'];}?>"><?php echo $val['name']?></li>
            <?php }?>

        </ul>
        <div class="genre"><span>*</span> 您可以最大选中三种风格做为标签</div>
    </div>
</div>
</form>
</body>
</html>
<script>
    function myasd(event) {

        if(event.className == ''){
            if( check_myasd()){
                event.setAttribute("class", "on");
                event.firstChild.value=event.getAttribute('value');
            }

        }else {
            event.setAttribute("class", "");
            event.firstChild.value='';
        }

    }

    function check_myasd() {
        var cNode =document.getElementById('tul').getElementsByTagName('input');

        var t=0;
        for( var i=0; i<cNode.length; i++){
            if(cNode.item(i).value != ''){
                t++;
            };
        }
        if (t >= 3){
            alert("最多为三个");
            return false;
        }

        return true;
    }
</script>