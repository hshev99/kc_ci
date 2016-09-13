<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<title></title>
	<link href="<?php echo $base_url; ?>css/style.css" type="text/css" rel="stylesheet" />
	<script src="<?php echo $base_url; ?>js/TouchSlide.1.1.js" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/jquery-1.11.2.min.js" type="text/javascript"></script>

</head>

<body>
<div class="banner">
	<div id="focus" class="focus">
		<div class="hd">
			<ul></ul>
		</div>
		<div class="bd">
			<ul>
				<?php foreach ($img as $val){?>
				<li><a href="#"><img _src="<?php echo $val['url']; ?>" /></a></li>
				<?php }?>
			</ul>
		</div>
		<div class="topFloat">
			<a href="javascript :;" onClick="javascript :history.back(-1);">
				<img src="<?php echo $base_url; ?>images/top.png" width="12" /> 返回</a>
			<span><img src="<?php echo $base_url; ?>images/singer2.png" width="25" /></span>
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
				<img src="<?php echo $info['img']?>" width="100%" />
				<div class="posion"><img src="<?php echo $base_url; ?>images/singer6.png" /></div>
			</div>
			<div class="right">
				<div class="singerNmae">
					<span class="daimio"><?php echo $info['name']?></span>
					<span class="intro"><?php echo $info['nick']?></span>
					<div class="label">
						<?php foreach ($info['style'] as $val){?>
						<em><?php echo $val['name'];?></em>
						<?php }?>
					</div>
					<div class="Collection">
						<a href="#"><img src="<?php echo $base_url; ?>images/singer4.png" width="100%" />
							<img src="<?php echo $base_url; ?>images/singer4_1.png" width="100%" class="onImg" />
						</a>
						<a href="#"><img src="<?php echo $base_url; ?>images/singer5.png" width="100%" /></a>
					</div>
				</div>
				<div class="Price">
					<div class="money">￥<?php echo $info['price']?><span>万/场</span></div>
					<div class="company"><?php echo $info['company']?></div>
				</div>
			</div>
		</div>
	</div>

	<div class="singerInfo" style="">
		<div style="background-color:#fff;border-top:1px solid #e4e4e4; padding:10px 0; box-sizing:border-box;  color:#fa424c; font-size:14px">
			注:以艺人价格浮动周期比较频繁,此报价只做参考作用.
		</div>
	</div>

	<div class="gray"></div>
	<div class="singerInfo">
		<div class="href" style="background: none"><span>特殊要求</span>
			<div class="works" style="color:#1780d4; white-space: inherit;">
				<?php echo $introduce['music'][0]['name']?>
			</div>
		</div>
	</div>
	<div class="gray"></div>
	<div class="singerInfo">
		<div class="href"><a href="<?php echo $introduce['baike_url']?>"><span>歌手简介</span></a></div>

		<div class="href"><a href="<?php echo $introduce['music'][0]['url']?>"><span>音乐作品</span>
				<div class="works">
					<img src="<?php echo $base_url; ?>images/singer8.jpg" width="20" />
					<?php echo $introduce['music'][0]['name']?>
				</div>
			</a></div>
		<div class="href"><span>视频作品</span>
			<div class="video">
				<?php foreach ($introduce['video'] as $val){?>
				<div class="videoImg">
					<a href="<?php echo $val['url'];?>"><img src="<?php echo $val['img'];?>" width="100%" />
						<div class="play"></div></a></div>
				<?php }?>
			</div>
		</div>
	</div>
	<div class="gray"></div>
	<div class="schedule">
		<div class="schTitle">
			<span>可预约档期</span>
			<a href="#">更多</a>
		</div>
		<div class="list">
			<ul>
				<?php foreach ($on_date_defult as $val){?>
					<li class="<?php if($val['status'] == 'T') echo 'on';?>"><?php echo $val['week']?><br /><img src="<?php echo $base_url; ?>images/singer11.jpg" width="100%" />
						<div class="onEffect"><img src="<?php echo $base_url; ?>images/singer12.jpg" width="100%" /></div>
					</li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div class="gray"></div>
	<div class="comment">
		<div class="schTitle" id="star">
			<span>综合评价</span>
			<ul>
				<?php $j=5;for ($i=0;$i<$evaluation_defult['avg'];$i++){ $j--;?>
				<li class="on"><a href="javascript:;"><?php echo $i+1;?></a></li>
				<?php };
					if($j){
						for ($a=0;$a<$j;$a++){ ?>
							<li class=""><a href="javascript:;"><?php echo $i+1;?></a></li>
						<?php }
					}
				?>
			</ul>
			<a href="#">查看全部（<?php if($evaluation_defult['sum']){echo $evaluation_defult['sum'];}else{echo 0;}?>）</a>
		</div>
		<div class="list1">
			<ul>
				<?php foreach ($evaluation_defult['other'] as $val){?>
				<li>
					<div class="topName">
						<span><?php echo $val['create_time']?></span>
						<div class="userName"><?php echo $val['name']?></div>
						<div id="star1">
							<ul>
								<?php $j=5;for ($i=0;$i<$val['score'];$i++){ $j--;?>
									<li class="on"><a href="javascript:;"><?php echo $i+1;?></a></li>
								<?php };
								if($j){
									for ($a=0;$a<$j;$a++){ ?>
										<li class=""><a href="javascript:;"><?php echo $i+1;?></a></li>
									<?php }
								}
								?>
							</ul>
						</div>
					</div>
					<div class="text">
						<?php echo $val['details']?>
					</div>
				</li>
				<?php }?>

			</ul>
		</div>
		<script type="text/javascript">
		</script>
	</div>
	<div class="gray"></div>
	<div class="appointment">
		<a href="#">预约金：￥<?php echo $info['about_price']?></a>
	</div>
</div>
</body>
</html>
