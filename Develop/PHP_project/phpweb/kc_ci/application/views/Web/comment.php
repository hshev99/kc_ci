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
    <script type="text/javascript" src="<?php echo $css?>js/script.js"></script>

</head>

<body>
<div id="header">
    <div class="top">
        <div class="title">
            评论
            <div class="return"><a href="javascript :;" onClick="javascript :history.back(-1);"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="commmet">
        <div class="beCom">
            <img src="<?php echo $css?>images/comment1.jpg" /><br />
            人声兄弟
        </div>
        <div id="xzw_starSys">
            <div id="xzw_starBox">
                <ul class="star" id="star">
                    <li><a href="javascript:void(0)" title="1" class="one-star">1</a></li>
                    <li><a href="javascript:void(0)" title="2" class="two-stars">2</a></li>
                    <li><a href="javascript:void(0)" title="3" class="three-stars">3</a></li>
                    <li><a href="javascript:void(0)" title="4" class="four-stars">4</a></li>
                    <li><a href="javascript:void(0)" title="5" class="five-stars">5</a></li>
                </ul>
                <div class="current-rating" id="showb"></div>
            </div>
            <!--评价文字-->
            <div class="description">点击星星就可以评论了</div>
        </div>
        <div class="Mark">
            <div class="quiz_content">
                <form action="" id="" method="post">
                    <div class="l_text">
                        <textarea name="" id="" class="text" placeholder="您如果还有其它建议或意见，请放心填写"></textarea>
                        <span class="tr">
                        	<input type="checkbox" name="a" id="checkbox-1-2" checked="">
                        	<label for="checkbox-1-2"></label>
                            <font>匿名评论</font>
                        </span>
                    </div>
                    <button class="btm" type="submit" value="提交">提交</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
