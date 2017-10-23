<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>使用须知丨在线阅档丨忻州师范学院</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="./css/app.css">
<body>
<div class="login-container">
	<h1>忻州师范学院</h1>
	
	<div class="connect">
		<p style="left: 0%;">在线阅档系统&nbsp;|&nbsp;使用须知<br><br>本系统仅供内部使用</p>
	</div>
	
	<form action="index.php" method="post" id="loginForm" novalidate="novalidate">
		<div style="height:235px;border: 1px solid rgba(255, 255, 255, 0.38);background: rgba(45, 45, 45, 0.15);">
			<div style="margin-top:20px;">使用须知</div>
			<div style="margin-top:20px;margin-left:12px;width:95%;font-size: 90%;text-align:left;text-indent:1.5rem;">1.注意保密，系统内各类数据严禁复制、截图、对外传播。</div>
			<div style="margin-top:20px;margin-left:12px;width:95%;font-size: 90%;text-align:left;text-indent:1.5rem;">2.请勿使用公共场所的无线网络登陆或使用他人设备登陆。</div>
			<div style="margin-top:20px;margin-left:12px;width:95%;font-size: 90%;text-align:left;text-indent:1.5rem;">3.每次使用完毕后及时退出登陆。</div>
			<div style="display:none;"><input type="text" id="confirm" name="confirm" class="confirm" value="confirm"></div>
			<div><input name="checkbox" type="checkbox" value="同意并继续" style="width:20px;height:20px;margin-left:-110px;"><div style="margin-top:-20px;">我&nbsp;知&nbsp;道&nbsp;了</div></div> 
		</div>
		<button id="submit" type="submit">同意并继续</button>
	</form>
	<div style="margin-top:10px;">
		<button type="button" id="logout" class="register-tis">> 退出登录 <</button>
	</div>
	<div id="end" style="height:30px"></div>
	<div class="footer">
		<div class="footer-zsxs">
			<image src=".images/logo-icon-w.png"></image>
			<p>掌上忻师</p>
		</div>
		<div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
		<div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div>
	</div>
</div>
</body>
<script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
<script src="js/common.js"></script>
<!--背景图片自动更换-->
<!--
<script src="js/supersized.3.2.7.min.js"></script>
<script src="js/supersized-init.js"></script>
-->
<!--表单验证-->
<script src="js/jquery.validate.min.js?var1.14.0"></script>
 <script>
  $(function(){
   $("#logout").click (function () {
    $.post("./logout.php",{},function(data){$("#end").html(data);});
    })
  })
 </script>
</html>