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
    <script src="<?php echo $css?>js/jquery.form.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery.uploadfile.min.js" type="text/javascript"></script>
</head>

<body class="back">
<div id="header">
    <div class="top">
        <div class="title">
            歌手认证
            <div class="return"><a href="javascript:history.back(-1);"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="infoEdit">
        <form enctype="multipart/form-data" action="" method="post">
            <ul>
                <li>
                                <input id='regName' type="text" class="nameText" name="name"/><span>姓名</span>
                                <input type="hidden" class="nameText" name="way" value="2"/>
                                <input type="hidden" id="fileuploader0_input" class="nameText" name="img_positive"/>
                                <input type="hidden" id="fileuploader1_input" class="nameText" name="img_reverse"/>
                                <input type="hidden" id="fileuploader2_input" class="nameText" name="img_hand"/>
                            </li>
                            <li><input id='regTel' type="tel" class="nameText" name="phone"/><span>联系方式</span></li>
                <li><span>证件类型</span>
                    <div class="select"><label><input type="radio" name="verify_type" class="radio" value="2"  checked="checked" /><em>护照</em></label></div>
                    <div class="select"><label><input type="radio" name="verify_type" class="radio" value="1" /> <em>身份证</em></label></div>
                </li>
                <li><span>公司邮箱</span>
                    <div class="e-mail">
                        <p>huole@51huole.cn</p>
                        （请将个人作品或链接发送至此邮箱等待人工审核）
                    </div>
                </li>
            </ul>
            <div class="Upload">
                <li>
                    <a class="file">
                        <div id="fileuploader0"></div>
                    </a>
                    请上传证件正面
                </li>
                <li>
                    <a class="file">
                        <div id="fileuploader1"></div>
                    </a>
                    请上传证件反面
                </li>
            </div>
            <div class="refer">
                <input type="submit" id = 'inpButton' class="autRefer" value="提交" />
            </div>
        </form>
    </div>
</div>
</body>
<script type="text/javascript">
    function checkVal(){
        var defaultVal1 = $('#regName').val(),
            defaultVal2 = $('#regTel').val();
        console.log(defaultVal1,defaultVal2);
        if(defaultVal1 =='' || defaultVal2 =='' ){
            $("#inpButton").css({ "background": "gray"});
            $("#inpButton").attr("disabled",true);
        }else{
            $("#inpButton").css({ "background": "#fa424c"});
            $("#inpButton").attr("disabled",false);
        }
    }
    !function(){
        checkVal();
    }();
    $('#regName').blur(function(){
        checkVal();
    });
    $('#regTel').blur(function(){
        checkVal();
    });
</script>
<script type="text/javascript">

    $("#fileuploader0").click(function(){
        document.getElementsByClassName("img1")[0].src = "/static/images/loading.gif";
    });

    $(document).ready(function()
    {
    $("#fileuploader0").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
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
                document.getElementById('fileuploader0_input').value = obj.results.img;
            }
        }
    })
});
</script>
<script type="text/javascript">
	$("#fileuploader1").click(function(){
        document.getElementsByClassName("img1")[1].src = "/static/images/loading.gif";
    });
    $(document).ready(function()
    {
        $("#fileuploader1").uploadFile({
            url:"../img/do_upload?uid=1",                 //文件上传url
            fileName:"userfile",
            showDone: false,                     //是否显示"Done"(完成)按钮
            showDelete: false,
            onSuccess: function(files,data,xhr,pd)
            {
                //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
                if(data){
                    var strJSON=data;
                    var obj = new Function("return" + strJSON)();//转换后的JSON对象
                    document.getElementsByClassName("img1")[1].src = obj.results.img;
                    document.getElementById('fileuploader1_input').value = obj.results.img;
                }
            }
        })
    });
	$("#inpButton").click(function(){
		if($('#fileuploader1_input').val()==''){
			alert('请上传证件图片');
			return false;
			}
		if($('#fileuploader0_input').val()==''){
			alert('请上传证件图片');
			return false;
			}
		})
</script>
</html>
