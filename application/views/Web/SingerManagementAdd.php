<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title></title>
    <link href="/static/css/style.css" type="text/css" rel="stylesheet" />
    <script src="/static/js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="/static/js/jquery-1.11.2.min.js" type="text/javascript"></script>
	<script src="/static/js/PCASClass.js" type="text/javascript"></script>
    <script src="/static/js/jquery.uploadfile.min1.js" type="text/javascript"></script>
</head>

<body class="back">
<div class="banner">
    <div id="focus" class="focus">
        <div class="bd" style="height:240px; background:#1a191f;">
        </div>
        <div class="headFloat">
            <div class="handImg">
                <span>
                 <div id="fileuploader0"></div>
                </span>
            </div>
            <div class="starName"> </div>
        </div>
    </div>
</div>
<div id="content" style="margin-top:0">
    <div class="grag1"></div>
    <div class="starInfo">
        <form  action="SingerManagementAdd" name="form" method="post" onSubmit="return add();">
        <ul>
            <li class="click"><a style="background:url(../../../static/images/main14.jpg) no-repeat right center; background-size:20px 20px;"><img src="/static/images/star1.jpg" width="25" /> &nbsp;基本信息</a></li>
          	<div class="downlLod" style="display:none;">
            	<dl>
                	<dt>歌手姓名</dt>
                    <dd>
                        <input type="text" id="textCon" name="name" class="input123" value="<?php if (!empty($singer)) echo $singer['name']?>" />
                        <input type="hidden" id="img" name="img" value="<?php if (!empty($singer)) echo $singer['img']?>"/>
                        <input type="hidden" id="uid" name="uid" value="<?php if (!empty($singer)) echo $singer['uid']?>"/>
                    </dd>
                </dl>
                <dl>
                	<dt>联系方式</dt>
                    <dd><input type="text" id="phone" name="phone" class="input123" value="<?php if (!empty($singer)){ echo $singer['phone']; }else if(empty($arr)){ echo $phone;} ?>" /></dd>
                </dl>
                <dl>
                	<dt>特殊要求</dt>
                    <dd>
                        <textarea name="special" id="special" rows="3"  style="float:left; width:100%; border:1px solid #e4e4e4; border-radius:5px; text-indent:10px;" value=""><?php if (!empty($singer)) echo $singer['special']?></textarea>
                    </dd>
                </dl>
            </div>  
        </ul>
        <div class="grag1"></div>
        <ul>
            <li class="click"><a style="background:url(../../../static/images/main14.jpg) no-repeat right center; background-size:20px 20px;"><img src="/static/images/star6.jpg" width="25" /> &nbsp;出场费用</a></li>
          	<div class="downlLod" style="display:none;">
                <dl>
                	<dt>原出场费</dt>
                    <dd style="padding-right:40px; box-sizing:border-box;"><input type="text" id="" name="history_price" class="input123" value="<?php if (!empty($singer)) echo $singer['history_price']?>" /><span style="position:absolute; z-index:11; right:0; top:10px; line-height:30px; font-size:14px;">万/场</span></dd>
                </dl>
                <dl>
                	<dt>现出场费</dt>
                    <dd style="padding-right:40px; box-sizing:border-box;"><input type="text" id="monry" name="price" class="input123" value="<?php if (!empty($singer)) echo $singer['price']?>" /><span style="position:absolute; z-index:11; right:0; top:10px; line-height:30px; font-size:14px;">万/场</span></dd>
                </dl>
            </div>  
        </ul>
        <div class="grag1"></div>
        <ul>
            <li class="click"><a style="background:url(../../../static/images/main14.jpg) no-repeat right center; background-size:20px 20px;"><img src="/static/images/star3.jpg" width="25" /> &nbsp;歌手风格</a></li>
            <div class="downlLod" style=" display:none; border-bottom:1px solid #e4e4e4; padding:10px 3%; box-sizing:border-box;">

            	<div class="li"><label><input type="checkbox" class="inputCheck" name='style[]' value="流行" <?php if(!empty($singer['style']) && in_array("流行",$singer['style'])){ echo 'checked';} ?>/> 流行</label></div>

                <div class="li"><label><input type="checkbox" class="inputCheck" name='style[]' value="R&B" <?php if(!empty($singer['style']) && in_array("R&B",$singer['style'])){ echo 'checked';} ?>/> R&B </label></div>

                <div class="li"><label><input type="checkbox" class="inputCheck" name='style[]' value="摇滚"<?php if(!empty($singer['style']) && in_array("摇滚",$singer['style'])){ echo 'checked';} ?>/> 摇滚</label></div>

                <div class="li"><label><input type="checkbox" class="inputCheck" name='style[]' value="古典"<?php if(!empty($singer['style']) && in_array("古典",$singer['style'])){ echo 'checked';} ?>/> 古典</label></div>

                <div class="li"><label><input type="checkbox" class="inputCheck" name='style[]' value="舞曲" <?php if(!empty($singer['style']) && in_array("舞曲",$singer['style'])){ echo 'checked';} ?>/> 舞曲</label></div>

                <div class="li"><label><input type="checkbox" class="inputCheck" name='style[]' value="民谣"<?php if(!empty($singer['style']) && in_array("民谣",$singer['style'])){ echo 'checked';} ?>/> 民谣</label></div>

                <div class="li"><label><input type="checkbox" class="inputCheck" name='style[]' value="中国风" <?php if(!empty($singer['style']) && in_array("中国风",$singer['style'])){ echo 'checked';} ?>/> 中国风</label></div>
            
            </div>
        <?php if(!empty($singer['uid'])){ ?>
            <li><a style="background:url(../../../static/images/main14.jpg) no-repeat right center; background-size:20px 20px;" href="date?singer=<?php if (!empty($singer)) echo $singer['uid']?>"><img src="/static/images/star5.jpg" width="25" /> &nbsp;可约档期</a></li><?php }?>
        </ul>
        <div class="gray" style="height:30px"></div>
        <div class="signOut">
            <a href="SingerManagementAdd"><input type="submit" name="submit" class="sub" value="保存歌手" /></a>
        </div>
        <?php if(!empty($singer['uid'])){ ?>
        <div class="signOut" style="margin-top:10px;">
            <a href="javascript:;" onclick="$('#Form4').fadeIn()"><input type="submit" name="submit" class="sub" value="删除歌手" /></a>
        </div>
        <?php }?>
        </form>
        <div class="grag1" style="height:30px"></div>
    </div>
    <div class="prompt1" id="Form4" style="display:none;">
                <div class="proBox">
                    <h5>温馨提示</h5><br />
                    <p>您确定要删除此歌手吗？</p>
                    <div>
                        <a href="#" ><input type="submit" value="确定" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                        <a href="javascript:;" onclick="$('#Form4').fadeOut()">取消</a>
                    </div>
                </div>
            </div>
</body>
<script>
    function onclick_check(){
        var hobby=document.getElementsByName("style[]");

        var count=0;
        for(i=0;i<hobby.length;i++){
            if(hobby[i].checked){
                count++;
            }
        }
        if(1<=count && count<=3){
            return true;
        }else{
            alert("歌手风格至少一个至多三个");
            return false;
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".click").click(function(){
            $(this).next().slideToggle();
        });
    });
</script>
<script type="text/javascript">

    $("#fileuploader0").click(function(){
        document.getElementsByClassName("img1")[0].src = "/static/images/loading.gif";
    });

    $(document).ready(function()
    {
        $("#fileuploader0").uploadFile({
            url:"http://123.57.56.133:88/img/do_upload",//文件上传url
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
                    document.getElementById('img').value = obj.results.img;
                }
            }
        })
    });
</script>
<script type="text/javascript">
    function add(){
        var valText = document.getElementById('textCon').value;
        var valPhone = document.getElementById('phone').value;
        var valMonry = document.getElementById('monry').value;
        if(valText==''){
            alert('请填写歌手姓名');
            return false;
        };
        if(valPhone==''){
            alert('请填写联系方式');
            return false;
        };
        if(valMonry==''){
            alert('请填写出场费用');
            return false;
        };
        if(!onclick_check()){
            return false;
        }else{
            return true;
        }
    }
</script>
</html>