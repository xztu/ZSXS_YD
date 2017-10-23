<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>忻州师范学院</title>
	<meta name="keywords" content="忻州师范学院 忻州师院" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="./favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="./css/sm.min.css">
    <link rel="stylesheet" href="./css/sm-extend.min.css">
	<link rel="stylesheet" href="./css/app.css">
	<script type='text/javascript' src='./js/zepto.min.js' charset='utf-8'></script>
	<!--<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>-->
	<script type='text/javascript' src='./js/app.js' charset='utf-8'></script>
  </head>
  <body>
    <div class="page-group">
		<!-- 第一页开始 -->
        <div class="page page-current" id="yd">
		<div id="bottomnav" style="position:fixed; top: 10rem;z-index: 9999;pointer-events: none;">
			<img id="user_watermark" height="100" style="opacity: 0.25; transform: rotate(-45deg);" src="http://y.xzsyzjc.cn/images/user_watermark/default.png">
		</div>
			<header class="bar bar-nav">
				<h1 class="title">在线阅档</h1>
			</header>
			<nav class="bar bar-tab">
				<a class="tab-item active" href="#yd">
					<span class="icon icon-star"></span>
					<span class="tab-label">在线阅档</span>
				</a>
				<a class="tab-item" href="#ydall">
					<span class="icon icon-edit"></span>
					<span class="tab-label">阅档历史</span>
				</a>
				<a class="tab-item" href="#my">
					<span class="icon icon-home"></span>
					<span class="tab-label">我的信息</span>
				</a>
			</nav>
			<div class="content">
			<!-- 这里是页面内容区 -->
				<div class="content">
					<div id="res" style="min-height: 15rem;"></div>
					<div class="footer gl">
						<div class="footer-zsxs">
							<image src=".images/logo-icon-gl.png"></image>
							<p>掌上忻师</p>
						</div>
						<div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
						<div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div>
					</div>
				</div>
				<script>
					ydOnload();
				</script>
			<!-- 这里是页面内容区 -->
			</div>
        </div>
		<!-- 第一页结束 -->
		<!-- 第二页开始 -->
		<div class="page" id="ydall">
		<div id="bottomnav" style="position:fixed; top: 10rem;z-index: 9999;pointer-events: none;">
			<img id="user_watermark_1" height="100" style="opacity: 0.25; transform: rotate(-45deg);" src="http://y.xzsyzjc.cn/images/user_watermark/default.png">
		</div>
			<header class="bar bar-nav">
				<a class="button button-link button-nav pull-left back">
					<span class="icon icon-left"></span>
					返回
				</a>
				<h1 class="title">阅档历史</h1>
			</header>
			<nav class="bar bar-tab">
				<a class="tab-item" href="#yd">
					<span class="icon icon-star"></span>
					<span class="tab-label">在线阅档</span>
				</a>
				<a class="tab-item active" href="#ydall">
					<span class="icon icon-edit"></span>
					<span class="tab-label">阅档历史</span>
				</a>
				<a class="tab-item" href="#my">
					<span class="icon icon-home"></span>
					<span class="tab-label">我的信息</span>
				</a>
			</nav>
			<div class="content">
			<!-- 这里是页面内容区 -->
				<div class="content native-scroll">
					<div id="resall" style="min-height: 15rem;"></div>
					<div class="footer gl">
						<div class="footer-zsxs">
							<image src=".images/logo-icon-gl.png"></image>
							<p>掌上忻师</p>
						</div>
						<div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
						<div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div>
					</div>
				</div>
				<script>
					ydallOnload();
				</script>
			<!-- 这里是页面内容区 -->
			</div>
		</div>
		<!-- 第二页结束 -->
		<!-- 第三页开始 -->
		<div class="page" id="my">
			<header class="bar bar-nav">
				<a class="button button-link button-nav pull-left back">
					<span class="icon icon-left"></span>
					返回
				</a>
				<h1 class="title">我的信息</h1>
			</header>
			<nav class="bar bar-tab">
				<a class="tab-item" href="#yd">
					<span class="icon icon-star"></span>
					<span class="tab-label">在线阅档</span>
				</a>
				<a class="tab-item" href="#ydall">
					<span class="icon icon-edit"></span>
					<span class="tab-label">阅档历史</span>
				</a>
				<a class="tab-item active" href="#my">
					<span class="icon icon-home"></span>
					<span class="tab-label">我的信息</span>
				</a>
			</nav>
			<div class="content">
			<!-- 这里是页面内容区 -->
				<div class="content">
					<div id="myres"></div>
					<div>
						<button type="button" id="logout" class="button-gl">&gt; 退出登录 &lt;</button>
					</div>
					<div id="end" style="height:30px"></div>
					<div class="footer gl">
						<div class="footer-zsxs">
							<image src=".images/logo-icon-gl.png"></image>
							<p>掌上忻师</p>
						</div>
						<div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
						<div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div>
					</div>
				</div>
				<script>
					//加载页面
					myOnload();
					$(document).ready(function() {
						$("#logout").click (function () {
							$.post("./logout.php",{},function(data){$("#end").html(data);});
						})
					})
				</script>
			<!-- 这里是页面内容区 -->
			</div>
		</div>
		<!-- 第三页结束 -->
        </div>
    </div>
    <script type='text/javascript' src='./js/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='./js/sm-extend.min.js' charset='utf-8'></script>
  </body>
</html>