<?php
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170614
 *
 */

//1开启session
session_start();


//**保存日志**
if(is_numeric($_SESSION["phone"]) && (strlen($_SESSION["phone"] != 11))){
	require_once 'public.php';
	$pdo = new DataBase;
	$db = $pdo->mysqlconn();
	$sql = "INSERT INTO yd_log (`datetime`, `type`, `user`) VALUES ('".date("Y/m/d H:i:s")."','退出','".$_SESSION["phone"]."')";
	$rs = $db->exec($sql);
}

//2、清空session信息
$_SESSION = array();
  
//3、清楚客户端sessionid
if(isset($_COOKIE[session_name()]))
{
  setCookie(session_name(),'',time()-3600,'/');
}
//4、彻底销毁session
session_destroy();

die("<script language=javascript>alert('退出登录成功！');window.location='index.php'</script>");
?>