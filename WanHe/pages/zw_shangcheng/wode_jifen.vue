<template>
	<view> 
		<view class="zongjine">
			<view class="zongjine_shu">¥{{shu.zong}}</view>
			<view class="zongjine_zi">总和券</view>
		<!-- 	<navigator class="lijitixian" v-if="!e" url="tixianshenqing">立即提现</navigator> -->
		</view>
		<view class="jinemingxi">
			<view class="jinemingxi_zi">金额明细</view>
			
			<view class="item" v-for="l in shu.lie">
				<view class="item_tou">
					<view class="fangshi">{{l.shuoming}}</view>
					<view class="shijian">{{l.shijian}}</view>
				</view>
				<view class="item_wei">
					<view class="yu_e">
						<text class="yu_e_shu">单号:{{l.dingdanhao}}</text>
					</view>
					<view class="jia_jian">{{l.zhi}}</view>
				</view>
			</view>
			
		<!-- 	<view class="gengduoshuju">没有更多数据了</view> -->
		</view>
	</view>
</template>
<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{lie:[],zong:''},
			ye:1,
	    jitiao:6
		},	
		onShow:function(){
			this.CSH();
			$z.BiaoTi("和券明细");
		},	
		onReachBottom:function(){
			this.jiazai();
		},
		methods:{
			CSH:function(){
				var _this = this;				
				$z.post('m=zw_shangcheng&k=wode&x=jifen',{ye:1,jitiao:_this.ye*_this.jitiao,zhuangtai:1},function(shu){
					if(shu.shi==1){						
						_this.shu = shu.shu;
					}else{
				     $z.toast(shu.shu);
					}
				});
			},
			jiazai:function(){
				var _this = this;				
				$z.post('m=zw_shangcheng&k=wode&x=jifen',{ye:_this.ye+1,jitiao:jitiao,zhuangtai:1},function(shu){
					if(shu.shu.lie){					
						_this.shu.lie.push(shu.shu.lie);
						_this.ye++;
					}else{
						$z.toast(shu.shu);
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
