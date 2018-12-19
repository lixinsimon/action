<template>
	<view>
		<view class="tou">
			<view class="sousuo_zuo">
				<view class="sousuotu">
					<image src="../../static/tu/放大镜%20.png" mode="" class="fdj_tu" @click="sousuo"></image>
				</view>
				<input type="text" placeholder="请输入要搜索的内容" />
			</view>
			<view class="sousuo_you" @click="quxiao">取消</view>
		</view>
		<view class="zuijinsousuo">
			<view style="height: 50upx;line-height: 50upx;margin: 30upx 0upx;">最近搜索</view>
			<view class="sousuolishi">
				<view class="item"><text>男装</text></view>
				<view class="item"><text>奢侈品</text></view>
			</view>
		</view>
		<view class="tansuofaxian">
			<view style="height: 50upx;line-height: 50upx;margin: 30upx 0upx;">探索发现</view>
			<view class="liebiao">
				<view class="item"><text>奢侈品</text></view>
				<view class="item"><text>奢侈品</text></view>
				<view class="item"><text>奢侈品</text></view>
				<view class="item"><text>奢侈品</text></view>
				<view class="item"><text>奢侈品</text></view>
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

<style                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           >
	.tou{
		width: 100%;
		height: 60upx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		padding: 0 30upx;
	}
	.fdj_tu{
		width: 35upx;
		height: 35upx;
		vertical-align: middle;
		margin-left: 10upx;
	}
	.sousuo_zuo{
		width: 80%;
		height: 60upx;
		display: flex;
		align-items: center;
		border-radius: 40upx;
		background-color: #f3f3f3;
	}
	.sousuo_zuo>input{
		width: 500upx;
		height: 60upx;
	}
	.sousuo_you{
		width: 20%;
		text-align: center;
		height: 60upx;
		line-height: 60upx;
	}
	.zuijinsousuo,.tansuofaxian{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.sousuolishi,.liebiao{
		display: flex;
		width: 100%;
		flex-wrap: wrap;
	}
	.item{
		width: 25%;
		margin-bottom: 20upx;
	}
	.item>text{
		width: 100upx;
		height: 50upx;
		background-color: #f3f3f3;
		border-radius: 10upx;
		overflow: hidden;
		display: inline-block;
		height: 50upx;
		line-height: 50upx;
		width: 120upx;
		text-align: center;
	}
</style>
