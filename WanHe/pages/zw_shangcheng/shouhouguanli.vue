<template>
	<view>
		<view class="item"> 
			<view class="tou">
				<view class="shangpin_tu">
					<image src="http://zshidai.zhiwi.cn/gongyong/shangchuan/images//2018_11/bKO8SKAS98kK998ASVBZv0U818O7su.jpg" mode=""></image>
				</view>
				<view class="xiaingqing">
					<view class="title">国外产品海外代购代购</view>
					<view class="guige">儿童 150克</view>
					<view class="jiage">
						<view class="xianjia">35.40</view>
						<view class="yuanjia">45.40</view>
						<view class="geshu">X1</view>
					</view>
				</view>
			</view>
			<view class="zongji">
				共<text>1</text>件
				应付总额：<text class="zongjiage">¥35.40</text>
				(含运费 <text>0.00</text>)
			</view>
			<view class="xinxi">
				<view class="liuyan">
					<text>买家留言：</text>
					<text class="neirong">东西不好东西不好东西不好东西不好东西不好东西不好东西不好东西不好东西不好东西不好</text>
				</view>
				<navigator url="" class="zhaungtai_">
					<view class="zhuangtai active">立即发货</view>
				</navigator>
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
	page{
		background-color: #f3f3f3;
	}
	.tou{
		display: flex;
		align-items: center;
		justify-content: center;
		background-color: #FFFFFF;
		border-top: 0.1upx solid #f3f3f3;
		padding: 0 30upx;
		height: 180upx;
		box-sizing: border-box;
	}
	.shangpin_tu{
		width: 25%;
		display: flex;
		align-items: center;
		justify-content: center;
		height: 180upx;
	}
	.shangpin_tu>image{
		width: 120upx;
		height: 120upx;
	}
	.xiaingqing{
		width: 75%;
		height: 180upx;
	}
	.title{
		width: 100%;
		overflow: hidden;
		height: 50upx;
		line-height: 50upx;
		margin-top: 15upx;
	}
	.guige{
		width: 100%;
		overflow: hidden;
		height: 50upx;
		line-height: 50upx;	
	}
	.jiage{
		width: 100%;
		height: 60upx;
		display: flex; 
		align-items: center;
	}
	.xianjia{
		width: 18%;
		color: #f3312f;
	}
	.yuanjia{
		width: 12%;
		color: #999999;
		text-decoration: line-through;
		font-size: 20upx;
	}
	.geshu{
		width: 70%;
		text-align: right;
	}
	.zongji{
		width: 100%;
		height: 80upx;
		text-align: right;
		line-height: 80upx;
		padding: 0 30upx;
		color: #999999;
		border-top: 0.1upx solid #f3f3f3;
		background-color: #FFFFFF;
		box-sizing: border-box;
	}
	.zongjiage{
		color: #f3312f;
	}
	.xinxi{
		width: 100%;
		padding: 0 30upx;
		height: 100upx;
		background-color: #FFFFFF;
		display: flex;
		align-items: center;
		margin-top: 10upx;
		margin-bottom: 30upx;
		box-sizing: border-box;
	}
	.liuyan{
		width: 80%;
		height: 80upx;
		text-overflow: ellipsis;
		overflow: hidden;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
	}
	.neirong{
		color: #999999;
	}
	.zhaungtai_{
		width: 20%;
	}
	.zhuangtai{
		width: 150upx;
		height: 60upx;
		border-radius: 10upx;
		text-align: center;
		line-height: 60upx;
		border: 1upx solid #999999;
		color: #999999;
	}
	.active{
		background-color: #000000;
		color: #FFFFFF;
	}
</style>
