<?php
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170722
 *
 */

require_once '../public.php';
$pdo = new DataBase;
$db = $pdo->mysqlconn();

if($_GET["p"] != "password"){
	die("未授权");
}

$sql = "SELECT YXBMMC,SYSSMC,T_TDD.PCMC,T_TDD.KLMC,COUNT(DISTINCT(KSH)) RS FROM T_TDD LEFT JOIN zsjh ON T_TDD.NF = zsjh.NF AND T_TDD.SFDM = zsjh.SYSSDM AND T_TDD.ZYDM = zsjh.ZSZYDM WHERE YDSJ IS NULL GROUP BY YXBMMC,SYSSMC,PCMC,KLMC";
$rs = $db->query($sql);
$result = $rs->fetchall(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>待阅档信息</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>

<div id="container">   

	<table class="zebra">
    <caption>待阅档信息</caption>
		<thead>
        	<tr>
				<th>系</th>
				<th>省份</th>
				<th>批次</th>
				<th>科类</th>
				<th>人数</th>
				<th>发送短信</th>
            </tr>
		</thead>
        <tbody>
			<?php 
			foreach($result as $info){
				print "<tr>";
				print "<td>".$info["YXBMMC"]."</td>";
				print "<td>".$info["SYSSMC"]."</td>";
				print "<td>".$info["PCMC"]."</td>";
				print "<td>".$info["KLMC"]."</td>";
				print "<td>".$info["RS"]."人</td>";
				print "<td><a href='sender.php?xi=".$info["YXBMMC"]."&sf=".$info["SYSSMC"]."&pc=".$info["PCMC"]."&kl=".$info["KLMC"]."&rs=".$info["RS"]."'>发送</a></td>";
				print "</tr>";
			}
			?>
        </tbody>
	</table>
</div>
    
</body>
</html>