/*! code by rebeta at 20170721 */


/*! 阅档-初始化-生成省份列表 */
function ydOnload() {
	$('#res').replaceWith('<div id="res"><image src="images/loading.gif" style="display: block;margin: 0 auto;padding: 45% 0;"></image></div>')
	$.post('api.php', { type: 'yd' , want:"sf"}, function(response){
		response = JSON.parse(response);
		$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title">选择省份</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
		for (key in response){
			$("#res_ul").append('<li class="item-content item-link ydsf" id="'+response[key].SYSSDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].SYSSMC+'</div>'+
          '<div class="item-after"></div>'+
        '</div>'+
      '</li>');
		}
    })
}

/*! 阅档-生成批次列表 */
$(document).on('click','.ydsf', function (e) {
	var info = e.currentTarget.id;
	$.post('api.php', {  type: 'yd' , want:"pc",  sf:info}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;选择批次</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
			for (key in response){
			$("#res_ul").append('<li class="item-content item-link ydpc" id="'+info+'|'+response[key].PCDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].PCMC+'</div>'+
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
$(document).on('click','.ydpc', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api.php', {  type: 'yd' , want:"kl",  sf:res[0], pc:res[1]}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;选择科类</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
			for (key in response){
			$("#res_ul").append('<li class="item-content item-link ydkl" id="'+info+'|'+response[key].KLDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].KLMC+'</div>'+
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

/*! 阅档-生成考生列表 */
$(document).on('click','.ydkl', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api.php', {  type: 'yd' , want:"res",  sf:res[0], pc:res[1], kl:res[2]}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#res').replaceWith('<div id="res" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;查看考生名单</div><div class="list-block"><ul id="res_ul"></ul></div></div>')
			for (key in response){
			$("#res_ul").append('<li class="item-content item-link ydallres" id="'+response[key].KSH+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].XM+'</div>'+
          '<div class="item-after">'+response[key].CJ+'分</div>'+
        '</div>'+
      '</li>');
			}
			$("#res").append('<div class="content-padded" style="margin-top: -15px;"><h4>阅档意见</h4><br><textarea id="ydyj" style="margin-top: -35px; width: 100%; height: 5rem;resize: none;" placeholder="请填写阅档意见"></textarea>'+
			'<div><button type="button" id="'+info+'" class="button-bl ydyj">&gt; 提交数据 &lt;</button></div></div>')
			} else {
			$.alert('加载失败,请稍后再试！');
			return ;
		}
	})
});

/*! 阅档-查看考生详细信息 */
$(document).on('click','.ydallres', function (e) {
	var info = e.currentTarget.id;
	$.post('api.php', { type: 'yd', want:"ksres", ksh: info }, function(response){
		if(response){
			response = JSON.parse(response);
			var popupHTML = '<div class="popup">'+
                    '<div class="content-block">'+
						                      '<p style="width:95%;text-align:right;"><a href="#" class="close-popup">关闭</a></p>'+
											  '<H1 style="text-align:center;">'+response.XM+'</H1>'+
											  '<h3 style="text-align:center;margin-top:-1rem;">'+response.ZYMC+'</h3>'+
											  '<img id="user_watermark_pop" height="100" style="position:fixed; top: 15rem;z-index: 9999;pointer-events: none;opacity: 0.25; transform: rotate(-45deg);" src="http://hostname/images/user_watermark/'+response.phone+'.png">'+
                      '<div class="content-block-title">详细信息</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">性别</div>'+
          '<div class="item-after">'+response.XBMC+'</div>'+
        '</div>'+
      '</li>'+
	  	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">民族</div>'+
          '<div class="item-after">'+response.MZMC+'</div>'+
        '</div>'+
      '</li>'+
	  	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">政治面貌</div>'+
          '<div class="item-after">'+response.ZZMMMC+'</div>'+
        '</div>'+
      '</li>'+
	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">出生日期</div>'+
          '<div class="item-after">'+response.CSNY+'</div>'+
        '</div>'+
      '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">录取方式</div>'+
          '<div class="item-after">'+response.LQFSMC+'</div>'+
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
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">生源地</div>'+
          '<div class="item-after">'+response.DQMC+'</div>'+
        '</div>'+
	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">总分</div>'+
          '<div class="item-after">'+response.CJ+'</div></div></li>'
	  if(response.GKCJX07 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">专业成绩</div>'+
          '<div class="item-after">'+response.GKCJX07+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX01 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">语文</div>'+
          '<div class="item-after">'+response.GKCJX01+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX02 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">数学</div>'+
          '<div class="item-after">'+response.GKCJX02+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX03 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">外语</div>'+
          '<div class="item-after">'+response.GKCJX03+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX04 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">综合</div>'+
          '<div class="item-after">'+response.GKCJX04+'</div>'+
        '</div>'+
      '</li>'
	  }
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

/*! 阅档-初始化-提交数据 */
$(document).on('click','.ydyj', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api.php', { type: 'yd' , want:"submit",  sf:res[0], pc:res[1], kl:res[2] ,ydyj:$('#ydyj').val()}, function(response){
		alert(response)
		ydOnload()
    })
});


/*! 阅档历史-初始化-生成省份列表 */
function ydallOnload() {
	$('#resall').replaceWith('<div id="resall"><image src="images/loading.gif" style="display: block;margin: 0 auto;padding: 45% 0;"></image></div>')
	$.post('api.php', { type: 'ydall' , want:"sf"}, function(response){
		response = JSON.parse(response);
		$('#resall').replaceWith('<div id="resall" style="min-height: 15rem;"><div class="content-block-title">选择省份</div><div class="list-block"><ul id="resall_ul"></ul></div></div>')
		for (key in response){
			$("#resall_ul").append('<li class="item-content item-link sf" id="'+response[key].SYSSDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].SYSSMC+'</div>'+
          '<div class="item-after"></div>'+
        '</div>'+
      '</li>');
		}
    })
}

/*! 阅档历史-生成批次列表 */
$(document).on('click','.sf', function (e) {
	var info = e.currentTarget.id;
	$.post('api.php', {  type: 'ydall' , want:"pc",  sf:info}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#resall').replaceWith('<div id="resall" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydallOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;选择批次</div><div class="list-block"><ul id="resall_ul"></ul></div></div>')
			for (key in response){
			$("#resall_ul").append('<li class="item-content item-link pc" id="'+info+'|'+response[key].PCDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].PCMC+'</div>'+
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

/*! 阅档历史-生成科类列表 */
$(document).on('click','.pc', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api.php', {  type: 'ydall' , want:"kl",  sf:res[0], pc:res[1]}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#resall').replaceWith('<div id="resall" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydallOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;选择科类</div><div class="list-block"><ul id="resall_ul"></ul></div></div>')
			for (key in response){
			$("#resall_ul").append('<li class="item-content item-link kl" id="'+info+'|'+response[key].KLDM+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].KLMC+'</div>'+
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

/*! 阅档历史-生成考生列表 */
$(document).on('click','.kl', function (e) {
	var info = e.currentTarget.id;
	var res = info.split("|");
	$.post('api.php', {  type: 'ydall' , want:"res",  sf:res[0], pc:res[1], kl:res[2]}, function(response){
		if(response){
			response = JSON.parse(response);
			$('#resall').replaceWith('<div id="resall" style="min-height: 15rem;"><div class="content-block-title"><a onclick="ydallOnload()">&lt; 返回</a>&nbsp;&nbsp;&nbsp;查看考生名单</div><div class="list-block"><ul id="resall_ul"></ul></div></div>')
			var i = 0
			for (key in response){
				i++
			}
			for (key in response){
				if(i<3){
					break
				}else{
					i--
				}
			$("#resall_ul").append('<li class="item-content item-link allres" id="'+response[key].KSH+'">'+
        '<div class="item-media"><i class="icon icon-f7"></i></div>'+
        '<div class="item-inner">'+
          '<div class="item-title">'+response[key].XM+'</div>'+
          '<div class="item-after">'+response[key].CJ+'分</div>'+
        '</div>'+
      '</li>');
			}
			$("#resall_ul").append('<li class="align-top"><div class="item-content"><div class="item-media"><i class="icon icon-form-comment"></i></div>'+
          '<div class="item-inner"><div class="item-title label">阅档意见</div><div class="item-input"><textarea disabled="disabled">'+response.YDYJ+'</textarea></div></div></div></li>');
			$("#resall_ul").append('<li class="align-top"><div class="item-content"><div class="item-media"><i class="icon icon-form-comment"></i></div>'+
          '<div class="item-inner"><div class="item-title label">意见回复</div><div class="item-input"><textarea disabled="disabled">'+(response.ZBHF ? response.ZBHF : '')+'</textarea></div></div></div></li>');
		} else {
			$.alert('加载失败,请稍后再试！');
			return ;
		}
	})
});

/*! 阅档历史-查看考生详细信息 */
$(document).on('click','.allres', function (e) {
	var info = e.currentTarget.id;
	$.post('api.php', { type: 'ydall', want:"ksres", ksh: info }, function(response){
		if(response){
			response = JSON.parse(response);
			var popupHTML = '<div class="popup">'+
                    '<div class="content-block">'+
						                      '<p style="width:95%;text-align:right;"><a href="#" class="close-popup">关闭</a></p>'+
											  '<H1 style="text-align:center;">'+response.XM+'</H1>'+
											  '<h3 style="text-align:center;margin-top:-1rem;">'+response.ZYMC+'</h3>'+
					'<img id="user_watermark_pop_1" height="100" style="position:fixed; top: 15rem;z-index: 9999;pointer-events: none;opacity: 0.25; transform: rotate(-45deg);" src="http://hostname/images/user_watermark/'+response.phone+'.png">'+
                      '<div class="content-block-title">详细信息</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">性别</div>'+
          '<div class="item-after">'+response.XBMC+'</div>'+
        '</div>'+
      '</li>'+
	  	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">民族</div>'+
          '<div class="item-after">'+response.MZMC+'</div>'+
        '</div>'+
      '</li>'+
	  	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">政治面貌</div>'+
          '<div class="item-after">'+response.ZZMMMC+'</div>'+
        '</div>'+
      '</li>'+
	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">出生日期</div>'+
          '<div class="item-after">'+response.CSNY+'</div>'+
        '</div>'+
      '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">录取方式</div>'+
          '<div class="item-after">'+response.LQFSMC+'</div>'+
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
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">生源地</div>'+
          '<div class="item-after">'+response.DQMC+'</div>'+
        '</div>'+
      '</li>'+
	'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">总分</div>'+
          '<div class="item-after">'+response.CJ+'</div></div></li>'
	  if(response.GKCJX07 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">专业成绩</div>'+
          '<div class="item-after">'+response.GKCJX07+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX01 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">语文</div>'+
          '<div class="item-after">'+response.GKCJX01+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX02 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">数学</div>'+
          '<div class="item-after">'+response.GKCJX02+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX03 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">外语</div>'+
          '<div class="item-after">'+response.GKCJX03+'</div>'+
        '</div>'+
      '</li>'
	  }
	  if(response.GKCJX04 > 20){
		 popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">综合</div>'+
          '<div class="item-after">'+response.GKCJX04+'</div>'+
        '</div>'+
      '</li>'
	  }
    popupHTML += '<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">阅档时间</div>'+
          '<div class="item-after">'+response.YDSJ+'</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
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
          '<div class="item-title">所在系</div>'+
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
           '<div class="item-after">Update_20170729</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
'</div>')
	$('#user_watermark').attr('src', 'images/user_watermark/'+response.phone+'.png');
	$('#user_watermark_1').attr('src', 'http://hostname/images/user_watermark/'+response.phone+'.png');
    })
}

/*! 我的信息-查看更新内容 */
$(document).on('click','.update', function (e) {
	var popupHTML = '<div class="popup">'+
                    '<div class="content-block">'+
						                      '<p style="width:95%;text-align:right;"><a href="#" class="close-popup">关闭</a></p>'+
											  '<H1 style="text-align:center;">更新内容</H1>'+
											  '<h3 style="text-align:center;margin-top:-1rem;">Update_20170729</h3>'+
  '<div class="content-block-title">APP版本 Ver_1.2(Update_20170729)</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">调整</div>'+
          '<div class="item-after">阅档-单科目成绩</div>'+
        '</div>'+
      '</li>'+
	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">调整</div>'+
          '<div class="item-after">我的信息-更新</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
  '<div class="content-block-title">APP版本 Ver_1.1(Update_20170727)</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">新增</div>'+
          '<div class="item-after">阅档-单科目成绩</div>'+
        '</div>'+
      '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">新增</div>'+
          '<div class="item-after">我的信息-更新时间</div>'+
        '</div>'+
      '</li>'+
	  	  '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">新增</div>'+
          '<div class="item-after">我的信息-更新内容</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
  '<div class="content-block-title">API 版本 Ver_1.3(Update_20170727)</div>'+
  '<div class="list-block">'+
		'<ul>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">调整</div>'+
          '<div class="item-after">科类列表</div>'+
        '</div>'+
      '</li>'+
		'<li class="item-content">'+
        '<div class="item-inner">'+
          '<div class="item-title">调整</div>'+
          '<div class="item-after">省份列表</div>'+
        '</div>'+
      '</li>'+
    '</ul>'+
  '</div>'+
                    '</div>'+
                  '</div>'
				  	$.popup(popupHTML);
});
