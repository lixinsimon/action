<template>
	<view>
		<view class="anniu" @click="zengjia"><text>增加属性</text></view>
		<view class="shuxing_view">
			<view class="shuxing" v-for="(item,index) in shuxing">
				<input class="key" type="text" v-model:value="item.key" placeholder="属性名" placeholder-style="text-align:center"/>
				<input class="value" type="text" v-model:value="item.value" placeholder="属性值" placeholder-style="text-align:center"/>
				<icon @click="shanchu(index)" class="iconfont icon-close"></icon>
			</view>
		</view>
		<view class="anniu" @click="baocun"><text>保存</text></view>
		
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{
			shuxing:[{'key':'','value':''}]
		},
		onLoad:function(){
			if($z.Qu('shuxing')){
				this.shu = $z.Qu('shuxing');
			}
		},  
		methods: {
			zengjia:function(){
				this.shuxing.push({'key':'','value':''});
			},
			shanchu:function(index){
				this.shuxing.splice(index,1);
			},
			baocun:function(){
				$z.Cun('shuxing',this.shu);
				uni.navigateBack({
					delta:1
				})
			}
		},
		
	}
</script>

<style>
	page{padding-top: 30upx;width: 100vw;}
	.shuxing_view{width: 100vw;padding: 30upx;box-sizing: border-box;display: flex;flex-direction: column;}
	.shuxing{width: 100%;margin-bottom: 34upx;display: flex;justify-content: space-between;position: relative;}
	.key,.value{width: 333upx;height: 86upx;border: 1upx solid #F0F0F0;border-radius: 10upx;}
	.shuxing>icon{font-size: 30upx;position: absolute;top: -30upx;right: -10upx;}
	
	.anniu{width: 710upx;height: 82upx;margin: 0 auto; border: 1upx solid #000000;display: flex;justify-content: center;align-items: center;
					border-radius: 10upx;padding: 27upx;box-sizing: border-box;font-size: 30upx;}
</style>
