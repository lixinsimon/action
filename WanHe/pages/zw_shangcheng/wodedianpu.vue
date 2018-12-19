<template>
	<view>
		<view class="tou">
			<view class="touxiang_tu">
				<image src="../../../static/tu/余额支付.png" mode="widthFix" style="width: 80upx; height: 80upx;"></image>
			</view>
			<view class="dianpu_xiangqing">
				<view class="dianpu_title">
					<text class="jibie">企业家</text>
					<text class="mingcheng">店名限制十个字</text>
				</view>
				<view class="gonggao">这里显示店铺公告为十五个字</view>
			</view>
		</view>
		<view class="nav">
			<view class="nav-bar active" data-index="0">综合</view>
			<view class="nav-bar"  data-index="1">销量</view>
			<view class="nav-bar"  data-index="2">新品</view>
			<view class="nav-bar"  data-index="3">价格</view>
			<view class="tubiao" >
				<image src="../../../static/tu/箭头向上.png" mode="widthFix" class="tu tu_shang"></image>
				<image src="../../../static/tu/箭头向上-拷贝.png" mode="widthFix" class="tu tu_xia"></image>
			</view>
		</view>
		<view class="body">
			<view class="item">
				<view class="item_tu">
					<image src="../../../static/tu/示例图.jpg" mode="widthFix" class="image"></image>
				</view>
				<view class="title">达娜妮时尚女装职业套装地方GV地方个省份过生日个</view>
				<view class="jiage_yishou">
					<view class="jiage">¥1999</view>
					<view class="yishou">已售5933</view>
				</view>
			</view>
			<view class="item">
				<view class="item_tu">
					<image src="../../../static/tu/示例图.jpg" mode="widthFix" class="image"></image>
				</view>
				<view class="title">达娜妮时尚女装职业套装地方GV地方个省份过生日个</view>
				<view class="jiage_yishou">
					<view class="jiage">¥1999</view>
					<view class="yishou">已售5933</view>
				</view>
			</view>
			<view class="item">
				<view class="item_tu">
					<image src="../../../static/tu/示例图.jpg" mode="widthFix" class="image"></image>
				</view>
				<view class="title">达娜妮时尚女装职业套装地方GV地方个省份过生日个</view>
				<view class="jiage_yishou">
					<view class="jiage">¥1999</view>
					<view class="yishou">已售5933</view>
				</view>
			</view>
			<view class="item">
				<view class="item_tu">
					<image src="../../../static/tu/示例图.jpg" mode="widthFix" class="image"></image>
				</view>
				<view class="title">达娜妮时尚女装职业套装地方GV地方个省份过生日个</view>
				<view class="jiage_yishou">
					<view class="jiage">¥1999</view>
					<view class="yishou">已售5933</view>
				</view>
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
	.tou{
		display: flex;
		width: 100%;
		padding: 0 30upx;
		height: 200upx;
		align-items: center;
		box-sizing: border-box;
		background-color: #000000;
		color: #FFFFFF;
	}
	.touxiang_tu{
		border-radius: 50%;
		width: 15%;
	}
	.dianpu_xiangqing{
		width: 85%;
	}
	.dianpu_title{
		height: 35upx;
		line-height: 35upx;
	}
	.jibie{
		display: inline-block;
		box-sizing: border-box;
		border:1upx solid #f3312f;
		color: #f3312f;
		font-size: 22upx;
		height: 35upx;
		line-height: 35upx;
		border-radius: 5upx;
	}
	.mingcheng{
		display: inline-block;
		box-sizing: border-box;
		height: 35upx;
		line-height: 35upx;
	}
	.gonggao{
		font-size: 22upx;
		height: 35upx;
		line-height: 35upx;
	}
	.nav{
		display: flex;
		box-sizing: border-box;
		width: 100%;
		height: 60upx;
		align-items: center;
		padding: 0 30upx;
	}
	.nav-bar{
		display: flex;
		justify-content: center;
		width: 25%;
		color: #999999;
	}
	.tu{
		width: 15upx;
		height: 15upx;
	}
	.active{
		color: #000000;
	}
	.tubiao{
		width: 10upx;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.tu_xia{
		margin-top: 5upx;
	}
	.image{
		width: 100%;
		height: 100%;
	}
	.body{
		display: flex;
		flex-wrap: wrap;
		width: 100%;
		box-sizing: border-box;
	}
	.item{
		width: 46%;
		margin-left: 20upx;
		margin-top: 10upx;
	}
	.title{
		overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
	}
	.jiage_yishou{
		display: flex;
		height: 50upx;
		line-height: 50upx;
		width: 100%;
	}
	.jiage{
		color: #f3312f;
		width: 50%;
	}
	.yishou{
		width: 50%;
		text-align: right;
		color: #999999;
		font-size: 20upx;
	}
</style>
