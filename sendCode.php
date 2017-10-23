<?php
/** Powerd by RebetaStudio 
 * 
 *  http://www.rebeta.cn
 * 
 * 20170719
 * 
 */
 
header("Content-type: text/html; charset=utf-8");

$phoneNumber = $_POST['phone']; //收件人手机号
if(!is_numeric($phoneNumber) || strlen($phoneNumber) != 11){
    die("手机号码不正确！");
}

require_once 'public.php';
$pdo = new DataBase;
$db = $pdo->mysqlconn();

$code = rand(1000,9999); //验证码
$TermOfValidity = 15;  //验证码有效期

$sql = "INSERT INTO yd_verification_code(phone, code, time, term) VALUES ('$phoneNumber','$code','".date("Y/m/d H:i:s")."','$TermOfValidity')";
$db->exec($sql);

try {
    // appid 和 appkey
    $appid = "appid";
    $appkey = "appkey";
    $singleSender = new SmsSingleSender($appid, $appkey);
    // 指定模板单发
    $params = array($code,$TermOfValidity);
    $templId = "模板ID";  //模板ID
    $sign = "签名";  //签名
    $result = $singleSender->sendWithParam("86", $phoneNumber, $templId, $params, $sign, "", "");
    $rsp = json_decode($result);
    if($rsp->result){
        $state = $rsp->result;
        //echo "发送失败，错误代码：".$rsp->result."，原因:".$rsp->errmsg;
        $JS = "发送验证码失败，错误代码：".$rsp->result."，原因:".$rsp->errmsg."！";
    }else{
        $state = "Success";
        //echo "发送成功！";
        $JS = "发送验证码成功！";
    }
    die($JS);
} catch (\Exception $e) {
    echo var_dump($e);
    die();
}

class SmsSenderUtil {
    function getRandom() {
        return rand(100000, 999999);
    }

    function calculateSigForTemplAndPhoneNumbers($appkey, $random, $curTime, $phoneNumbers) {
        $phoneNumbersString = $phoneNumbers[0];
        for ($i = 1; $i < count($phoneNumbers); $i++) {
            $phoneNumbersString .= ("," . $phoneNumbers[$i]);
        }
        return hash("sha256", "appkey=".$appkey."&random=".$random
            ."&time=".$curTime."&mobile=".$phoneNumbersString);
    }

    function calculateSigForTempl($appkey, $random, $curTime, $phoneNumber) {
        $phoneNumbers = array($phoneNumber);
        return $this->calculateSigForTemplAndPhoneNumbers($appkey, $random, $curTime, $phoneNumbers);
    }

    function sendCurlPost($url, $dataObj) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($curl);
        if (true != $ret) {
            $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
        } else {
            $rsp = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
            //if (200 != $rsp) {
            //    $result = "{ \"result\":" . -1 . ",\"errmsg\":\"". $rsp . " " . curl_error($curl) ."\"}";
            //} else {
                $result = $ret;
            //}
        }
        curl_close($curl);
        return $result;
    }
}

class SmsSingleSender {
    var $url;
    var $appid;
    var $appkey;
    var $util;

    function __construct($appid, $appkey) {
        $this->url = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms";
        $this->appid =  $appid;
        $this->appkey = $appkey;
        $this->util = new SmsSenderUtil();
    }

    function sendWithParam($nationCode, $phoneNumber, $templId, $params, $sign, $extend = "", $ext = "") {
        $random = $this->util->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $tel = new \stdClass();
        $tel->nationcode = "".$nationCode;
        $tel->mobile = "".$phoneNumber;

        $data->tel = $tel;
        $data->sig = $this->util->calculateSigForTempl($this->appkey, $random, $curTime, $phoneNumber);
        $data->tpl_id = $templId;
        $data->params = $params;
        $data->sign = $sign;
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $ext;
        return $this->util->sendCurlPost($wholeUrl, $data);
    }
}
?>