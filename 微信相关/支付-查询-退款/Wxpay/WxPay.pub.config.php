<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = '';
	//受理商ID，身份标识
	const MCHID = '';

	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = '';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = '';
	
	const SSLCERT_PATH = '../cacert/apiclient_cert.pem';
	const SSLKEY_PATH = '../cacert/apiclient_key.pem';

	const NOTIFY_URL = 'http://houtai.same100.com/yy/index.php?s=/html/weixinnotify';
	const CURL_TIMEOUT = 180;
}

	
?>


