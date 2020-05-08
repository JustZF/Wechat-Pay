<?php

class Wechat
{
    private $appId;
    private $appSecret;

    public function __construct($config = array())
    {
        $this->appId = $config['appId'];
        $this->appSecret = $config['appSecret'];
    }

    //微信登录
    public function wxLogin()
    {
        //获取AccessToken
        $getAccessTokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appId}&secret={$this->appSecret}&code={$code}&grant_type=authorization_code";
        $tokenArr = file_get_contents($getAccessTokenUrl);
        $accessTokenArr = json_decode($tokenArr, true);
        //unionid 唯一
        if(!isset($accessTokenArr['access_token'])){
            return false;
        }
        //获取openId
        $getUserIdUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $accessTokenArr['access_token'] . '&openid=' . $accessTokenArr['openid'];
        $userIdArr = file_get_contents($getUserIdUrl);
        $userIdArr = json_decode($userIdArr, true);
        return $userIdArr;
    }

    //获取微信全局accessToken
    protected function getAccessToken()
    {
        $token = Cache::get("wechat_access_token");
        if (!$token) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$this->appId}&corpsecret={$this->appSecret}";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appId}&secret={$this->appSecret}";
            $ret = Http::get($url);
            $json = json_decode($ret, true);
            $token = isset($json['access_token']) ? $json['access_token'] : '';
            if ($token) {
                Cache::set('wechat_access_token', $token, 3600);
            }
        }

        return $token;
    }

    //模板消息发送 
    public function getmoban($data)
    {
        $accesstoken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accesstoken;
        $ret = Http::post($url,$data);
        $json = json_decode($ret, true);
        return $json;
    }

    //获取用户公众号状态
    protected function getcheck($openId)
    {
        
        $token = Cache::has('wechat_access_token') ? Cache::get('wechat_access_token') : $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openId.'&lang=zh_CN';
        $ret = Http::get($url);
        $json = json_decode($ret, true);
        if(!isset($json['subscribe']))
        {
            Cache::rm('wechat_access_token');
            $this->getcheck($openId);
        }
        return $json;
    }
    
    //公众号签名
    public function getSignedPackage($url)
    {
        $jsapiTicket = $this->getJsApiTicket();
        $timestamp = time();
        $nonceStr = Random::alnum(16);
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string,
            "jsticket" => $jsapiTicket,
        );
        return $signPackage;
    }

    private function getJsApiTicket()
    {
        $ticket = Cache::get("wechat_jsapi_ticket");
        if (!$ticket) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token={$accessToken}";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={$accessToken}";
            $ret = Http::get($url);
            $json = json_decode($ret, true);
            $ticket = isset($json['ticket']) ? $json['ticket'] : '';
            if ($ticket) {
                Cache::set('wechat_jsapi_ticket', $ticket, 7200);
            }
        }
        return $ticket;
    }
}