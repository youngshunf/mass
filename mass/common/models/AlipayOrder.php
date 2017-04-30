<?php
namespace common\models;

use yii;
class AlipayOrder{
    // 支付宝合作者身份ID，以2088开头的16位纯数字
    private  $partner;
    // 支付宝账号
    private  $seller_id = 'eu5151@163.com';
    private  $withdraw_gateway='https://mapi.alipay.com/gateway.do';
    // 商品网址
    private $base_path ;
    // 异步通知地址
    private $notify_url ;
    
    private $order;
    
    private $privateKey;
  
//     function __construct($order){
//         $this->order=$order;
//         $config=yii::$app->params['alipayConfig'];
//         $this->partner=$config['pid'];
//         $this->notify_url=$config['notify_url'];
//         $this->privateKey=$config['merchant_private_key'];
        
//     }
    
       // 对签名字符串转义
    private function createLinkstring($para) {
        ksort($para);
        $arg  = "";
//         while (list ($key, $val) = each ($para)) {
//             $arg.=$key.'="'.$val.'"&';
//         }
         foreach ($para as $key =>$val){
             $arg.=$key.'='.$val.'&';
         }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        return $arg;
    }
    
    // 签名生成订单信息
   private function rsaSign($data) {
        $priKey = "-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQDsN/pq7ekcyMOMCpKyToRoDag3VpZh7b/rlmePAg/rbltsBj/J
4ek/OwGk8Ti3q5vjOeiUfKqHKra7lSSP7erM9+horkGH2i+UZz5zAChvmQ5a1a2Q
oCnISlQN41uOe4Lcx/tbJ5q1BGwRIOmgtzgIBewXsdachcbzzsXRH3aMoQIDAQAB
AoGAAuIsDGIbFl7dBDic0dBjjWGdTA+ihk+AqD+NxBEiYJ1YQFlTLgOz9TGjM4A+
UP+nR37NeAKNkljTIjcP2zHsS845WUbzMKcyIACICml7ELMoRmmD/3P8jf7HmtQN
Rb/5Fa0ahHxhEzMQ65lqqSVNmxHWvrfldBYwkKRfdlBg5gECQQD8+mfLIWspQEXM
7O8mwToBdjEfPGiuVdySIhDs7xX1ygxqwGpTJW399Fk6MUQ38GXphqh9W2yH1gY0
nY2wgfLlAkEA7wpSti0KAfc+ZIt0AJxFhVzH3BIgRQZ8kpAxjW50SKelbIc7bEdV
D2OqWnoZ8uEdKyzvo8lF3buKvfbDfAHrDQJAL/8KRj3W6QKqu5CQZxft+20DMNvz
OHBN4uPXtjw+PF3TMUXEZnYJgk8jxqimOr6/dyj3OqFn2/W9Q6pIwZ5GCQJACGG6
SL0Hjs4Wl/vz01mnbme0clkIXKM/lvwLYMQwu6N1P3r2cHOH3gRGoumJI2UVWsA2
nu2dz4qV8NdIP37puQJAEq6qKGanBdHM6JwiI31gVZQf1GMqxkUKEa2c1ZukmTz4
0VLd6uGFRAF5ImWKHtvNfe+aNQSGcT3UKmfK2KGdHQ==
-----END RSA PRIVATE KEY-----";
        $res = openssl_get_privatekey($priKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        //$sign = urlencode($sign);
        return $sign;
    }
    
    public function generateOrderInfo($order,$orderType){
        $config=yii::$app->params['alipayConfig'];
        $this->partner=$config['pid'];
        $this->notify_url=$config['notify_url'];
        $this->privateKey=$config['merchant_private_key'];
        $this->base_path=$config['base_path'];
        $orderDesc=$orderType==1?'[供货保证金]':'[进货保证金],数量:'.$order->number;
        if($orderType==1){
            $orderno=$order->orderno;
        }elseif ($orderType==2){
            $orderno=$order->seller_orderno;
        }
        
        $bizContent=[
            'body'=>$orderDesc,
            'subject'=>$order->goods_name,
            'out_trade_no'=>$orderno,
            'total_amount'=>$order->amount,
//             'total_amount'=>'0.01',
            'product_code'=>'QUICK_MSECURITY_PAY',
            'timeout_express'=>'20m',
        ];
        $parameter =[
            'app_id'        =>$config['app_id'],
            'biz_content'   =>json_encode($bizContent,JSON_UNESCAPED_UNICODE),
            'method'        => 'alipay.trade.app.pay',   // 必填，接口名称，固定值
            'format'        => 'json',              // 必填，合作商户号
            'charset'       => 'utf-8',                    // 必填，参数编码字符集
            'notify_url'     => $config['notify_url'],                // 可选，服务器异步通知页面路径
            'sign_type'     =>'RSA',
            'timestamp'     =>date('Y-m-d H:i:s'),
            'version'     =>'1.0'
        ];
        //生成需要签名的订单
        $orderInfo = $this->createLinkstring($parameter);
        //签名
        $sign = $this->rsaSign($orderInfo);
         $parameter['sign']=$sign;
        $res=$this->getEncodeResult($parameter);
        //生成订单
        return $res;
    }
    
    public function generateWithdrawInfo($order){
        $config=yii::$app->params['alipayConfig'];
        $this->partner=$config['pid'];
        $this->notify_url=$config['notify_url'];
        $this->privateKey=$config['merchant_private_key'];
        $this->base_path=$config['base_path'];
        $orderDesc=$order->type==1?'[供货保证金]':'[进货保证金],数量:'.$order->number;
        $bizContent=[
            'body'=>$orderDesc.', 数量:'.$order->number,
            'subject'=>$order->goods_name,
            'out_trade_no'=>$order->orderno,
            'total_amount'=>$order->amount,
            //             'total_amount'=>'0.01',
            'product_code'=>'QUICK_MSECURITY_PAY',
            'timeout_express'=>'10m',
        ];
        $parameter =[
            'app_id'        =>$config['app_id'],
            'biz_content'   =>json_encode($bizContent,JSON_UNESCAPED_UNICODE),
            'method'        => 'alipay.trade.app.pay',   // 必填，接口名称，固定值
            'format'        => 'json',              // 必填，合作商户号
            'charset'       => 'utf-8',                    // 必填，参数编码字符集
            'notify_url'     => $config['notify_url'],                // 可选，服务器异步通知页面路径
            'sign_type'     =>'RSA',
            'timestamp'     =>date('Y-m-d H:i:s'),
            'version'     =>'1.0'
        ];
        //生成需要签名的订单
        $orderInfo = $this->createLinkstring($parameter);
        //签名
        $sign = $this->rsaSign($orderInfo);
        $parameter['sign']=$sign;
        $res=$this->getEncodeResult($parameter);
        //生成订单
        return $res;
    }
    
  
    // 对签名字符串转义
    private function getEncodeResult($para) {
        ksort($para);
        $arg  = "";
        //         while (list ($key, $val) = each ($para)) {
        //             $arg.=$key.'="'.$val.'"&';
        //         }
        foreach ($para as $key =>$val){
            $arg.=$key.'='.urlencode($val).'&';
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        return $arg;
    }
  
}