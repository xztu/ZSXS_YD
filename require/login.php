<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>登陆丨在线阅档丨忻州师范学院</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="./css/app.css">
<body>

<div class="login-container">
	<h1>忻州师范学院</h1>
	
	<div class="connect">
		<p style="left: 0%;">在线阅档系统&nbsp;|&nbsp;登陆<br><br>本系统仅供内部使用</p>
	</div>
	
	<form action="index.php" method="post" id="loginForm">
		<div>
			<input type="text" id="phone" name="phone" class="phone" placeholder="手&nbsp;机&nbsp;号" autocomplete="off">
		</div>
		<div>
			<input type="password" id="password" name="password" class="password" placeholder="密&nbsp;&nbsp;码" autocomplete="off">
		</div>
		<div>
			<input type="text" id="code" name="code" class="code" placeholder="验&nbsp;证&nbsp;码" autocomplete="off" style="width:100px;margin-left:-170px;">
			<button type="button" id="getCode" class="register-tis" style="width:160px;margin-left:140px;margin-top:-44px;display:block;">发送验证码</button>
			<label id="code-error" class="error" for="code" style="display: none;"></label>
		</div>
		<button id="submit" type="submit">登&nbsp;陆</button>
	</form>
	<div style="height:30px"></div>
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
<script src="js/jquery.validate.min.js?var1.14.0"></script>
<script>
  $(function(){
   //获取短信验证码
   var validCode=true;
   $("#getCode").click (function () {
    var time=60;
    var code=$(this);
    if (validCode) {
     validCode=false;
     $.post("./sendCode.php",
    {
      phone: $("#phone").val()
    },
    function(data,status){
    	console.log('请求状态：'+status +'\n返回信息：'+data);
    	alert(data);
    });
     var t=setInterval(function () {
      time--;
      code.html(time+" 秒后重新发送");
      if (time==0) {
       clearInterval(t);
       code.html("重新发送验证码");
       validCode=true;
      }
     },1000)
    }
   })
  })
 </script>
</html>