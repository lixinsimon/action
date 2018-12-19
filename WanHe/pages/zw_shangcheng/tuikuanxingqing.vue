<template>
	<view class="page">
		<view class="tou">
			<view class="tuikuanjieguo">退款成功</view>
			<view class="tuikuanshijian">2018年4月30日18:30</view>
		</view>
		<view class="item">
			<view>退款总金额</view>
			<view class="tkzje aa">¥ 70.80</view>
		</view>
		<view class="item">
			<view>退款余额</view>
			<view class="tkye aa">¥ 70.80</view>
		</view>
		<view class="item">
			<view>退款原因</view>
			<view class="tkyy aa">多拍/不想要</view>
		</view>
		<view class="lianxikefu">联系客服</view>
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
	}
	.tou{
		width: 100%;
		box-sizing: border-box;
		padding: 40upx 30upx;
		color: #FFFFFF;
		height: 200upx;
		background-color: #990134;
	}
	.tuikuanjieguo{
		line-height: 70upx;
		height: 70upx;
		font-size: 35upx;
	}
	.item{
		width: 100%;
		height: 100upx;
		display: flex;
		align-items: center;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.item>view{
		width: 50%;
		padding: 0 30upx;
	}
	.aa{
		text-align: right;
	}
	.tkye{
		color: #5D835D;
	}
	.tkyy{
		color: #999999;
	}
	.lianxikefu{
		width: 100%;
		height: 100upx;
		box-sizing: border-box;
		padding: 0 30upx;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		color:#990134;
	}
</style>
