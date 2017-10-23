<?php 
/** Powerd by RebetaStudio 
 * 
 *  http://www.rebeta.cn
 * 
 * 20170719
 * 
 */

//本地数据库账户及配置
define ("MySqlUSER","数据库用户名");
define ("MySqlPWD","数据库密码");
define ("MySqlDSN","mysql:host=数据库主机IP地址;port=数据库端口;dbname=数据库名;charset=utf8");

//关闭错误回显
error_reporting(0);
//设置时区为+8
date_default_timezone_set('PRC');
//设置字符为UTF-8
header("Content-type: text/html; charset=utf-8");

//数据库类
class DataBase{
    public function mysqlconn()
    {
        try{
            //实例化mysqlpdo，执行这里时如果出错会被catch
            $mysqlpdo = new PDO(MySqlDSN,MySqlUSER,MySqlPWD);
            return $mysqlpdo;
        }catch (Exception $e){
            $err = $e->getMessage();
            die($err);
        }
    }
}
?>