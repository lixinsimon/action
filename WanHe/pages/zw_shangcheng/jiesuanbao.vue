<template>
	<view>
		<view class="toubu">
			<view class="zongjine_biaoti">
				总和券
			</view>
			<text class="zongjine">{{shu.zonge}}</text>
			<view class="shouyi">
				<view class="shouyixiang zuorishouyi">
					<view>昨日收益</view>
					<text>{{shu.zuotian}}</text>
				</view>
				<view class="shouyixiang leijishouyi">
					<view>累计收益</view>
					<text>{{shu.leiji}}</text>
				</view>
			</view>
		</view>
		
		<view class="mingxi_jilu">
			<navigator class="xiang"  url="jiesuanbao_shouyi">
				<icon class="iconfont icon-jilu"></icon>
				<text>收益明细</text>
			</navigator>
			<navigator class="xiang" url="jiesuanbao_jilu">
				<icon class="iconfont icon-qian1"></icon>
				<text>交易记录</text>
			</navigator>
		</view>
		
		<view class="liebiao">
			<view class="lie" v-for="l in shu.lie">
				<view class="lie_biaoti">
					<view>{{l.biaoti}}</view>
					<text>每天放量比例{{l.shouyi}}%</text>
				</view>
				<view class="lie_zhouqi">
					<text>周期 {{l.tian}}天</text>
					<text>{{l.qitou}}和券起</text>
				</view>
				<navigator :url="'jiesuanbao_mairu?id='+l.id" class="anniu_mairu"><text>储放</text></navigator>
			</view>
			
		</view>
		
	</view>
</template>


<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:[],
			ye:1,
			jitiao:6
		},
		onShow:function(){
			this.CSH();
		},
		methods:{
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=jiesuanbao',{ye:1,jitiao:that.ye*that.jitiao},function(shu){
					if(shu.shi==1){
						that.shu=shu.shu;
					}else{
						$z.toast(shu.shu);
					}
				})
			},
			jiazai:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=jiesuanbao',{ye:1,jitiao:that.ye*that.jitiao},function(shu){
					if(shu.shi==1){
						var l=that.shu.lie.length;
						for(var i in shu.shu.lie){
							that.$set(that.shu.lie,l++,shu.shu.lie[i]);
						}						
					}else{
						$z.toast(shu.shu);
					}
				})
			}
		},
	}
</script>

<style>
	page{}
	
	.toubu{width: 100vw;background: #1c2536;color: #FFFFFF;padding: 30upx;box-sizing: border-box;}
	.zongjine_biaoti{width: 100%;text-align: center;font-size: 24upx;color:white;}
	.zongjine{width: 100%;text-align: center;font-size: 40upx;display: block;color:#D28920;}
	.shouyi{width: 100%;margin-top: 40upx;display: flex;justify-content: space-between;}
	.shouyixiang{width: 40%;display: flex;flex-direction: column;justify-content: center;align-items: center;}
	.shouyixiang>view{font-size: 24upx;color: white;}
	.shouyixiang>text{color:#D28920 ;}
	
	
	.mingxi_jilu{width: 100vw;padding: 30upx;box-sizing: border-box;display: flex;justify-content: space-between;align-items: center;background: white;}
	.xiang{width: 40%;font-size: 28upx;color: #000000;display: flex;justify-content: center;font-size: 30upx;}
	.xiang>icon{font-size: 32upx;margin-right: 5upx;margin-top: -12upx;}
	
	.liebiao{width: 100vw;padding-top: 5upx;display: flex;flex-direction: column;background: #EEEEEE;}
	.lie{width: 100%;background: white;padding: 40upx 30upx;box-sizing: border-box;display: flex;justify-content: space-between;align-items: center;margin-bottom: 2upx;}
	.lie_biaoti{width: 30%;display: flex;flex-direction: column;}
	.lie_biaoti>view{font-size: 40upx;font-weight: bold;}
	.lie_biaoti>text{font-size: 20upx;color: red;}
	.lie_zhouqi{width: 30%;display: flex;flex-direction: column;align-content: center;font-size: 26upx;}
	.anniu_mairu{height: 50upx;padding: 2upx 20upx;box-sizing: border-box;background: #1c2536;color: #D28920;display: flex;
				justify-content: center;align-items: center;border-radius: 10upx;}

</style>
