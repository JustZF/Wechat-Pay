<?php
include_once("Wx/WxPayPubHelper.php");

/**
* 微信订单查询
* @param  string $out_trade_no  微信订单号
* @return array
*/
function Wxcheck($out_trade_no)
{
    $jsApi = new \JsApi_pub();
    $orderQuery_pub = new \OrderQuery_pub();
    $orderQuery_pub->setParameter("out_trade_no", "$out_trade_no");
    $xml = $orderQuery_pub->createXml();
    $url = $orderQuery_pub->url;//curl_timeout
    // "<xml>
    //    <return_code><![CDATA[SUCCESS]]></return_code>
    //    <return_msg><![CDATA[OK]]></return_msg>
    //    <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
    //    <mch_id><![CDATA[10000100]]></mch_id>
    //    <device_info><![CDATA[1000]]></device_info>
    //    <nonce_str><![CDATA[TN55wO9Pba5yENl8]]></nonce_str>
    //    <sign><![CDATA[BDF0099C15FF7BC6B1585FBB110AB635]]></sign>
    //    <result_code><![CDATA[SUCCESS]]></result_code>
    //    <openid><![CDATA[oUpF8uN95-Ptaags6E_roPHg7AG0]]></openid>
    //    <is_subscribe><![CDATA[Y]]></is_subscribe>
    //    <trade_type><![CDATA[MICROPAY]]></trade_type>
    //    <bank_type><![CDATA[CCB_DEBIT]]></bank_type>
    //    <total_fee>1</total_fee>
    //    <fee_type><![CDATA[CNY]]></fee_type>
    //    <transaction_id><![CDATA[1008450740201411110005820873]]></transaction_id>
    //    <out_trade_no><![CDATA[1415757673]]></out_trade_no>
    //    <attach><![CDATA[订单额外描述]]></attach>
    //    <time_end><![CDATA[20141111170043]]></time_end>
    //    <trade_state><![CDATA[SUCCESS]]></trade_state>
    // </xml>"
    //trade_state 类型
    // SUCCESS—支付成功
	// REFUND—转入退款
	// NOTPAY—未支付
	// CLOSED—已关闭
	// REVOKED—已撤销（付款码支付）
	// USERPAYING--用户支付中（付款码支付）
	// PAYERROR--支付失败(其他原因，如银行返回失败)
    $xml = $orderQuery_pub->postXmlCurl($xml, $url);
    $result = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    if ($result["return_code"] == "SUCCESS"&& $result["result_code"] == "SUCCESS") {
        return $result;
    }
    return false;
}