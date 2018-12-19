<template>
	<view>
	<page-head :title="title"></page-head>
		<view class="uni-padding-wrap">
			<!-- 评论区 start -->
			<view class="uni-xiaoxi">
				<view class="uni-xiaoxi-list">
					<view class="uni-xiaoxi-face"><image src="http://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/eJc4UU1Jj12J1hKInu1hmbIsEb1KCO.png" mode=""></image></view>
					<view class="uni-xiaoxi-body">
						<view class="uni-xiaoxi-top">
							<text>网友</text>
						</view>
						<view class="uni-xiaoxi-date">
							<text>08/10 08:12</text>
						</view>
						<view class="uni-xiaoxi-content">很酷的HBuilderX和uni-app，开发一次既能生成小程序，又能生成App</view>
					</view>
				</view>
				<view class="uni-xiaoxi-list">
					<view class="uni-xiaoxi-face"><image src="http://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/eJc4UU1Jj12J1hKInu1hmbIsEb1KCO.png" mode=""></image></view>
					<view class="uni-xiaoxi-body">
						<view class="uni-xiaoxi-top">
							<text>马克一天</text>
						</view>
						<view class="uni-xiaoxi-content">很强大，厉害了我的uni-app!</view>
					</view>
				</view>
				<view class="uni-xiaoxi-list">
					<view class="uni-xiaoxi-face"><image src="http://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/eJc4UU1Jj12J1hKInu1hmbIsEb1KCO.png" mode=""></image></view>
					<view class="uni-xiaoxi-body">
						<view class="uni-xiaoxi-top">
							<text>今生缘</text>
						</view>
						<view class="uni-xiaoxi-content">好牛逼的感觉，是不是小程序、App、移动端都互通了？</view>
						<view class="uni-xiaoxi-date">
							<text>08/10 07:55</text>
						</view>
					</view>
				</view>
				<view class="uni-xiaoxi-list">
					<view class="uni-xiaoxi-face"><image src="http://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/eJc4UU1Jj12J1hKInu1hmbIsEb1KCO.png" mode=""></image></view>
					<view class="uni-xiaoxi-body">
						<view class="uni-xiaoxi-top">
							<text>小猫咪</text>
						</view>
						<view class="uni-xiaoxi-content">支持国产，支持DCloud!</view>
						<view class="uni-xiaoxi-date">
							<view>2天前</view><view class="uni-xiaoxi-replay-btn">5回复</view>
						</view>
					</view>
				</view>
			</view>
			<!-- 评论区 end -->
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			title:"评论界面"
		}
	}
}
</script>

<style>
	page{
		background-color:#F4F5F6;
		height:100%;
		font-size:28rpx;
		line-height:1.8;

	}
.uni-xiaoxi image{
	width:100%;
border-radius:100%;
height: 70upx;
}
.uni-xiaoxi-face{
	width:70rpx;
height:70rpx;
border-radius:100%;
margin-right:20rpx;
-webkit-flex-shrink:0;
flex-shrink:0;
overflow:hidden;

}
.uni-xiaoxi-list{
		flex-wrap:nowrap;
		padding:10rpx 0;
		margin:10rpx 0;
		width:100%;
		display:flex;

}
.uni-xiaoxi-body{
	width:90%;
	float:left;
	margin-bottom:20upx;
	}
	.uni-xiaoxi-top{
		line-height:1.5em;
		box-pack:justify;
		justify-content:space-between;

	}
	.uni-xiaoxi-top text{
		color:#0A98D5;
		font-size:24rpx;

	}
	.uni-xiaoxi-date{
		line-height:38rpx;
		box-orient:horizontal;
		flex-direction:row;
		box-pack:justify;
		justify-content:space-between;
		display:flex !important;
		box-flex:1;
		flex-grow:1;
		flex-grow:1;

	}
	.uni-xiaoxi-content{
		line-height:1.6em;
		font-size:28upx;
		padding:8upx 0;
	}
	.uni-xiaoxi-replay-btn{
		background:#FFF;
		font-size:48rpx;
		line-height:28upx;
		padding:5upx 20upx;
		border-radius:30upx;
		color:#333 !important;
		margin:0 20upx;
		font-size:24rpx;
		line-height:38rpx;
	}
</style>
