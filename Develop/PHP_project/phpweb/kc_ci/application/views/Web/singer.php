<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title></title>
    <link href="<?php echo $css?>css/style.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo $css?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery-1.11.2.min.js" type="text/javascript"></script>
	<script src="<?php echo $css?>js/jquery.uploadfile.min2.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery.form.js" type="text/javascript"></script>
</head>

<body>
<div class="banner">
    <div id="focus" class="focus">
        <div class="bd" style="background:#1a191f; height:240px;">
            
        </div>
        <div class="headFloat">
            <div class="handImg">
                <span>
                    <!--<img src="<?php echo $user['img']?>">-->
                    <div id="fileuploader0"> </div>
                </span>
            </div>
            <div class="starName"><?php echo $user['name']?></div>
        </div>
    </div>
</div>
<div id="content" style="margin-top:0">
    <div class="grag1"></div>
    <div class="starInfo">
        <ul>
            <li><a href="info"><img src="<?php echo $css?>images/star1.jpg"  /> &nbsp;基本信息</a></li>
            <li><a href="authentication?verify=<?php echo $user['verify'] ?>"><img src="<?php echo $css?>images/star2.jpg"  /> &nbsp;认证状态 <?php if($user['verify']==0){ ?><span>未认证</span><?php }else if($user['verify']==1){ ?><span>已认证</span><?php }else if($user['verify']==2) {?><span>审核中</span><?php } ?></a></li>
        </ul>
        <div class="grag1"></div>

        <?php if ($user['type'] == 7){?>
        <ul>
            <li><a href="styleLabel"><img src="<?php echo $css?>images/star3.jpg"  /> &nbsp;歌手风格</a></li>
            <!--<li><a href="info"><img src="<?php echo $css?>images/star4.jpg"  /> &nbsp;特殊要求</a></li>-->
            <li><a href="date?singer=<?php echo $user_login['uid']?>"><img src="<?php echo $css?>images/star5.jpg"  /> &nbsp;可约档期</a></li>
            <li><a href="info"><img src="<?php echo $css?>images/star6.jpg"  /> &nbsp;出场费用 <span class="color1"><?php echo $user['price']?>万元/场</span></a></li>
        </ul>
        <div class="gray"></div>
        <?php }?>

        <ul>

            <?php if ($user['type'] == 5 || $user['type'] == 6){?>
            <li><a href="SingerManagement"><img src="<?php echo $css?>images/star12.jpg"  /> &nbsp;歌手管理</a></li>
            <?php }?>
            <li><a href="Mycollection"><img src="<?php echo $css?>images/star7.jpg"  /> &nbsp;我的收藏</a></li>
        </ul>
        <div class="gray"></div>
        <ul>
            <li><a href="reset"><img src="<?php echo $css?>images/star8.jpg"  /> &nbsp;修改密码</a></li>
            <li><a href="message"><img src="<?php echo $css?>images/star9.jpg"  /> &nbsp;消息通知</a></li>
            <li><a href="adout"><img src="<?php echo $css?>images/star10.jpg"  /> &nbsp;关于我们</a></li>
            <li><a href="Feedback"><img src="<?php echo $css?>images/star11.jpg"  /> &nbsp;意见反馈</a></li>
        </ul>
    </div>
    <div class="gray" style="height:25px"></div>
    <div class="signOut">
        <a href="login_out">退出登录</a>
    </div>
    <div class="grag1" style="height:25px"></div>
</div>
<?php include "foot.ctp";?>
<script type="text/javascript">
    $(document).ready(function()
    {
        var  fileUpLoader = document.getElementById("fileuploader0");
        $("#fileuploader0").uploadFile({
            url:"../img/portrait?uid=<?php echo $user_login['uid']?>",                 //文件上传url
            fileName:"userfile",
            showDone: false,                     //是否显示"Done"(完成)按钮
            showDelete: false,
            onSuccess: function(files,data,xhr,pd)
            {
                //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
                if(data){
                    var strJSON=data;
                    var obj = new Function("return" + strJSON)();//转换后的JSON对象
                    document.getElementsByClassName("img1")[0].src = obj.results.img;
                    //document.getElementById('fileuploader0_input').value = obj.results.img;
                }
            }
        })
    });
</script>

</body>
</html>
<script >
$(document).ready(function(){
	setTimeout(function(){
		document.getElementsByClassName("img1")[0].src = '<?php echo $user['img']?>';
                },4000);
	})
</script>

