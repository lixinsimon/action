<template>
	<view> 
		<view class="zongshouyi">
			<view class="zongshouyi_shu">¥{{shu.zong}}</view>
			<view class="zongshouyi_zi">总收益</view>
			<navigator url="tixianshenqing" class="lijitixian" >立即提现</navigator>
		</view>
		<view class="shouyimingxi">
			<view class="shouyimingxi_zi">收益明细</view>
			<view class="item" v-for="l in shu.lie">
				<view class="item_tou">
					<view class="fangshi">{{l.shuoming}}</view>
					<view class="shijian">
						{{l.shijian}}
					</view>
				</view>
				<view class="item_wei">
					<view class="yu_e">
						<text class="yu_e_shu">订单号:{{l.dingdanhao}}</text>
					</view>
					<view class="jia_jian">{{l.zhi}}</view>
				</view>
			</view>
			
			<view class="gengduoshuju">没有更多数据了</view>
		</view>
	</view>
</template>
<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{lie:[],zong:''},
			lie:'',
			ye:1,
			pan:true,
		},
		
		onShow:function(){
			this.CSH();
		},
		
		methods:{
			CSH:function(){
				var _this = this;
				var jitiao=6;
				$z.post('m=zw_shangcheng&k=fenxiao&x=yongjinmingxi',{zhuangtai:1},{ye:_this.ye,jitiao:jitiao,zhuangtai:1},function(shu){
					if(shu.shi == 1){
						_this.shu={lie:[],zong:''};
						_this.shu.zong=shu.shu.zong;
						for(var i in shu.shu.lie){
							if(shu.shu.lie[i].zhi >= 0){
								_this.shu.lie.push(shu.shu.lie[i]);
							}
						}
							
					}	
				});
			}
		}
	}
</script>
<style>
	.zongshouyi{
		width: 100%;
		height: 350upx;
		box-sizing: border-box;
		text-align: center;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.zongshouyi_shu{
		width: 100%;
		height: 120upx;
		margin-top: 30upx;
		text-align: center;
		font-size: 60upx;
		line-height: 120upx;
	}
	.zongshouyi_zi{
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
		background-color: #990134;
		border-radius: 10upx;
		color: #f3f3f3;
		margin-left: 275upx;
	}
	.shouyimingxi{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.shouyimingxi_zi{
		width: 100%;
		height: 100upx;
		line-height: 100upx;
		font-size: 35upx;
	}
	.item{
		width: 100%;
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
	.yu_e{
		text-align: left;
		width: 70%;
	}
</style>
