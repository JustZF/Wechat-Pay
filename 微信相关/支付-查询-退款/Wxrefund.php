<?php
include_once("Wx/WxPayPubHelper.php");

/**
* 微信申请退款
* @param  string $type    请求支付类型 1：NATIVE 2:H5 3:JSAPI
* @param  array  $data    订单相关参数
* @return json|string
*/
function Wxrefund($type, $data)
{
	//实例化统一下单类
	$unifiedOrder = new \Refund_pub();
	$unifiedOrder->setParameter("out_refund_no",'');//退款单号，用户自己生成
	$unifiedOrder->setParameter("transaction_id",'');//微信订单号
	// $unifiedOrder->setParameter("out_trade_no",'');//用户订单号 与微信订单号 二选一
	$unifiedOrder->setParameter("total_fee",1);//总金额.注意单位是分
	$unifiedOrder->setParameter("refund_fee",'');//退款金额

	$result = $unifiedOrder->getResult();
    //返回相关参数 请自行查看文档
    //https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_4
    /** <xml>
	<return_code><![CDATA[SUCCESS]]></return_code>
	<return_msg><![CDATA[OK]]></return_msg>
	<appid><![CDATA[wx2421b1c4370ec43b]]></appid>
	<mch_id><![CDATA[10000100]]></mch_id>
	<nonce_str><![CDATA[NfsMFbUFpdbEhPXP]]></nonce_str>
	<sign><![CDATA[B7274EB9F8925EB93100DD2085FA56C0]]></sign>
	<result_code><![CDATA[SUCCESS]]></result_code>
	<transaction_id><![CDATA[1008450740201411110005820873]]></transaction_id>
	<out_trade_no><![CDATA[1415757673]]></out_trade_no>
	<out_refund_no><![CDATA[1415701182]]></out_refund_no>
	<refund_id><![CDATA[2008450740201411110000174436]]></refund_id>
	<refund_channel><![CDATA[]]></refund_channel>
	<refund_fee>1</refund_fee>
	</xml>*/
    if($result['return_code'] =='SUCCESS'){
        //退款申请成功
    }
    return $result;
}