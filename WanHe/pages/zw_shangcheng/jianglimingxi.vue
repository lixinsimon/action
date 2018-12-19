<template>
	<view> 
		<view class="jiangli">
			<view class="item">
				<view class="item_tou">
					<view class="fangshi">介绍会员“你过来就好”加入会员获取佣金</view>
					<view class="shijian">
						<text class="nian">2018</text>-
						<text class="yue">01</text>-
						<text class="ri">02</text>-
						<text class="shi">15</text>：
						<text class="fen">40</text>
					</view>
				</view>
				<view class="item_wei">
					<view class="jia_jian">-10.00</view>
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
	.jiangli{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.item{
		width: 100%;
		height: 120upx;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.item_tou,.item_wei{
		display: flex;
		flex-direction: row;
		width: 100%;
		height: 80upx;
	}
	.fangshi{
		text-align: left;
		width: 70%;
		font-size: 25upx;
		height: 80upx;
		line-height: 80upx;
	}
	.shijian{
		width: 30%;
		text-align: right;
		font-size: 17upx;
		color: #999999;
		height: 80upx;
		line-height: 80upx;
	}
	.jia_jian{
		color: #f3312f;
		width: 100%;
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
