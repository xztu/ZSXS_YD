//打开字滑入效果
window.onload = function(){
	$(".connect p").eq(0).animate({"left":"0%"}, 600);
	$(".connect p").eq(1).animate({"left":"0%"}, 400);
};
//jquery.validate表单验证
$(document).ready(function(){
	//登陆表单验证
	$("#loginForm").validate({
		rules:{
			phone:{
				required:true,
				phone_number:true,//自定义的规则
				digits:true,//整数
			},
			password:{
				required:true,
				minlength:4,
				maxlength:18,
			},
			code:{
				required:true,
				minlength:4, 
				maxlength:4,
			},
		},
		//错误信息提示
		messages:{
			phone:{
				required:"请输入手机号码",
				digits:"请输入正确的手机号码",
			},
			password:{
				required:"必须填写密码",
				minlength:"用户名至少为4个字符",
				maxlength:"用户名至多为18个字符",
				remote: "用户名已存在",
			},
			code:{
				required:"必须填写密码",
				minlength:"密码至少为4个字符",
				maxlength:"密码至多为4个字符",
			},
		},

	});
	//添加自定义验证规则
	jQuery.validator.addMethod("phone_number", function(value, element) { 
		var length = value.length; 
		var phone_number = /^((1)+\d{10})$/ 
		return this.optional(element) || (length == 11 && phone_number.test(value)); 
	}, "手机号码格式错误"); 
});
