<?php
/* *
 * 配置文件
 * 版本：1.0
 * 日期：2016-06-06
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
*/
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['partner']		= '2088711657304701';

//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$alipay_config['private_key']	= 'MIICXwIBAAKBgQCmWn1QxIEnCSMfe2RKX9FUK16BP1ALQKC4HwVNhL5fWYFkkcXXtk5mUxzFhaZ9pr0zWDXUuuTKsJizZFraUxYQnpgsM4SpmacFiajC3v/DgP7ilziedqyjLTWXkpt2r51WUs5P0T+MES+6hOpezU5jxvvrk3Db+rtNqhJ1jnSrYwIDAQABAoGBAIa0B317YUmGsJYxiIhhBlQtuhzWc65o6rutAtI+hxkWlRwmnhmKWfmpm0ambqaYeeQ1rYFQxSsLzNqWjKr1VItaaC6mzwh3mgl6n1mQwuMdaRhVaDwj6G+Wkhng5yQgq4oNe0lr9V+JNwhvMC+Q1ApDjFnfziqwgdh7BHglumbBAkEA0BgI7NMe3Q9zw4co/lEZ5o33TAooz+eMR7KQb6XRiRMIIuT0vRXXwvIjDAM82WLUqIypJXwzhGlUZ/BEP80PqQJBAMymfj4KcS0TXgnHbhNBQTrUEqU7sG0mNWiGBD85KCbokpE2/SZEs6z4t2CMXsnHk48XYO+MI47I8rGLSFr4+isCQQDJBP7SMBwXdk7hKlcKXbQEiU3Ecef89vQHatKmV+uzW+Q3OS/G3Svh0WDTwOjuIs/FxqO7Z2Co38s+4NY9P82JAkEArSCEV9PZnrptqXQvKNbhafUSuPnf7NaQBBar7RhbYV8K7xJH4mHoZoIaD/FwFt9hc4HhnYU+Z4KT3aLo2R0b9QJBALd8YkX2FyWnEnxH4z2Lsdt0V5RuvBeQIH7OUstzP9xOq6NdgEcE77XGYRkHpCoiq7WzpQPqzeuQoj1WX7JqNQ4=';

//支付宝的公钥，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['alipay_public_key']= 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB';

//异步通知接口
$alipay_config['service']= 'mobile.securitypay.pay';
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//签名方式 不需修改
$alipay_config['sign_type']    = strtoupper('RSA');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'/cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';
?>