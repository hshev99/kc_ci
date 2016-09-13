<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title></title>
    <link href="<?php echo $css?>css/style.css" type="text/css" rel="stylesheet"/>
    <script src="<?php echo $css?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery.form.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery.uploadfile.min.js" type="text/javascript"></script>
</head>

<body class="back">
<div id="header">
    <div class="top">
        <div class="title">
            经纪人/经纪公司认证
            <div class="return"><a href="javascript:history.back(-1);"><img
                        src="<?php echo $css?>images/top.png" width="12"/> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div id="tabBox2" class="tabBox1">
        <div class="hd">
            <ul>
                <li><a href="javascript:void(0)">经纪人</a></li>
                <li><a href="javascript:void(0)">经纪公司</a></li>
            </ul>
        </div>
        <div class="bd" id="tabBox1-bd"><!-- 添加id，js用到 -->
            <div class="con"><!-- 高度自适应需添加外层 -->
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

                                <div class="select"><label><input type="radio" name="verify_type" value="2"
                                                                  class="radio"/><em>护照</em></label></div>
                                <div class="select"><label><input type="radio" name="verify_type" value="1" class="radio"
                                                                  checked="checked"/> <em>身份证</em></label></div>
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
                            <li>
                                <a class="file">
                                    <div id="fileuploader2"></div>
                                </a>
                                请上传经纪人证
                            </li>
                        </div>
                        <div class="refer">
                            <input id = 'inpButton' type="submit" class="autRefer" value="提交"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="con"><!-- 高度自适应需添加外层 -->
                <div class="infoEdit">
                    <form enctype="multipart/form-data" action="" method="post">
                        <ul>
                            <li>
                                <input  type="text" id="regName1" class="nameText" name="company_name"/>
                                <input type="hidden" class="nameText" name="way" value="3"/>
                                <input type="hidden" id="fileuploader3_input" class="nameText" name="img_positive"/>
                                <input type="hidden" id="fileuploader4_input" class="nameText" name="img_reverse"/>
                                <input type="hidden" id="fileuploader5_input" class="nameText" name="img_hand"/>
                                <span>公司名称</span></li>
                            <li><input  id="regNamePer1" type="text" class="nameText" name="law_name"/><span>法人姓名</span></li>
                            <li><input id="regTel1" type="tel" class="nameText" name="phone"/><span>联系方式</span></li>
                        </ul>
                        <div class="Upload">
                            <li>
                                <a class="file">
                                    <div id="fileuploader3"></div>
                                </a>
                                请上传法人身份证正面
                            </li>
                            <li>
                                <a class="file">
                                    <div id="fileuploader4"></div>
                                </a>
                                请上传法人身份证反面
                            </li>
                            <li>
                                <a class="file">
                                    <div id="fileuploader5"></div>
                                </a>
                                请上传营业执照
                            </li>
                        </div>
                        <div class="refer">
                            <input id="inpButton1" type="submit" class="autRefer" value="提交"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        TouchSlide({
            slideCell: "#tabBox2",

            endFun: function (i) { //高度自适应
                var bd = document.getElementById("tabBox1-bd");
                bd.parentNode.style.height = bd.children[i].children[0].offsetHeight + "px";
                if (i > 0)bd.parentNode.style.transition = "200ms";//添加动画效果
            }

        });</script>
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
    function checkVal1(){
        var defaultVal3 = $('#regName1').val(),
			defaultVal4 = $('#regNamePer1').val(),
            defaultVal5 = $('#regTel1').val();
        console.log(defaultVal3,defaultVal4,defaultVal5);
        if(defaultVal3 =='' || defaultVal4 ==''  || defaultVal5 ==''){
            $("#inpButton1").css({ "background": "gray"});
            $("#inpButton1").attr("disabled",true);
        }else{
            $("#inpButton1").css({ "background": "#fa424c"});
            $("#inpButton1").attr("disabled",false);
        }
    }
    !function(){
        checkVal1();
    }();
    $('#regName1').blur(function(){
        checkVal1();
    });
	$('#regNamePer1').blur(function(){
        checkVal1();
    });
    $('#regTel1').blur(function(){
        checkVal1();
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
</script>
<script type="text/javascript">
	$("#fileuploader2").click(function(){
        document.getElementsByClassName("img1")[2].src = "/static/images/loading.gif";
    });
    $(document).ready(function()
    {
        $("#fileuploader2").uploadFile({
            url:"../img/do_upload?uid=1",                 //文件上传url
            fileName:"userfile",
            showDone: false,                     //是否显示"Done"(完成)按钮
            showDelete: false,
            onSuccess: function(files,data,xhr,pd)
            {
                //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
                if(data){

                    // return false;
                    var strJSON=data;
                    var obj = new Function("return" + strJSON)();//转换后的JSON对象
                    // fileUpLoader.getElementByTagName('img')[0].src = obj.results.img;
                    document.getElementsByClassName("img1")[2].src = obj.results.img;
                    document.getElementById('fileuploader2_input').value = obj.results.img;
                }
            }
        })
    });
	$("#inpButton").click(function(){
		if($('#fileuploader0_input').val()==''){
			alert('请上传证件正面');
			return false;
			}
		if($('#fileuploader1_input').val()==''){
			alert('请上传证件反面');
			return false;
			}
		if($('#fileuploader2_input').val()==''){
			alert('请上传经纪人证');
			return false;
			}
		})
</script>

<script type="text/javascript">
	$("#fileuploader3").click(function(){
        document.getElementsByClassName("img1")[3].src = "/static/images/loading.gif";
    });
    $(document).ready(function()
    {
        $("#fileuploader3").uploadFile({
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
                    document.getElementsByClassName("img1")[3].src = obj.results.img;
                    document.getElementById('fileuploader3_input').value = obj.results.img;
                }
            }
        })
    });
</script>

<script type="text/javascript">
	$("#fileuploader4").click(function(){
        document.getElementsByClassName("img1")[4].src = "/static/images/loading.gif";
    });
    $(document).ready(function()
    {
        $("#fileuploader4").uploadFile({
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
                    document.getElementsByClassName("img1")[4].src = obj.results.img;
                    document.getElementById('fileuploader4_input').value = obj.results.img;
                }
            }
        })
    });
</script>

<script type="text/javascript">
	$("#fileuploader5").click(function(){
        document.getElementsByClassName("img1")[5].src = "/static/images/loading.gif";
    });
    $(document).ready(function()
    {
        $("#fileuploader5").uploadFile({
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
                    document.getElementsByClassName("img1")[5].src = obj.results.img;
                    document.getElementById('fileuploader5_input').value = obj.results.img;
                }
            }
        })
    });
	$("#inpButton1").click(function(){
		if($('#fileuploader3_input').val()==''){
			alert('请上传证件图片');
			return false;
			}
		if($('#fileuploader4_input').val()==''){
			alert('请上传证件图片');
			return false;
			}
		if($('#fileuploader5_input').val()==''){
			alert('请上传证件图片');
			return false;
			}
		})
</script>
</html>
