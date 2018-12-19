<template>
	<view>
		<view class="nav">
			<view class="nav-bar" data-index="0">全部</view>
			<view class="nav-bar" data-index="1">待付款</view>
			<view class="nav-bar" data-index="2">待发货</view>
			<view class="nav-bar" data-index="3">已发货</view>
			<view class="nav-bar active" data-index="4">待评价</view>
		</view>
		
		<view class="item">
			<view class="dingdanxiangqing">
				<view class="d_d_bianhao">订单编号: DG201833236423</view>
				<view class="d_d_jieguo">交易成功</view>
			</view>
			<view class="item_tou">
				<view class="item_tu">
					<image src="../../../static/tu/联系客服.png" mode="widthFix" class="tu"></image>
				</view>
				<view class="items_xiangqing">
					<view class="title">国外产品国外产品国外产品</view>
					<view class="leixing">儿童 150克</view>
					<view class="jiege-shuliang">
						<view class="xianjia">¥35.40</view>
						<view class="yuanjia">¥48.8</view>
						<view class="shuliang">X1</view>
					</view>
				</view>
			</view>
			<view class="item_wei">
				<view class="jianshu">共1件</view>
				<view class="zongjine">应付总金额：
					<text>¥35.50</text> 
				</view>
				<view class="yunfei">(含运费0.00)</view>
			</view>
			<view style="display: flex; align-items: center;justify-content: flex-end;padding: 0 30upx;">
				<navigator url="qupingjia" class="qupingjia">去评价</navigator>
			</view>
		</view>
		
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
	.nav{
		width: 100%;
		border-bottom: 0.1upx solid #f3f3f3;
		color: #999999;
		height: 80upx;
		display: flex;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.nav-bar{
		width: 20%;
		display: flex;
		justify-content: center;
		align-items: center;
		font-size: 30upx;
	}
	.active{
		color: #000000;
		border-bottom: 5upx solid #000000;
	}
	.dingdanxiangqing{
		display: flex;
		box-sizing: border-box;
		align-items: center;
		height: 70upx;
		padding: 0 30upx;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.d_d_bianhao{
		width: 70%;
		color: #999999;
	}
	.d_d_jieguo{
		width: 30%;
		text-align: right;
	}
	.item{
		width: 100%;
		height: 450upx;
		box-sizing: border-box;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.item_tou{
		height: 200upx;
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
		display: flex;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.item_tu{
		width: 30%;
	}
	.tu{
		width: 160upx;
		height: 160upx;
	}
	.items_xiangqing{
		width: 70%;
		padding: 25upx 0upx;
	}
	.items_xiangqing>view{
		height: 50upx;
		line-height: 50upx;
	}
	.leixing{
		color: #999999;
		font-size: 20upx;
	}
	.jiege-shuliang{display: flex;}
	.xianjia{
		width: 20%;
		color: #f3312f;
	}
	.yuanjia{
		width: 20%;
		font-size: 20upx;text-decoration: line-through;
		color: #999999;
	}
	.shuliang{
		width: 60%;
		text-align: right;
	}
	.item_wei{
		height: 100upx;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		color: #999999;
		font-size: 25upx;
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.zongjine>text{
		color: #f3312f;
		font-size: 30upx;
	}
	.qupingjia{
		height: 65upx;
		width: 120upx;
		background-color: #000000;
		color: #FFFFFF;
		text-align: center;
		line-height: 65upx;
		border-radius: 10upx;
	}
</style>
