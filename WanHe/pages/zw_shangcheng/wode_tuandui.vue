<template>
	<view>
		<view class="tuandui" v-for="t in shu.lie">
			<view class="tuandui_zuo">
				<image class="tu" :src="t.touxiang" ></image>
			</view>
			<view class="tuandui_you">
				<view class="tuandui_title">
					<text class="tuandui_jibie">{{t.dengjiming}}</text>
					<text class="tuandui_nicheng">{{t.nicheng}}</text>
				</view>
				<view class="tuandui_shijian">
					{{t.shijian}}
				</view>
			</view>
		</view>
		
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{},
		},
		
		onShow:function(){
			this.CSH();
		},
		
		methods:{
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=fenxiao&x=wodetuandui',function(shu){
					
					if(shu.shi==1){
						_this.shu = shu.shu;
					}
									
				});
			}
		}
	}
</script>

<style>
	.tuandui{
		display: flex;
		flex-direction: row;
		width: 100%;
		height: 150upx;
		box-sizing: border-box;
		padding: 30upx 30upx;
		border-top: 1upx solid #f3f3f3;
		border-bottom: 1upx solid #f3f3f3;
	}
	.tuandui_zuo{
		width: 90upx;
		height: 90upx;
		margin-right: 25upx;
		background-color: #dcdcdc;
	}
	.tuandui_you{
		width:600upx;
	}
	.tuandui_title{
		margin-bottom: 10upx;
	}
	.tuandui_jibie{
		display: inline-block;
		width: 120upx;
		height: 45upx;
		text-align: center;
		line-height: 45upx;
		border: 1upx solid #f3312f;
		color: #f3312f;
		font-size: 28upx;
		margin-right: 10upx;
		border-radius: 5upx;
		box-sizing: border-box;
	}
	.tuandui_nicheng{
		display: inline-block;
		height: 35upx;
		line-height: 35upx;
		box-sizing: border-box;
	}
	.tuandui_shijian{
		font-size: 25upx;
		color: #999999;
	}
	.tu{width: 100%;height: 100%;}
</style>
