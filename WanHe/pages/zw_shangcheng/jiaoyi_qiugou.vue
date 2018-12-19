<template>
	<view>
		<view class="tou"><text></text></view>
		
		<view class="body">
			<view class="body_biaoti">和券</view>
			<view class="body_shurukuang">
				<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/k12uH1U2w1Ne433Fzyz4y3G2G2nYdu.png" mode="widthFix"></image>
				<input type="text" v-model:value="shuliang"  placeholder="求购数量"/>
			</view>
		</view>
		
		<view class="body">
			<view class="body_biaoti">价格</view> 
			<view class="body_shurukuang">
				<image style="width: 34upx;height: 44upx;margin:0 8upx;" src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/EShN9h7knH7f8l18W8HBk8H7WL8hhz.png" mode="widthFix"></image>
				<input type="text" v-model:value="jiage" placeholder="请输入购买金额"/>
			</view>
		</view>	
		<view class="anniu_tijiao" @click="tijiao"><text>提交</text></view>
		<view class="tishi">
			<text>确认提交即代表您同意</text>
			<text class="xuzhi">《交易权益须知》</text>
		</view>		
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shuliang:'',
			jiage:'',
			shoukuan:'',
			shu:''
		},
		onShow:function(){
			this.CSH();
			
		},
		methods: {
			CSH:function(){
				var that=this;
				this.shuliang='';
				this.jiage='';
				$z.post('m=zw_shangcheng&k=jiaoyi',function(s){				
					that.shu=s.shu;   
				})
			},
			tijiao:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=jiaoyi',{shuliang:that.shuliang,jiage:that.jiage,shoukuan:that.shoukuan,c:'qiugou'},function(shu){
					$z.toast(shu.shu);
					if(shu.shi){
						setTimeout(function(){
							uni.navigateTo({
								url:'jiaoyi_jilu'
							})
						},500)
						
					}
					
				})
				
			}
		},
		
	}
</script>

<style>
	.tou{width: 100vw;padding: 40upx;box-sizing: border-box;display: flex;align-items: center;justify-content: center;color: #333333;font-size: 32upx;}
	.body{width: 100%;padding: 0 60upx 80upx 60upx;font-size: 30upx;color: #333333;box-sizing: border-box;}
	.body_biaoti{margin-bottom: 30upx;}
	.body_shurukuang{width: 100%;height: 146upx;margin: 0 auto;display: flex;justify-content: center;
						border: 1upx solid #F0F0F0;border-radius: 5upx;align-items: center;padding: 53upx 21upx;box-sizing: border-box;}
	.body_shurukuang>image{width: 50upx;height: 39upx;}
	.body_shurukuang>input{flex-grow: 1;margin-left: 53upx;}
	
	.anniu_tijiao{width: 710upx;margin: 0 auto;background: #1c2536;color: white;font-size: 30upx;padding: 27upx;display: flex;
					justify-content: center;align-items: center;box-sizing: border-box;border-radius: 10upx;}
					
	.tishi{width: 100vw;display: flex;justify-content: center;font-size: 20upx;color: #CCCCCC;padding:19upx;box-sizing: border-box;}
	.xuzhi{color: #CC2E22;}
					
					
</style>
