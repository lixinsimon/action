<template>
	<view>
		<form action="">
			<view class="page">
				<text>新密码</text><input type="password" placeholder="请输入6位以上字母数字" class="xinmima"/>
				<text>确认密码</text><input type="password"  class="qurenmima"/>
				<text>手机号码</text><input type="phone"   class="shoujihaoma"/>
				<navigator url="" class="wancheng">完成</navigator>
			</view>
			
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
	.page{
		width: 100%;
		box-sizing: border-box;
		padding: 0upx 30upx;
		border-top: #f3f3f3;
		border-bottom: #f3f3f3;
	}
	input{
		display: inline-block;
		width:550upx;
		height: 120upx;
		vertical-align: middle;
		box-sizing: border-box;
		margin-left: 15upx;
	}
	text{
		display: inline-block;
		height: 120upx;
		line-height: 120upx;
		box-sizing: border-box;
	}
	.qurenmima{
		border-top: #f3f3f3;
	}
	.wancheng{
		border-radius: 10upx;
		color: #FFFFFF;
		background-color: #1B2436;
		font-size: 35upx;
		text-align: center;
		width: 100%;
		padding: 0upx 30upx;
		box-sizing: border-box;
		display: inline-block;
		height: 100upx;
		line-height: 100upx;
	}
</style>
