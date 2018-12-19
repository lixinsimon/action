<template>
	<view> 
		<view class="jiaoyi">
			<view class="item">
				<view class="item_zuo">
					<image src="../../../static/tu/完成.png" mode="widthFix" class="item_tu"></image>
				</view>
				<view class="item_you">
					<view class="item_tou">
						<view class="fangshi">购买连衣裙花费</view>
						<view class="shijian">
							<text class="nian">2018</text>-
							<text class="yue">01</text>-
							<text class="ri">02</text>-
							<text class="shi">15</text>：
							<text class="fen">40</text>
						</view>
					</view>
					<view class="item_wei">
						<view class="wei_title">您刚刚在看新西兰奶粉</view>
						<view class="jia_jian">10.00</view>
					</view>
				</view>
			</view>
			<view class="gengduoshuju">没有更多数据了</view>
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
	page{background-color: f3f3f3;}
	.jiaoyi{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.item{
		width: 100%;
		border-bottom: 0.1upx solid #f3f3f3;
		display: flex;
		flex-direction: row;
		width: 100%;
		height: 180upx;
	}
	.item_zuo{
		width: 20%;
		text-align: center;
		height: 180upx;
	}
	.item_you{
		width: 80%;
		height: 180upx;
	}
	.item_tu{
		width: 120upx;
		height: 120upx;
		margin-top: 25upx;
	}
	.item_tou,.item_wei{
		display: flex;
		flex-direction: row;
		width: 100%;
		height: 80upx;
		line-height: 80upx;
	}
	.fangshi{
		text-align: left;
		width: 60%;
		font-size: 30upx;
		height: 80upx;
		line-height: 80upx;
	}
	.shijian{
		width: 40%;
		text-align: right;
		font-size: 20upx;
		color: #999999;
		height: 80upx;
		line-height: 80upx;
	}
	.wei_title{
		width: 60%;
		color: #999999;
		font-size: 25upx;
	}
	.jia_jian{
		color: #f3312f;
		width: 40%;
		text-align: right;
		color: #4A7549;
	}
	.gengduoshuju{
		width: 100%;
		height: 100upx;
		line-height: 100upx;
		text-align: center;
		color: #999999;
	}
</style>
