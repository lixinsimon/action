<template>
	<view> 
		<view class="zongjine">
			<view class="zongjine_shu">¥{{shu.zonge}}</view>
			<view class="zongjine_zi">总金额</view>
			<navigator class="lijitixian" url="dianpu_tixian">立即提现</navigator>
		</view>
		<view class="jinemingxi">
			<view class="jinemingxi_zi">金额明细</view>
			
			<view class="item" v-for="l in shu.lie">
				<view class="item_tou">
					<view class="fangshi">订单收益</view>
					<view class="shijian">{{l.xiadanshijian}}</view>
				</view>
				<view class="item_wei">
					<view class="yu_e">
						<text class="yu_e_shu">单号:{{l.dingdanhao}}</text>
					</view>
					<view class="jia_jian">{{l.zongjia}}</view>
				</view>
			</view>
			
			<view class="gengduoshuju" v-if="mieyou">没有更多数据了</view>
		</view>
	</view>
</template>
<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{zonge:0.00},
			ye:1,
			jitiao:8,
			mieyou:0,
			zhuangtai:0 
		},
	    onLoad:function(e){			
			if(e.zhuangtai){
				this.zhuangtai=e.zhuangtai;
			}
			if(this.zhuangtai==1){
				$z.BiaoTi('可提现金额');
			}else if(this.zhuangtai==2){
				$z.BiaoTi('待到金额');
			}else{
				$z.BiaoTi('累计金额');
				
			}	    	
	    },
		onShow:function(){
			this.CSH();
		},
		onReachBottom:function(){
			this.jiazai(); 
		},
		methods:{
			CSH:function(){
				var that = this;
				that.mieyou=0;							
				$z.post('m=zw_shangcheng&k=dianpu&c=shouyi',{ye:1,jitiao:that.ye*that.jitiao,zhuangtai:that.zhuangtai},function(shu){				  
					 that.shu=shu.shu;						 
				});
			},
			jiazai:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=dianpu&c=shouyi',{ye:that.ye+1,jitiao:that.jitiao,zhuangtai:that.zhuangtai},function(shu){
					if(shu.shi){					
						var l=that.shu.lie.length;
						for(var i in shu.shu.lie){
							that.$set(that.shu.lie,l++,shu.shu.lie[i]);
						}
						that.ye++; 
					}
									
				});
			}
		}
	}
</script>
<style>
	page{background-color: f3f3f3;}
	.yu_e
	{
		text-align: left;
		width: 70%;
	}
	.yu_e_shu{}
	
	.zongjine{
		width: 100%;
		height: 350upx;
		box-sizing: border-box;
		text-align: center;
	}
	.zongjine_shu{
		width: 100%;
		height: 120upx;
		margin-top: 50upx;
		text-align: center;
		font-size: 60upx;
		line-height: 120upx;
	}
	.zongjine_zi{
		width: 100%;
		height: 75upx;
		text-align: center;
		font-size: 35upx;
	}
	.lijitixian{
		width: 200upx;
		height: 80upx;
		line-height: 80upx;
		text-align: center;
		background-color: #000000;
		border-radius: 10upx;
		color: #f3f3f3;
		margin-left: 275upx;
	}
	.jinemingxi{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.jinemingxi_zi{
		width: 100%;
		height: 100upx;
		line-height: 100upx;
		font-size: 35upx;
	}
	.item{
		width: 100%;
		padding: 10upx;
		box-sizing: border-box;
		height: 120upx;
	}
	.item_tou,.item_wei{
		display: flex;
		flex-direction: row;
	}
	.fangshi{
		text-align: left;
		width: 50%;
	}
	.shijian,.jia_jian{
		width: 50%;
		text-align: right;
	}
	.jia_jian{
		color: #f3312f;
	}
	.gengduoshuju{
		width: 100%;
		height: 100upx;
		line-height: 100upx;
		text-align: center;
		color: #999999;
	}
	
</style>
