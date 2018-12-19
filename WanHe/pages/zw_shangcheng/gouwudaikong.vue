<template>
	<view class="car_kong">
		<view class="car_tu"><image src="http://zshidai.zhiwi.cn/gongyong/shangchuan/images//2018_11/FstzOlKb75BMLe7sGlzPte7gaSTG5z.png" mode=""></image></view>
		<view class="tishiyu">您还没有购买任何宝贝哦!</view>
		<navigator class="fanhuishouye" url="index">返回首页</navigator>
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
	.car_kong{
		width: 100%;
		margin-top: 300upx;
		box-sizing: border-box;
		text-align: center;
	}
	.car_tu{
		width: 100%;
		margin-top: 40upx;
		text-align: center;
	}
	image{
		width: 200upx;
		height: 200upx;
	}
	.tishiyu{
		color: #999999;
	}
	.fanhuishouye{
		margin-top: 40upx;
		background-color: #000000;
		color: #999999;
		font-size: 30upx;
		width: 200upx;
		height: 75upx;
		line-height: 75upx;
		margin-left: 280upx;
		border-radius: 10upx;
	}
</style>

