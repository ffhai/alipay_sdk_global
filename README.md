# alipay_sdk_global
国际版支付宝API调用 精简版

## 官网
### https://www.antom.com/

```php
$merchantPrivateKey= '';
$alipayPublicKey= '';
$client_id = '';
$sandbox = true;

$client = new \alipay\AlipayExtend([
    'gatewayUrl'=>'https://open-de-global.alipay.com',
    'clientId'=>$client_id,
    'merchantPrivateKey'=>$merchantPrivateKey,
    'sandbox'=>$sandbox
]);
$currency = 'USD';
$amount = 100;
$order_id = uniqid('ORDER_');
$request_id = 'RQ_'.$order_id;
$ip = '127.0.0.1';

$payItem = [];
$payItem['order'] = [
    'orderAmount'=>[
        'currency'=>$currency,
        'value'=>''.($amount * 100)
    ],
    'referenceOrderId'=>$order_id,
    'orderDescription'=>'Payment - '.$order_id,
    'env'=>[
        "osType"=>"ANDROID",
        'terminalType'=>'WAP',
        'clientIp'=>$ip
    ],
    'buyer'=>[
        'buyerEmail'=>'15345846@qq.com'
    ]

];
$payItem['paymentRequestId'] = $request_id;
$payItem['paymentAmount'] = [
    'currency'=>$currency,
    'value'=>($amount * 100).''
];
$payItem['paymentMethod'] = [
    'paymentMethodType'=>'CARD'
];
$payItem['paymentFactor'] = [
    'isAuthorization'=>true,
    //'captureMode'=>'AUTOMATIC'
];
$payItem['paymentRedirectUrl'] = url('/',[],'',true)->build();
$payItem['paymentNotifyUrl'] = url('notify/alipay',[],'',true)->build();
$payItem['productCode'] = 'CASHIER_PAYMENT';

$ret = $this->client->request('POST',"/ams/api/v1/payments/pay",json_encode($payItem));
var_dump(ret);

```
