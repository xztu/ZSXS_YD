<?php
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170719
 *
 */
 
session_start();

require_once 'public.php';
$pdo = new DataBase;
$db = $pdo->mysqlconn();


//检查是否登录
if(is_numeric($_SESSION["phone"]) && (strlen($_SESSION["phone"] != 11))){
	$isLogin = true;
	$sql = "取出信息";
	//检查是否确认使用须知
	$sql = "SELECT * FROM yd_user WHERE phone = '".$_SESSION["phone"]."'";
	$rs = $db->query($sql);
	$info = $rs->fetch(PDO::FETCH_ASSOC);
	if($info["confirm"] == "True"){
		$isConfirm = true;
	} else {
		$isConfirm = false;
	}
} else {
	$isLogin = false;
}

//登录
if($_POST["phone"]){
	if(!is_numeric($_POST["phone"]) || strlen($_POST["phone"]) != 11){
		die("<script language=javascript>alert('手机号码输入不正确！');window.location='index.php';</script>");
	} else {
		$sql = "SELECT * FROM yd_user WHERE phone = '".$_POST["phone"]."'";
		$rs = $db->query($sql);
		$info = $rs->fetch(PDO::FETCH_ASSOC);
		if($_POST["password"] != $info["password"]){
			die("<script language=javascript>alert('手机号码或密码输入不正确！');window.location='index.php';</script>");
		} else {
			$sql = "SELECT * FROM yd_verification_code WHERE phone = '".$info["phone"]."' ORDER BY id DESC";
			$rs = $db->query($sql);
			$info = $rs->fetch(PDO::FETCH_ASSOC);
			if($info["code"] != $_POST["code"]){
				die("<script language=javascript>alert('验证码输入不正确，请重新输入！');window.location='index.php';</script>");
			} else {
				$start = $info["time"];
				$end = date("Y/m/d H:i:s");
				$term = $info["term"];
				$countmin=floor((strtotime($end)-strtotime($start))/60);
				if($countmin > $term){
					die("<script language=javascript>alert('验证码超时，请重新获取验证码！');window.location='index.php';</script>");
				} else {
					$_SESSION["phone"] = $info["phone"];
					$sql = "UPDATE yd_user SET last = '".$end."' WHERE phone = '".$info["phone"]."'";
					$rs = $db->exec($sql);
					$sql = "INSERT INTO yd_log (`datetime`, `type`, `user`) VALUES ('".$end."','登录','".$info["phone"]."')";
					$rs = $db->exec($sql);
					die("<script language=javascript>alert('登录成功！');window.location='index.php';</script>");
				}
			}
		}
	}
}

//使用须知
if($_POST["confirm"]){
	if(!$isLogin){
		die("<script language=javascript>alert('请先进行登录！');window.location='index.php';</script>");
	}
	if($_POST["checkbox"]){
		$sql = "UPDATE yd_user SET confirm = 'True' WHERE phone = '".$_SESSION["phone"]."'";
		$rs = $db->exec($sql);
		$sql = "INSERT INTO yd_log (`datetime`, `type`, `user`) VALUES ('".date("Y/m/d H:i:s")."','同意使用协议','".$info["phone"]."')";
		$rs = $db->exec($sql);
		die("<script language=javascript>alert('即将开始阅档！');window.location='index.php';</script>");
	} else {
		die("<script language=javascript>alert('请先阅读并同意使用须知！');window.location='index.php';</script>");
	}
}

//载入页面
if($isLogin){
	if($isConfirm){
	    $sql = "SELECT * FROM yd_user WHERE phone = '".$_SESSION["phone"]."'";
	    $rs = $db->query($sql);
	    $info = $rs->fetch(PDO::FETCH_ASSOC);
	    if($info["department"] == "招生工作领导组"){
	        require "./require/main_ldz.php";
	    } else {
	        require "./require/main.php";
	    }
	} else {
		require "./require/confirm.php";
	}
} else {
	require "./require/login.php";
}
?>