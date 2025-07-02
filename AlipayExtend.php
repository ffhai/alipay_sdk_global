<?php
namespace alipay;

class AlipayExtend{
    protected $gatewayUrl = ' https://open-sea-global.alipay.com';
    protected $clientId = '';
    protected $merchantPrivateKey = '';
    protected $sandbox = false;

    public function __construct(array $params){
        if(isset($params['sandbox'])){
            $this->sandbox =$params['sandbox'];
        }
        if(isset($params['gatewayUrl'])){
            $this->gatewayUrl =$params['gatewayUrl'];
        }
        $this->clientId = $params['clientId'];
        $this->merchantPrivateKey = $params['merchantPrivateKey'];
    }

    protected function getHeaders(){

    }

    public function request($httpMethod,$path,$post_data = ''){
        if($this->sandbox){
            $path = str_replace('/api/','/sandbox/api/',$path);
        }
        $reqTime = round(microtime(true) * 1000);
        $headers= [];
        $headers['signature']='algorithm=RSA256, keyVersion=1, signature='.SignatureTool::sign($httpMethod, $path, $this->clientId, $reqTime, $post_data, $this->merchantPrivateKey);
        $headers['Content-Type']='application/json; charset=UTF-8';
        $headers['client-id']=$this->clientId;
        $headers['request-time']=$reqTime;

        $_headers = [];
        foreach($headers as $k=>$v){
            $_headers[]=$k.':'.$v;
        }

        $url = $this->gatewayUrl . $path;
        if($httpMethod == 'POST'){
            //初始化
            $curl = curl_init();
            //设置抓取的url
            curl_setopt($curl, CURLOPT_URL, $url);
            //设置头文件的信息作为数据流输出
            curl_setopt($curl, CURLOPT_HEADER, 0);
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //设置post方式提交
            curl_setopt($curl, CURLOPT_POST, 1);

            curl_setopt($curl, CURLOPT_HTTPHEADER, $_headers);
            //设置post数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            //执行命令
            $data = curl_exec($curl);
            //关闭URL请求
            curl_close($curl);
            return $data;
        }

        return '-1';



    }

}