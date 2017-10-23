/*! code by rebeta at 20170721 */


/*! 录取进程 */
function progressOnload() {
	$.post('api_ldz.php', { type: 'progress_jdt' }, function(response){
		response = JSON.parse(response);
		for (key in response){
			$("#progress").append('<div><div class="row" style="margin-bottom: -20px;width: 95%;margin-left: 10px;"><div class="pull-left">'+response[key][0]+'：</div><div class="pull-right">'+response[key][1]+'/'+response[key][2]+'</div></div><div class="row no-gutter" style="border-radius: 5px;text-align: center;margin-top: 20px;width: 95%;margin-left: 10px;'+
    'margin-bottom: 15px;border: 1px solid gray;"><div style="border-radius: 5px;background: rgba(6, 127, 228, 0.71);width:'+response[key][3]+'">'+response[key][3]+'</div></div></div>');
		}
		$.post('api_ldz.php', { type: 'progress' }, function(response){
			response ? response : response = '<h3 style="text-align:center;margin: 65% 0;">加载失败</h3>'
			$("#progress").append(response);
		})
    })
	
}

/*! 阅档-初始化-生成省份列表 */
function ydOnload() {
	$('#res').replaceWith('<div id="res"><image src="images/loading.gif" style="display: block;margin: 0 auto;padding: 45% 0;"></image></div>')
	$.post('api_ldz.php', { type: 'yd' , want:"jdt"}, function(response){
		response = JSON.parse(response);
		for (key in response){
			$("#resfront").replaceWith('<div><div class="row" style="margin-bottom: -20px;width: 95%;margin-left: 10px;"><div class="pull-left">'+response[key][0]+'：</div><div class="pull-right">'+response[key][1]+'/'+response[key][2]+'</div></div><div class="row no-gutter" style="border-radius: 5px;text-align: center;margin-top: 20px;width: 95%;margin-left: 10px;'+
    'margin-bottom: 15px;border: 1px solid gray;"><div style="border-radius: 5px;background: rgba(6, 127, 228, 0.71);width:'+response[key][3]+'">'+response[key][3]+'</div></div></div>');
		}
    })
	
	$.post('api_ldz.php', { type: 'yd' , want:"xi"}, function(response){
		response = JSON.parse(response);
		$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title">选择系</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
		for (key in response){
			$("#res_ul").append('<li class="item-content item-link ydsf" id="'+response[key].YXBMDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].YXBMMC+'</div>'+
          '<div class="item-after">'+response[key].jd+'</div>'+
        '</div>'+
      '</li>');
		}
    })
}

/*! 阅档-生成批次列表 */
$(document).on('click','.ydsf', function (e) {
	var info = e.currentTarget.id;
	$.post('api_ldz.php', {  type: 'yd' , want:"zt",  xi:info}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;->&nbsp;选择种类</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
			$("#res_ul").append('<li class="item-content item-link yyd" id="'+info+'|'+response[0][0]+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[0][0]+'</div>'+
          '<div class="item-after">'+response[0][1]+'</div>'+
        '</div>'+
      '</li>');
			$("#res_ul").append('<li class="item-content item-link wyd" id="'+info+'|'+response[1][0]+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[1][0]+'</div>'+
          '<div class="item-after">'+response[1][1]+'</div>'+
        '</div>'+
      '</li>');
		} else {
			$.alert('加载失败,请稍后再试！');
			return ;
		}
	})
});

/*! 阅档-生成科类列表 */
$(document).on('click','.yyd', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api_ldz.php', {  type: 'yd' , want:"yyd",  xi:res[0], lb:res[1]}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;->&nbsp;已阅档列表</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
			for (key in response){
			$("#res_ul").append('<li class="item-content item-link yydres" id="'+info+'|'+response[key].Id+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].SFMC+response[key].PCMC+response[key].KLMC+'</div>'+
          '<div class="item-after"></div>'+
        '</div>'+
      '</li>');
			}
		} else {
			$.alert('加载失败,请稍后再试！');
			return ;
		}
	})
});

/*! 阅档-生成科类列表 */
$(document).on('click','.wyd', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api_ldz.php', {  type: 'yd' , want:"wyd",  xi:res[0], lb:res[1]}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;->&nbsp;未阅档列表</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
			for (key in response){
			$("#res_ul").append('<li class="item-content" id="'+info+'|'+response[key].KLDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].SYSSMC+'-'+response[key].PCMC+'-'+response[key].KLMC+'</div>'+
          '<div class="item-after">'+response[key].RS+'人</div>'+
        '</div>'+
      '</li>');
			}
		} else {
			$.alert('加载失败,请稍后再试！');
			return ;
		}
	})
});

/*! 阅档-查看考生详细信息 */
$(document).on('click','.yydres', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api_ldz.php', {  type: 'yd' , want:"yydres",  drop:res[0], id:res[2]}, function(response){
		if(response){
			response = JSON.parse(response);
			var popupHTML = '<div class="popup">'+
                    '<div class="content-block">'+
						                      '<p style="width:95%;text-align:right;"><a href="#" class="close-popup">关闭</a></p>'+
											  '<H1 style="text-align:center;">'+response.Xi+'</H1>'+
											  '<h3 style="text-align:center;margin-top:-1rem;">'+response.Time+'</h3>'+
											  '<div class="content-block-title">详细信息</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">省份</div>'+
          '<div class="item-after">'+response.SFMC+'</div>'+
        '</div>'+
      '</li>'+
	  '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">批次</div>'+
          '<div class="item-after">'+response.PCMC+'</div>'+
        '</div>'+
      '</li>'+
	  '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">科类</div>'+
          '<div class="item-after">'+response.KLMC+'</div>'+
        '</div>'+
      '</li>'+
	  '<li class="align-top"><div class="item-content">'+
          '<div class="item-inner"><div class="item-title label">阅档意见</div><div class="item-input"><textarea disabled="disabled">'+response.YDYJ+'</textarea></div></div></div></li>'
    popupHTML += '</ul>'+
  '</div>'+
                    '</div>'+
                  '</div>'
				  	$.popup(popupHTML);
		} else {
			$.alert('加载失败,请稍后再试！');
			return ;
		}
	})
});


/*! 我的信息 */
function myOnload() {
	$('#myres').replaceWith('<div id="myres"><image src="images/loading.gif" style="display: block;margin: 0 auto;padding: 38% 0;"></image></div>')
	$.post('api.php', { type: 'my' }, function(response){
		response = JSON.parse(response);
		$('#myres').replaceWith('<div id="myres">'+
  '<div style="margin-top: 15px;">'+
	'<img src="images/user/user.jpg" style="width: 25%;display: block;margin: 0 auto;border: 2px solid #e7e7e7;border-radius: 50%;-webkit-border-radius: 50%;-moz-border-radius: 50%;">'+
	'</div>'+
'<div class="content-block-title">当前状态：正常</div>'+
  '<div class="list-block">'+
    '<ul>'+
      '<li class="item-content">'+
        '<div class="item-media"><i class="icon icon-me"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">用户名</div>'+
          '<div class="item-after">'+response.phone+'</div>'+
        '</div>'+
      '</li>'+
      '<li class="item-content">'+
        '<div class="item-media"><i class="icon icon-card"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">姓&nbsp;名</div>'+
          '<div class="item-after">'+response.name+'</div>'+
        '</div>'+
      '</li>'+
'<li class="item-content">'+
        '<div class="item-media"><i class="icon icon-share"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">用户身份</div>'+
          '<div class="item-after">'+response.department+'</div>'+
        '</div>'+
      '</li>'+
'<li class="item-content">'+
        '<div class="item-media"><i class="icon icon-clock"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">登录时间</div>'+
           '<div class="item-after">'+response.last+'</div>'+
        '</div>'+
      '</li>'+
'<li class="item-content item-link update">'+
        '<div class="item-media"><i class="icon icon-refresh"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">更新</div>'+
           '<div class="item-after">Update_20170803</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
'</div>')
    })
}

/*! 我的信息-查看更新内容 */
$(document).on('click','.update', function (e) {
	var popupHTML = '<div class="popup">'+
                    '<div class="content-block">'+
						                      '<p style="width:95%;text-align:right;"><a href="#" class="close-popup">关闭</a></p>'+
											  '<H1 style="text-align:center;">更新内容</H1>'+
											  '<h3 style="text-align:center;margin-top:-1rem;">Update_20170803</h3>'+
	'<div class="content-block-title">APP版本 Ver_1.1(Update_20170803)</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">新增</div>'+
          '<div class="item-after">进度条</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
	'<div class="content-block-title">API版本 Ver_1.1(Update_20170802)</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">新增</div>'+
          '<div class="item-after">进度条</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
  '<div class="content-block-title">APP版本 Ver_1.0(Update_20170801)</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">更新</div>'+
          '<div class="item-after">第一版</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
                    '</div>'+
                  '</div>'
				  	$.popup(popupHTML);
});
