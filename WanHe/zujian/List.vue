<template>
	<view>
		  <view class="sou-box">
				<navigator url="" class="left_icon">
					<icon class="iconfont icon-arrow-down"></icon>
				</navigator>
		  	<view class="sousuokuang">
		  		<input type="text" value="" placeholder="搜索商品"/>
		  	</view>
				<navigator url="" class="sousuo">
					<icon class="iconfont icon-sousuo1"></icon>
				</navigator>
		  </view>
			<view class="rongqi">
				 <scroll-view class="zuobianlan" scroll-y="true">
						<view class>
                 <view class="name">123</view>
            </view>
				 </scroll-view>
				 <scroll-view class="youbianlan"scroll-y="true">
				 	 1635156
				 </scroll-view>
			</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		props: ['lie']
	}
</script>

<style>
	navigator,input {display: inline-block;}
	
	.sou-box{
		padding: 10upx 0upx 10upx 0upx;
		width: 100%;
		height: 60upx;
		background-color: #000000;
		display: flex;
		flex-wrap: wrap;
	}
	.left_icon{
		width: 100upx;
	}
	.icon-arrow-down{
		width: 37upx;
		height: 55upx;
		color: #FFFFFF;
		font-size: 40upx;
		transform: rotate(90deg);
		margin-left: 40upx;
	}
	.icon-sousuo1{
		width: 50upx;
		height: 50upx;
		color: #FFFFFF;
		margin-left: 40upx;
		font-size: 40upx;
	}
	.sousuokuang{
		display: inline-block;
		background-color: #FFFFFF;
		border-radius: 10upx;
		width: 540upx;
		text-align: center;
	}
	input{width: 200upx;}
	
</style>

