<template>
	<view class="page">
		<navigator url="zhaohuimima" class="item">
			<text>登录密码修改</text>
			<image src="../../static/tu/向右.png" mode="widthFix" class="youjiantou"></image>
		</navigator>
		<navigator url="zhaohuimimaxiugai" class="item">
			<text>找回密码修改</text>
			<image src="../../static/tu/向右.png" mode="widthFix" class="youjiantou"></image>
		</navigator>
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
		background-color:#dcdcdc;
	}
	.item{
		width:100%;
		height: 100upx;
		position: relative;
		padding: 0upx 30upx;
		border-top:1upx solid #f3f3f3 ;
		box-sizing: border-box;
		line-height: 100upx;
		background-color:#FFFFFF;
		color: #999999;
	}
	.youjiantou{
		width: 30upx;
		height: 30upx;
		vertical-align: middle;
		position: absolute;
		right: 30upx;
		top: 35upx;
	}
	
</style>
