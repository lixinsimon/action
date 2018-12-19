<template>
	<view>
		<form action="">
			<view class="item">
				<view class="quhao">+86</view>
				<input type="phone" class="phone" placeholder="请输入手机号码"/>
			</view>
			<view class="item">
				<input type="text"  class="yanzhengma" placeholder="请输入验证码"/>
				<view class="huoqu">获取验证码</view>
			</view> 
			<navigator url="zhaohuimima1" class="xiayibu">下一步</navigator>
		</form>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			};
		}
	}
</script>

<style>
	.item{
		width: 100%;
		box-sizing: border-box;
		height: 100upx;
		padding: 0upx 30upx;
		border-top: 1upx solid #f3f3f3;
		border-bottom: 1upx solid #f3f3f3;
		line-height: 100upx;
	}
	.quhao{
		display: inline-block;
		height: 100upx;
		line-height: 100upx;
	}
	.phone{
		display: inline-block;
		margin-left:25upx;
		vertical-align: middle;
	}
	.yanzhengma{
		vertical-align: middle;
		display: inline-block;
	}
	.huoqu{
		display: inline-block;
		height: 70upx;
		width: 155upx;
		float: right;
		text-align: center;
		line-height: 70upx;
		border-radius: 10upx;
		background-color:#1B2436  ;
		clear: both;
		margin-top: 11upx;
		color: #f3f3f3;
	}
	.after{
		background-color: #dcdcdc;
	}
	.xiayibu{
		display:block;
		width: 100%;
		height: 90upx;
		box-sizing: border-box;
		border-radius: 10upx;
		color: #999999;
		text-align: center;
		line-height: 90upx;
		background-color: #1B2436;
		margin-top: 40upx;
		padding: 0upx 30upx;
	}
</style>
