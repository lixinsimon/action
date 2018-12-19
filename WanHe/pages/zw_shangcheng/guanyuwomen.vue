<template>
	<view>
		<view class="guanyu">
			<view class="guanyu_tilte" style="text-align: center;font-size: 40upx;">
				{{shu.biaoti}}
			</view>
			<view class="shijian" style="color: #999999;text-align: center;font-size: 30upx;">
				{{shu.shijian}}
			</view>
			<rich-text v-html="shu.neirong" class="guanyu_neirong">
				
			</rich-text>
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{
			shu:{}
		},
		onShow:function(){
			this.CSH();
		},
		methods:{
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=wode&x=kefu',function(shu){
					_this.shu = shu.shu.zhengwen;
					$z.L(shu.shu); 
				});
			
			}, 
		}
	}
</script>

<style>
	.guanyu{
		width: 100%;
		box-sizing: border-box;
		padding: 30upx 30upx;
		text-align: center;
	}
</style>
