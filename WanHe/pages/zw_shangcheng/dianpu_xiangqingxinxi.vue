<template>
	<view>
		<view class="body">
			<textarea class="body_text" v-model:value="shu.xiangqing_text" placeholder="这一刻,我想说..."></textarea>
			<view class="body_tu">
				<view class="xiangqingtu" v-for="tu in shu.xiangqing_tu">
					<image :src="tu" mode="widthFix"></image>
				</view>
				<view class="tianjia" @click="tianjia"><text style="font-size: 60upx;">+</text><view>添加详情图</view></view>
			</view>
		</view>
		
		<view class="baocun" @click="baocun"><text>保存</text></view>
		
	</view> 
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{
			shu:{'xiangqing_text':'','xiangqing_tu':[]}
		},
		
		onLoad:function(){
			if($z.Qu('xiangqing')){
				this.shu=$z.Qu('xiangqing');
			}
		},
		onShow:function(){
			this.CSH();
		},
		
		methods: {
			CSH:function(){
				
			}, 
			
			tianjia:function(){
				var _this = this;
				$z.ShangTu(function(e){
					_this.shu.xiangqing_tu.push(e.url);
				},6);
				console.log(_this.shu.xiangqing_tu)
			},
			
			baocun:function(){
				try{
					$z.Cun('xiangqing',this.shu);
					uni.navigateBack({
						delta:1
					})
				}catch(e){
					//TODO handle the exception
				}
			},
			
			
		},
		
	}
</script>

<style>
	page{width: 100vw;padding: 0;margin: 0;}
	.body{padding: 30upx;box-sizing: border-box;}
	.body_text{padding: 30upx;box-sizing: border-box;height: 330upx;}
	
	.body_tu{width: 100%;display: flex;flex-wrap: wrap;justify-content: flex-start;align-items: center;}
	.xiangqingtu,.tianjia{width: 204upx;height: 204upx;display: flex;justify-content: center;align-items: center;margin: 10upx 11upx;overflow: hidden;}
	.tianjia{border: 2upx dashed #DCDCDC;flex-direction: column;font-size: 28upx;color: #DCDCDC;}
	.xiangqingtu>image{width: 100%;}
	
	.baocun{background: black;padding: 20upx;border-radius: 10upx;margin: 20upx;display: flex;justify-content: center;align-items: center;font-size: 30upx;color: white;}
</style>
 