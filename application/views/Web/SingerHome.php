<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title></title>
    <link href="<?php echo $css; ?>css/style.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo $css; ?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css; ?>js/jquery-1.11.2.min.js" type="text/javascript"></script>

</head>

<body>
<div class="banner">
    <div id="focus" class="focus">
        <div class="hd">
            <ul></ul>
        </div>
        <div class="bd">
            <ul>
                <?php if (!empty($img)){foreach ($img as $val){?>
                    <li><a href="#"><img _src="<?php echo $val['url']; ?>" /></a></li>
                <?php }}else{?>
                    <li><a href="#"><img _src="<?php echo $css;?>images/banner.jpg" /></a></li>
                <?php }?>
            </ul>
        </div>
        <div class="topFloat">
            <a href="javascript:history.go(-1);">
                <img src="<?php echo $css; ?>images/top.png" width="12" /> 返回</a>
            <span href="javascript:;" onclick="$('#fixed_phone').fadeIn()"><img src="<?php echo $css; ?>images/singer2.png" width="25" /></span>
        </div>
    </div>
    <script type="text/javascript">
        TouchSlide({
            slideCell:"#focus",
            titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
            mainCell:".bd ul",
            effect:"left",
            autoPlay:true,//自动播放
            autoPage:true, //自动分页
            switchLoad:"_src" //切换加载，真实图片路径为"_src"
        });
    </script>
</div>
<div id="content" style="margin-top:0">
    <div class="info">
        <div class="BasicInfo">
            <div class="hearImg">
                <img src="<?php echo empty($info['img']) ? '/static/images/head_default_min.png':$info['img']?>" width="100%" />
                <div class="posion"><img src="<?php echo $css; ?>images/singer6.png" /></div>
            </div>
            <div class="right">
                <div class="singerNmae">
                    <span style="font-size:16px;"><?php echo $info['name']?></span>
                    <span style="font-size:12px;"><?php echo $info['nick']?></span>
                    <div class="label">
                        <?php foreach ($info['style'] as $val){?>
                            <em><?php echo $val['name'];?></em>
                        <?php }?>
                    </div>
                    <div class="Collection">
                        <a id="coll" style="float:right;"><img src="<?php echo $css; ?>images/singer4.png" width="100%" />
                            <img src="<?php echo $css; ?>images/singer4_1.png" width="100%" class="onImg" />
                        </a>
                    </div>
                    <script>
                    	$(function(){
							var $img =$('.Collection a');
							var collection= "<?php echo $info['collection']?>";
							var fans = "<?php echo $info['uid']?>";
							// var uid = "<?php echo @$login_uid?>";
                            var uid = "<?php $_SESSION['user_login']['uid']?>";
							if(collection == 'T'){
								$("#coll").attr('class','on');
								}else if(collection == 'F'){
									$("#coll").attr('class','');
									};
							
							
							
							$img.click(function(){
								if(collection=='L'){
									alert('请登录');
									return false;
									};
									
								if(collection=='F'){
									setTimeout(function(){
										$.ajax({
										type:'POST',
										data:{fans:fans},
										url:'../userfocus/save_fans?uid='+uid,
										dateType:'json',
										success:function(data){
										  var jsonobj=eval('('+data+')');
										  console.log(jsonobj.results);	
										}
										});
										},200);
										};	
									var ing =$(this).attr('class');
									if(ing == undefined || ing == ''){
										$(this).attr('class','on');
										}else{
											$(this).attr('class','');
											};
								});
							})
                    </script>
                </div>
                <div class="Price">
                    <div class="money">￥<?php echo $info['price']?><span>万/场</span><s style="font-size:12px; color:#999; margin-left:5px;"><?php if ($info['history_price']) echo "￥{$info['history_price']}万/场";?></s></div>
                    
                    <!--<div id="nameInfo" class="company"><?php echo $info['company']?></div>-->
                    <!--<script>
                    	var inFo =document.getElementById('nameInfo');
						if(inFo.innerHTML==""){
							inFo.style.display="none";
							}
                    </script>-->
                </div>
            </div>
        </div>
    </div>

    <div class="singerInfo" style="">
        <div style="background-color:#fff;border-top:1px solid #e4e4e4; padding:10px 0; box-sizing:border-box;  color:#fa424c; font-size:14px">
            注：<strong style="color:#fa424c">[不含税费]</strong>如艺人档期紧凑，价格会略有浮动。
        </div>
    </div>

    <div class="gray"></div>

    <?php if (!empty($info['special'])){?>
    <div class="singerInfo">
        <div class="href" style="background: none"><span>特殊要求</span>
            <div class="works" style="color:#1780d4; white-space: inherit;">
                <?php echo empty($info['special']) ? '': $info['special']?>
            </div>
        </div>
    </div>
    <div class="gray"></div>
    <?php }?>

    <div class="singerInfo">
        <div class="href"><a href="<?php echo $introduce['baike_url']?>"><span>歌手简介</span></a></div>

        <div class="href"><a href="<?php echo 'music?uid='.$info['uid']?>"><span>音乐作品</span>
                <div class="works">
                    <img src="<?php echo $css; ?>images/singer8.jpg" width="20" />
                    <?php echo empty($introduce['music'][0]['name']) ? '' :$introduce['music'][0]['name']?>
                </div>
            </a></div>
        <div class="href"><span>视频作品</span>
            <div class="video">
                <?php if (!empty($introduce['video']))foreach ($introduce['video'] as $key=>$val){if ($key <3){?>
                    <div class="videoImg">
                        <a href="<?php echo 'video?uid='.$info['uid']?>"><img src="<?php echo $val['img'];?>" width="100%" />
                            <div class="play"></div></a></div>
                <?php }}?>
            </div>
        </div>
    </div>
    <div class="gray"></div>
    <div class="schedule">
        <div class="schTitle">
            <span>可预约档期</span>
            <a href="noDate?singer=<?php echo $info['uid'] ?>">更多</a>
        </div>
        <div class="list">
            <ul>
                <a href="noDate?singer=<?php echo $info['uid'] ?>"><?php foreach ($on_date_defult as $val){?>
                    <li class="<?php if($val['status'] == 'T') echo 'on';?>"><?php echo $val['week']?><br /><img src="<?php echo $css; ?>images/singer11.jpg" width="100%" />
                        <div class="onEffect"><img src="<?php echo $css; ?>images/singer12.jpg" width="100%" /></div>
                        <p style="color:#333333"><?php echo $val['date']?></p>
                    </li>
                <?php }?></a>
            </ul>
        </div>
    </div>
    <div class="gray"></div>
    <div class="appointment">
        <a href="submit?worker_uid=<?php echo $info['uid']?>">立即预约</a>
    </div>
</div>
<div class="fixed_phone" id="fixed_phone" style=" display:none;position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,.3)">
	<div style="margin:0 auto; width:70%;">
    	<div style="float:left; width:100%; background-color:#fff; text-align:center; line-height:40px; color:#000; font-size:16px; border-radius:5px; margin-top:20%; position:relative;"><a href="tel:+86-13718077670">客服电话：+86-13718077670</a>
        	<div href="javascript:;" onclick="$('#fixed_phone').fadeOut()" style="position:absolute; z-index:11; right:-10px; top:-10px; width:30px; height:30px;"><img src="/static/images/close21.png" width="100%" /></div>
        </div>
    </div>
</div>
</body>
</html>
