<?php
include_once("Wx/WxPayPubHelper.php");

/**
* 微信支付
* @param  string $type    请求支付类型 1：NATIVE 2:H5 3:JSAPI
* @param  array  $data    订单相关参数
* @return json|string
*/
function Wxpay($type, $data)
{
	//实例化统一下单类
	$unifiedOrder = new \UnifiedOrder_pub();
	$unifiedOrder->setParameter("body",'');//商品描述
	$unifiedOrder->setParameter("out_trade_no",'');//商户订单号
	$unifiedOrder->setParameter("total_fee",1);//总金额.注意单位是分
	$unifiedOrder->setParameter("notify_url",'');//回调地址
	$unifiedOrder->setParameter("attach",'');//附加数据
	$unifiedOrder->setParameter("product_id",'');//商品ID
	switch ($type) {
		case 1:
			$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
			$result = $unifiedOrder->getCodeUrl();
			break;
		case 2:
            // 1，IOS移动应用
			// {"h5_info": //h5支付固定传"h5_info" 
			//     {"type": "",  //场景类型
			//      "app_name": "",  //应用名
			//      "bundle_id": ""  //bundle_id
			//      }
			// }

			// 2，安卓移动应用
			// {"h5_info": //h5支付固定传"h5_info" 
			//     {"type": "",  //场景类型
			//      "app_name": "",  //应用名
			//      "package_name": ""  //包名
			//      }
			// }

			// 3，WAP网站应用
			// {"h5_info": //h5支付固定传"h5_info" 
			//    {"type": "",  //场景类型
			//     "wap_url": "",//WAP网站URL地址
			//     "wap_name": ""  //WAP 网站名
			//     }
			// }
			$str = '{"h5_info": {"type":"Wap","wap_url": "https://pay.qq.com","wap_name": "腾讯充值"}}';
		    $unifiedOrder->setParameter("scene_info",$str);//场景信息
			$unifiedOrder->setParameter("trade_type","MWEB");//交易类型
			$result = $unifiedOrder->getMwebUrl();
			break;
		case 3:
			$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
			$unifiedOrder->setParameter("openid",用户openid);//openid
			$prepay_id = $unifiedOrder->getPrepayId();
	        $jsApi = new \JsApi_pub();
	        //设置prepay_id
	        $jsApi->setPrepayId($prepay_id);
	        //获取参数
	        $Parameters = $jsApi->getParameters();
	        $result = json_decode($Parameters);
			break;
	}

    //兼容前端为空出问题的情况
    return $result;
}