<template>
	<view>
		<view class="jilu_view">
			<navigator class="jilu" v-for="l in lie" :url="'jiaoyi_xiangqing?id='+l.id">
				<view class="left">
					<view class="left_top">
					<text style="color: #04BE01;" v-if="l.leixing==1">[买入]</text>
					<text style="color:#CC2E22;" v-else>[卖出]</text>				
					<text style="color:#CC2E22;" >{{l.shijian}}</text>	
					</view>
					<view class="left_botton"><text>单号号：</text> <text>{{l.dingdanhao}}</text></view>
					<view class="left_botton"><text>交易价：</text> <text>{{l.jiage}}元</text></view>
				</view>
				<view class="right">
					<view>{{l.zhuangtai}}</view>
					<view>+{{l.shuliang}}</view>
			    </view>
			</navigator>
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{		
			shu:{},
			lie:[],
			jitiao:10,
			ye:1
		},
		onShow:function(){
			this.CSH();
		},
		onPullDownRefresh:function(){
			this.CSH();
		},
		onReachBottom:function(){
			this.jiazai();
		},
		methods: {
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=jiaoyi',{c:'jilu',ye:1,jitiao:that.ye*that.jitiao},function(s){	
					  if(s.shi){
						 that.lie=s.shu.lie;
						 that.shu=s.shu.zongshu;							
					  }	
				      $z.BiaoTi('和券交易记录('+s.shu.zongshu+')');
 
				})
			},
			jiazai:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=jiaoyi',{c:'jilu',ye:that.ye+1,jitiao:that.jitiao},function(shu){					
					if(shu.shi){
						var leng=that.lie.length
						for(var i in shu.shu){
							that.$set(that.lie,leng++,shu.shu[i]);
						}
					    that.ye++;
					}else{
						$z.toast(shu.shu);
					}
					
				})
				
			}
		},
	}
</script>

<style>
	.jilu_view{width: 100vw;background: #F1EEEE;display: flex;flex-direction: column;font-size: 28upx;padding: 1upx 0;}
	.jilu{width: 100%;padding: 30upx;box-sizing: border-box;display: flex;background: white;margin-bottom:2upx ;}
	.left{width: 50%;display: flex;flex-direction: column;}
	.left_botton{font-size: 24upx;color:#C3C3C3 ;}
	.right{display: flex;flex-grow: 1;align-items: center;flex-direction: row-reverse;color: red;}
	
</style>
