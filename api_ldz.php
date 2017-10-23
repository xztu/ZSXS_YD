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
			         case "jdt":
			             $info = array();
			             $sql = "SELECT count(*) NUM FROM T_TDD WHERE YDSJ IS NOT NULL";
			             $rs = $db->query($sql);
			             $info1 = $rs->fetch(PDO::FETCH_ASSOC);
			             $sql = "SELECT count(*) NUM FROM T_TDD";
			             $rs = $db->query($sql);
			             $info2 = $rs->fetch(PDO::FETCH_ASSOC);
			             array_push($info,array("阅档进度",$info1["NUM"],$info2["NUM"],round(($info1["NUM"]/$info2["NUM"])*100).'%'));
			             print json_encode($info);
			             break;
					case "xi":
						$sql = "SELECT DISTINCT(YXBMDM),YXBMMC FROM zsjh";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						foreach ($info as &$tinfo){
						    $sql = "SELECT YXBMDM,YXBMMC,COUNT(DISTINCT(KSH)) RS FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE YDSJ IS NOT NULL AND YXBMDM = '".$tinfo["YXBMDM"]."' GROUP BY YXBMMC";
						    $rs = $db->query($sql);
						    $info1 = $rs->fetch(PDO::FETCH_ASSOC);
						    $sql = "SELECT YXBMDM,YXBMMC,COUNT(DISTINCT(KSH)) RS FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE YXBMDM = '".$tinfo["YXBMDM"]."' GROUP BY YXBMMC";
						    $rs = $db->query($sql);
						    $info2 = $rs->fetch(PDO::FETCH_ASSOC);
						    $tinfo["jd"] = round(($info1["RS"]/$info2["RS"])*100).'%';
						}
						print json_encode($info);
						break; 
					case "zt":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["xi"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						
						$sql = "SELECT COUNT(*) NUM FROM yd_ydyj WHERE Xi = (SELECT DISTINCT(YXBMMC) FROM zsjh WHERE YXBMDM = '".$_POST["xi"]."')";
						$rs = $db->query($sql);
						$info1 = $rs->fetch(PDO::FETCH_ASSOC);
						$sql = "SELECT YXBMDM,YXBMMC,COUNT(DISTINCT(KSH)) RS FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE YDSJ IS NULL AND YXBMDM = '".$_POST["xi"]."' GROUP BY YXBMMC";
						$rs = $db->query($sql);
						$info2 = $rs->fetch(PDO::FETCH_ASSOC);
						$info = array();
						array_push($info,array("已阅档",$info1["NUM"]."&nbsp;批"),array("未阅档",($info2["RS"] > 0 ? $info2["RS"] : 0)."&nbsp;人"));
						print json_encode($info);
						break; 
					case "yyd":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["xi"])/* || preg_match("/[\'.,:;*?~`!@#$^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["lb"])*/){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT * FROM yd_ydyj WHERE Xi = (SELECT DISTINCT(YXBMMC) FROM zsjh WHERE YXBMDM = '".$_POST["xi"]."')";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						foreach ($info as &$tinfo){
						    $sql = "SELECT PCMC,KLMC FROM T_TDD WHERE SFDM = '".$tinfo["SFDM"]."' AND PCDM = '".$tinfo["PCDM"]."' AND KLDM = '".$tinfo["KLDM"]."'";
						    $rs = $db->query($sql);
						    $info1 = $rs->fetch(PDO::FETCH_ASSOC);
						    $sql = "SELECT sf FROM sf WHERE SFDM = '".$tinfo["SFDM"]."'";
						    $rs = $db->query($sql);
						    $info2 = $rs->fetch(PDO::FETCH_ASSOC);
						    $tinfo["SFMC"] = $info2["sf"];
						    $tinfo["PCMC"] = $info1["PCMC"];
						    $tinfo["KLMC"] = $info1["KLMC"];
						}
						print json_encode($info);
						break; 
					case "wyd":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["xi"])/* || preg_match("/[\'.,:;*?~`!@#$^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["lb"])*/){
						    die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT SYSSMC,T_TDD.PCMC,T_TDD.KLMC,YXBMMC,COUNT(DISTINCT(KSH)) RS FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE YDSJ IS NULL AND YXBMDM = '".$_POST["xi"]."' GROUP BY YXBMMC";
						$rs = $db->query($sql);
						$info = $rs->fetchall(PDO::FETCH_ASSOC);
						print json_encode($info);
						break;
					case "yydres":
						if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$_POST["id"])){
							die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
						}
						$sql = "SELECT * FROM yd_ydyj WHERE id = '".$_POST["id"]."'";
						$rs = $db->query($sql);
						$info = $rs->fetch(PDO::FETCH_ASSOC);
						$sql = "SELECT PCMC,KLMC FROM T_TDD WHERE SFDM = '".$info["SFDM"]."' AND PCDM = '".$info["PCDM"]."' AND KLDM = '".$info["KLDM"]."'";
						$rs = $db->query($sql);
						$info1 = $rs->fetch(PDO::FETCH_ASSOC);
						$sql = "SELECT sf FROM sf WHERE SFDM = '".$info["SFDM"]."'";
						$rs = $db->query($sql);
						$info2 = $rs->fetch(PDO::FETCH_ASSOC);
						$info["SFMC"] = $info2["sf"];
						$info["PCMC"] = $info1["PCMC"];
						$info["KLMC"] = $info1["KLMC"];
						print json_encode($info);
						break; 
					default:
						die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
			}
			break; 
		case "progress":
			$sql = "select content from manager where id='1'";
			$rs = $db->query($sql);
			$info = $rs->fetch(PDO::FETCH_ASSOC);
			$content = $info[content];
			print $content;
			break;
		case "progress_jdt":
		    $info = array();
		    $sql = "SELECT COUNT(*) NUM FROM T_TDD WHERE NF = '2017'";
		    $rs = $db->query($sql);
		    $info1 = $rs->fetch(PDO::FETCH_ASSOC);
		    $sql = "SELECT SUM(ZSJHS) NUM FROM zsjh WHERE NF = '2017' AND JHLBDM <> '21'";
		    $rs = $db->query($sql);
		    $info2 = $rs->fetch(PDO::FETCH_ASSOC);
		    array_push($info,array("总进度（高考）",$info1["NUM"],$info2["NUM"],round(($info1["NUM"]/$info2["NUM"])*100).'%'));
			$sql = "SELECT COUNT(*) NUM FROM T_TDD WHERE NF = '2017' AND SFDM = '14' AND XZNX = '4'";
			$rs = $db->query($sql);
			$info1 = $rs->fetch(PDO::FETCH_ASSOC);
			$sql = "SELECT SUM(ZSJHS) NUM FROM zsjh WHERE NF = '2017' AND XZDM = '4' AND (SYSSDM = '14' OR SYSSDM = '00') AND JHLBDM <> '21'";
			$rs = $db->query($sql);
			$info2 = $rs->fetch(PDO::FETCH_ASSOC);
			array_push($info,array("&nbsp;本&nbsp;科&nbsp;（省内）",$info1["NUM"],$info2["NUM"],round(($info1["NUM"]/$info2["NUM"])*100).'%'));
			$sql = "SELECT COUNT(*) NUM FROM T_TDD WHERE NF = '2017' AND SFDM = '14' AND XZNX = '3'";
			$rs = $db->query($sql);
			$info1 = $rs->fetch(PDO::FETCH_ASSOC);
			$sql = "SELECT SUM(ZSJHS) NUM FROM zsjh WHERE NF = '2017' AND XZDM = '3' AND SYSSDM = '14' AND JHLBDM <> '21'";
			$rs = $db->query($sql);
			$info2 = $rs->fetch(PDO::FETCH_ASSOC);
			array_push($info,array("&nbsp;专&nbsp;科&nbsp;（省内）",$info1["NUM"],$info2["NUM"],round(($info1["NUM"]/$info2["NUM"])*100).'%'));
			$sql = "SELECT COUNT(*) NUM FROM T_TDD WHERE NF = '2017' AND SFDM <> '14'";
			$rs = $db->query($sql);
			$info1 = $rs->fetch(PDO::FETCH_ASSOC);
			$sql = "SELECT SUM(ZSJHS) NUM FROM zsjh WHERE NF = '2017' AND XZDM = '4' AND SYSSDM <> '14' AND SYSSDM <> '00'";
			$rs = $db->query($sql);
			$info2 = $rs->fetch(PDO::FETCH_ASSOC);
			array_push($info,array("&nbsp;本&nbsp;科&nbsp;（省外）",$info1["NUM"],$info2["NUM"],round(($info1["NUM"]/$info2["NUM"])*100).'%'));
			print json_encode($info);
			break;   	
		case "my":
			print json_encode($uinfo);
			break;
		default:
			die("<script language=javascript>alert('非法参数！');window.location='index.php';</script>");
	}
}
?>