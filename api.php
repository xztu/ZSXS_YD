<?php
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170720
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

if(!$isConfirm || !$isLogin){
	die("<script language=javascript>alert('还没有登录或用户被锁定！');window.location='index.php';</script>");
}

//登录
if($_POST["type"]){
	$sql = "SELECT * FROM yd_user WHERE phone = '".$_SESSION["phone"]."'";
	$rs = $db->query($sql);
	$uinfo = $rs->fetch(PDO::FETCH_ASSOC);
	switch ($_POST["type"]){
		case "yd":
			switch ($_POST["want"]){
					case "sf":
						$sql = "SELECT DISTINCT(zsjh.SYSSDM),zsjh.SYSSMC FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND YDSJ IS NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break; 
					case "pc":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["sf"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT DISTINCT(T_TDD.PCDM),T_TDD.PCMC FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND SFDM = '".$_POST["sf"]."' AND YDSJ IS NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break; 
					case "kl":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["pc"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["sf"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT DISTINCT(T_TDD.KLDM),T_TDD.KLMC FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND SFDM = '".$_POST["sf"]."' AND T_TDD.PCDM = '".$_POST["pc"]."' AND YDSJ IS NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break; 
					case "res":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["pc"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["sf"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["kl"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT * FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND SFDM = '".$_POST["sf"]."' AND T_TDD.PCDM = '".$_POST["pc"]."' AND T_TDD.KLDM = '".$_POST["kl"]."' AND YDSJ IS NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break; 
					case "ksres":
						if(!is_numeric($_POST["ksh"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT * FROM T_TDD WHERE ksh = '".$_POST["ksh"]."'";
						$rs = $db->query($sql);
						$info = $rs->fetch(PDO::FETCH_ASSOC);
						$info["phone"] = $_SESSION["phone"];
						print json_encode($info);
						break; 
					case "submit":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["pc"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["sf"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["kl"])){
							die("非法参数！");
						}
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["ydyj"])){
							die("非法参数，请不要在阅档意见中使用英文符号！");
						}
						$time = date("Y/m/d H:i:s");
						$sql = "SELECT * FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND SFDM = '".$_POST["sf"]."' AND T_TDD.PCDM = '".$_POST["pc"]."' AND T_TDD.KLDM = '".$_POST["kl"]."' AND YDSJ IS NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$res = $rs->fetchall(PDO::FETCH_ASSOC);
						foreach ($res as $result){
							$sql = "UPDATE T_TDD SET YDSJ = '".$time."' WHERE KSH = '".$result["KSH"]."'";
							$db->exec($sql);
						}
						$sql = "INSERT INTO yd_ydyj (Time,SFDM,PCDM,KLDM,Xi,YDYJ) VALUES ('".$time."', '".$_POST["sf"]."', '".$_POST["pc"]."', '".$_POST["kl"]."', '".$uinfo["department"]."', '".$_POST["ydyj"]."')";
						$db->exec($sql);
						print "提交成功！";
						break;
					default:
						die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
			}
			break; 
		case "ydall":
			switch ($_POST["want"]){
					case "sf":
						$sql = "SELECT DISTINCT(zsjh.SYSSDM),zsjh.SYSSMC FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND YDSJ IS NOT NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break; 
					case "pc":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["sf"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT DISTINCT(T_TDD.PCDM),T_TDD.PCMC FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND SFDM = '".$_POST["sf"]."' AND YDSJ IS NOT NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break; 
					case "kl":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["pc"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["sf"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT DISTINCT(T_TDD.KLDM),T_TDD.KLMC FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND SFDM = '".$_POST["sf"]."' AND T_TDD.PCDM = '".$_POST["pc"]."' AND YDSJ IS NOT NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break; 
					case "res":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["pc"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["sf"]) || preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["kl"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT * FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE zsjh.YXBMMC = '".$uinfo["department"]."' AND SFDM = '".$_POST["sf"]."' AND T_TDD.PCDM = '".$_POST["pc"]."' AND T_TDD.KLDM = '".$_POST["kl"]."' AND YDSJ IS NOT NULL GROUP BY KSH";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						$sql = "SELECT YDYJ,ZBHF FROM yd_ydyj WHERE SFDM = '".$_POST["sf"]."' AND PCDM = '".$_POST["pc"]."' AND KLDM = '".$_POST["kl"]."' ORDER BY Id DESC ";
						$rs = $db->query($sql);
						$res = $rs->fetch(PDO::FETCH_ASSOC);
						$info += $res;
						print json_encode($info);
						break; 
					case "ksres":
						if(!is_numeric($_POST["ksh"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT * FROM T_TDD WHERE ksh = '".$_POST["ksh"]."'";
						$rs = $db->query($sql);
						$info = $rs->fetch(PDO::FETCH_ASSOC);
						$info["phone"] = $_SESSION["phone"];
						print json_encode($info);
						break; 
					default:
						die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
			}
			break;
		case "my":
			print json_encode($uinfo);
			break;
		default:
			die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
	}
}
?>