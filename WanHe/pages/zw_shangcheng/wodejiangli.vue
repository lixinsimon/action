<template>
	<view>
		<view class="tou">
			<view class="zongshouyi">¥{{shu.zong}}</view>
			<view class="zongshouyi_zi">总收益</view>
			<view class="lijitixian_zi">
				<navigator class="lijitixian" url="tixianshenqing">立即提现</navigator>
			</view>
			
		</view>
		<view class="wei">
			<navigator class="item" url="wodetuandui">
				<view class="item_tu">
					<image src="../../../static/tu/我的团队.png" class="tu"></image>
				</view>
				<view>我的团队</view>
			</navigator>
			<navigator class="item" url="">
				<view class="item_tu">
					<image src="../../../static/tu/我的下线.png" class="tu"></image>
				</view>
				<view>我的下线</view>
			</navigator>
			<navigator class="item" url="">
				<view class="item_tu">
					<image src="../../../static/tu/我要升级.png" class="tu"></image>
				</view>
				<view>我要升级</view>
			</navigator>
			<navigator class="item" url="">
				<view class="item_tu">
					<image src="../../../static/tu/奖励明细.png" class="tu"></image>
				</view>
				<view>奖励明细</view>
			</navigator>
			<navigator class="item" url="">
				<view class="item_tu">
					<image src="../../../static/tu/业绩明细.png" class="tu"></image>
				</view>
				<view>业绩明细</view>
			</navigator>
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		
		data:{
			shu:{},
			lie:'',
			ye:1,
		},
		onShow:function(){
			this.CSH();
		},
		methods:{
			CSH:function(){
				var _this = this;
				var jitiao=6;
				$z.post('m=zw_shangcheng&k=fenxiao&x=yongjinmingxi',{ye:_this.ye,jitiao:jitiao,zhuangtai:1},function(shu){
					_this.shu = shu.shu;
					$z.L(shu.shu);
					
				});
			}
		}
	}
</script>

<style>
	.tou{
		width: 100%;
		background-color: #A00137;
		height: 300upx;
		color: #FFFFFF;
	}
	.tou>view{
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.zongshouyi{
		font-size: 60upx;
		height: 100upx;
	}
	.zongshouyi_zi{
		height: 60upx;
	}
	.lijitixian_zi{
		height: 100upx;
		width: 100%;
		box-sizing: border-box;
		
	}
	.lijitixian{
		width: 150upx;
		height: 60upx;
		text-align: center;
		line-height: 60upx;
		background-color: #FFFFFF;
		color: #A00137;
		border-radius: 5upx;
	}
	.wei{
		display: flex;
		flex-wrap: wrap;
		width: 100%;
		padding: 0 30upx;
		box-sizing: border-box;
		margin-top: 50upx;
	}
	.item{
		width: 230upx;
		height: 200upx;
		display:flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}
	.item_tu{
		background-color: #A00137;
		width: 120upx;
		height: 120upx;
		text-align: center;
		line-height: 120upx;
	}
	.tu{
		width: 100upx;
		height: 100upx;
		margin-top: 10upx;
	}
</style>
