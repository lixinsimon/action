<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2015121901008041",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDiLdRYc95zvwjR
MZgRoVh9/gKdoe+v6S/8W4ARyX/gLvdugvA+0ZOj6G+9aY5bofT4WNOnw8yvVXlI
OMXwP3rV1IkbvpEJo0DD2E/PhS6ZT5TcFAZvXKJi+mr1DQEbvhADTEpDXE2PqjQl
SL/T1EZR4MM3S7aElsiOm9e5S+AiuAn7M1DvLHmDaBsL4fhCTwgVKIHpC5HxZ9wC
JQKpBQqWPRWo+7CcftWnxtjdRP758/Tk8DaFeMmK0031sjNgqji2McIfXifTu8Ka
TFdSe1a+kU/DFpMbWcQJL5CRVBVy/qNMSqpOHv0pOlRzuNwZHSI09fTiNQceNFG2
TnRqVfAxAgMBAAECggEAMhuDGqF4292rn2TEUsuS5j66558zkZ4wklDXG5mvacQd
7u61OMWHVt2su6LB9gz4T3imU1luZD2kY9qoB2SY2vx975aVXTQ8qeanL8tKmo5l
5SfOkSdNlm3x+h4Ka9H8jC5/mVK+oCBN8yCd1tkFRyhrNznf0pnxDp75+MQVgLso
Ygb6yUvOdT0J/5ClbSTU18f+ZffRgZbGSu1o6w+F9WD9PLek9rFfvxhyLiUrqmd/
ZExJ4HyOnv7/9T4V92uzg/6ARJ32H0K0HHR/gm6TuR/jSnm58ZAFoH+S+jRhddYV
kJVYLrWukvf6g1SS9YSjF2wyN5qU7wyRbUsDLx2twQKBgQDz71FH0kuPhRiQLyX+
HqBV190AfWZdSVH8ndmXNFTegWJt/KTvkAfWgtg71SET5QRO0fnCLSoJVlpUFUFe
yT//hwqQ05r1dwapES6JoSVDaot8D0hw9HdJTLR68Jh63OQw7bBYyi0UTwz0LONU
ZFQBcm9hOsxQPApX55MN8k8C+QKBgQDtXbB5osQbiemkfRYqUFuGqOgFsmqoqxz6
/cByTm+6BXZV1I9JwwV0vewRzG6TZ644P12rZW+UbrNJQIRhdndpzRnSpRmiO9Oh
xps4lF1+8SYjo8cArl6/NcSsHxh10dTGf3z7l+gnb0OnjsV61Unm32tpf8sXg4GU
xzsMS9Ns+QKBgG92OROyWeh4jqLDiH63i9ftzQQ+SJnzuMzPa++Vb/pD8LAFM3Br
xckU/K1KU9T9XpyNgaxiasTdemTVWYtwNhgSopdOuY3UF20FdthYk+hcNOQ5L4a9
jgwmSomqimIJsRNSaLQJndOb03V3VWDofyIyIgaxkU5QQQGtxRooUEYxAoGBAOXb
nFGt9QpV+xN2rkg7mOZGGqmppO/BBEdqAzquCjOxpm5ncHqViGsMn9Z8iXflJykA
88xOZkbvDF8bQxa+idTC8QazKqeYF9DJavbXddK/45cPul5GfSnc/59OXXl6wPmX
64gYCpBlhrZz43iXowEXygRX5GvYxVs1s1Cs/QjBAoGBALxvsBFxauEi0iW/mFXU
BjjwF7Kki0tqMzrFFc/Pa+joNu5NbUDyPkgTO7yYnwj2p9PnwfcxaGLe58DXs0Wp
W06BPcqrU5vmi0LSRGKfo612NBKP4CwYPXuRxsMEqf3TMKgLU8KPWRylm/o/fh51
IWNoIT6vLqGu6IbAHWRmuFuo",
		
		//异步通知地址
		'notify_url' => "http://test.heodo.com/neihe/ku/zhifubao/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://test.heodo.com/notify_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB",
		
	
);