<?php

/**
 * url前半部分
 */
$GLOBALS['BASE_URL'] = $_CONFIG['SMS_BASE_URL'];

/**
 * url中的accountSid。如果接口验证级别是主账户则传网站“个人中心”页面的“账户ID”，
 */
$GLOBALS['ACCOUNT_SID'] = $_CONFIG['SMS_ACCOUNT_SID']; // 主账户
$GLOBALS['AUTH_TOKEN']  = $_CONFIG['SMS_AUTH_TOKEN'];
$GLOBALS['funAndOperate'] = $_CONFIG['SMS_funAndOperate'];

/**
 * 请求的内容类型，application/x-www-form-urlencoded
 */
$GLOBALS['CONTENT_TYPE'] = "application/x-www-form-urlencoded";

/**
 * 期望服务器响应的内容类型，可以是application/json或application/xml
 */
$GLOBALS['ACCEPT'] = "application/json";

// 时间戳
date_default_timezone_set("Asia/Shanghai");

/**
 * 创建url
 *
 * @param funAndOperate
 *            请求的功能和操作
 * @return
 */
function createUrl($funAndOperate)
{
    global $BASE_URL, $ACCOUNT_SID, $AUTH_TOKEN;
    
    // 时间戳
    date_default_timezone_set("Asia/Shanghai");
    $timestamp = date("YmdHis");

    return $BASE_URL . $funAndOperate;
}

function createSig()
{
    global $ACCOUNT_SID, $AUTH_TOKEN;

    $timestamp = date("YmdHis");

    // 签名
    $sig = md5($ACCOUNT_SID . $AUTH_TOKEN . $timestamp);
    return $sig;
}

function createBasicAuthData()
{
    global $ACCOUNT_SID, $AUTH_TOKEN;
    $timestamp = date("YmdHis");
    // 签名
    $sig = md5($ACCOUNT_SID . $AUTH_TOKEN . $timestamp);
    return array("accountSid" => $ACCOUNT_SID, "timestamp" => $timestamp, "sig" => $sig, "respDataType"=> "JSON");
}

/**
 * 创建请求头
 * @param body
 * @return
 */
function createHeaders()
{
    global $CONTENT_TYPE, $ACCEPT;

    $headers = array('Content-type: ' . $CONTENT_TYPE, 'Accept: ' . $ACCEPT);

    return $headers;
}

/**
 * post请求
 *
 * @param funAndOperate
 *            功能和操作
 * @param body
 *            要post的数据
 * @return
 * @throws IOException
 */
function post($funAndOperate, $body)
{
    global $CONTENT_TYPE, $ACCEPT;

    // 构造请求数据
    $url = createUrl($funAndOperate);
    $headers = createHeaders();

    echo("url:<br/>" . $url . "\n");
    echo("<br/><br/>body:<br/>" . json_encode($body));
    echo("<br/><br/>headers:<br/>");
    var_dump($headers);

    // 要求post请求的消息体为&拼接的字符串，所以做下面转换
    $fields_string = "";
    foreach ($body as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }
    rtrim($fields_string, '&');

    // 提交请求
    $con = curl_init();
    curl_setopt($con, CURLOPT_URL, $url);
    curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($con, CURLOPT_HEADER, 0);
    curl_setopt($con, CURLOPT_POST, 1);
    curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
    $result = curl_exec($con);
    curl_close($con);

    return "" . $result;
}
