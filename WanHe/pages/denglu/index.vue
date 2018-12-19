
<template>
	<view class="index">
		<view class='logo'>
			<view class="weixintubiao"><icon class="iconfont icon-weixin3"/></view>
		 
			<view class='z2'>该小程序授权，向其提供以下权限即可继续操作</view>
			</view>
			<view class='z1'> 获得你的公开信息（昵称、头像）</view> 
			<view  class='hezi'>
			   <button  open-type="getUserInfo" lang="zh_CN" class='denglu'  @getuserinfo='shouquan'>授权登录</button>			  
			</view >
	</view> 
</template>
<style>	 
	.logo{width: 100%;position: relative;height:400rpx;background: #1AAD19;text-align: center;}
	.logo image{width: 100%; margin: 0px auto;display: block;height:400rpx}
	.z2{position: absolute;bottom: 60rpx;color: #FFF;text-align: center;width: 100%;font-weight: bold}
	.z1{padding:40rpx;color: #222;display: block;width: 100%;}
	.hezi{width: 100%;display: block;} 
	.hezi button{width: 90%;margin: 0px auto;background: #04be01;color: #FFF}
	.weixintubiao{color: #FFF;padding-top: 50upx;}
	.icon-weixin3{font-size: 200upx;}
</style>
<script>
	import $z from '@/zhiwi'
	export default {
		data:{
			code:''
		},
		onLoad:function(e){
			this.code=e.code;		
		},
		methods:{	
			shouquan:function(e){
				console.log(e.detail.errMsg) 
					if(e.detail.errMsg=='getUserInfo:ok'){					 
					 var shu={tid:$z.Qu('tid'),code: this.code,encryptedData: e.detail.encryptedData,iv: e.detail.iv,signature: e.detail.signature}
					 $z.post('k=denglu&c=xiaochengxu',shu, function (shu) {					 
								if (shu.shi == 1) {													
									$z.Cun('kouling', shu.shu.kouling);
									$z.Cun('hyid', shu.shu.id);
									$z.go();
								} else {
										$z.toast(shu.shu, 0);
								};
					 });					 
				 }else{
					  $z.toast('请先授权');
				 }				
			}
		}
	}
</script>
