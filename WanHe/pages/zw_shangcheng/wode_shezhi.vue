<template>
	<view class="shezhi">
		<navigator class="zhanghaoshezhi shezhi_item" url="wode_ziliao">
			<text>个人资料</text>
			<image src="../../static/tu/向右.png" mode="widthFix" class="youjiantou"></image>
		</navigator>
		<navigator class="zhanghaoanquan shezhi_item" url="zhanghaoanquan">
			<text>账号安全</text>
			<image src="../../static/tu/向右.png" mode="widthFix" class="youjiantou"></image>
		</navigator>
		<view class="tuichuzhanghao" @click="tuichu">
			退出当前账号
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {	
		methods:{
			tuichu:function(){
				//$z.Shan('sessoin_id');				
				$z.Shan('hyid');
				$z.toast('退出成功');
				$z.post('k=denglu&x=tuichu',function(shu){
					setTimeout(function(){
						uni.switchTab({
							url:'/pages/zw_shangcheng/index'	
						})
					},500);
					
				});
				
				
			}
		}
	}
</script>

<style>
	page{ background-color: #f3f3f3;}
	.shezhi{
		width: 100%;
		box-sizing: border-box;
		padding: 30upx 30upx;
	}
	.shezhi_item{
		width: 100%;
		height: 120upx;
		border-bottom: 1upx solid #f3f3f3;
		box-sizing: border-box;
		background-color: #FFFFFF;
		line-height: 65upx;
		padding: 30upx  20upx;
		position: relative;
	}
	.shezhi_item>text{
		width: 200upx;
	}
	.youjiantou{
		width: 30upx;
		height: 30upx;
		vertical-align: middle;
		position: absolute;
		right: 0upx;
		top: 50upx;
	}
	.tuichuzhanghao{
		width: 100%;
		height: 90upx;
		text-align: center;
		line-height: 100upx;
		color: #999999;
		background-color: #1B2436;
		font-size: 35upx;
		border-radius: 5upx;
		padding: 0upx  30upx;
		margin-top:50upx;
		box-sizing: border-box;
	}
</style>
