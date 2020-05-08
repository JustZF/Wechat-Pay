<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wxbfb93569bee3f4f3';
	//受理商ID，身份标识
	//const MCHID = '1500989771';
	const MCHID = '1526323121';
    //const MCHID = '1524099021';

	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	//const KEY = 'bvibotwgm1hqj0ojxannvxhwcia0jk5v';
	const KEY = 'jJYRpYDIl9MptqdenPfTQyrGSkCc2QjJ';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = '6c57a4daa097051c6cc914195adcb312';
	
	const SSLCERT_PATH = '../cacert/apiclient_cert.pem';
	const SSLKEY_PATH = '../cacert/apiclient_key.pem';

	const NOTIFY_URL = 'http://houtai.same100.com/yy/index.php?s=/html/weixinnotify';
	const CURL_TIMEOUT = 180;
}

	
?>


