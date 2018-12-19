<template>
	<view class="page">
		<navigator url="tianjiazhanghao" class="tianjiazhanghao">
			<image src="../../../static/tu/添加账号.png" mode="widthFix" class="tianjia_tu"></image>
			<text style="color:#BA0643; height: 100upx; line-height: 100upx;margin-left: 30upx;">添加账号</text>
		</navigator>
		<view class="zongshouyi">
			<view class="zongshouyi_shu">¥ {{shu.zong}}</view>
			<view class="zongshouyi_zi">总收益</view>
		</view>
		<view class="item">
			<navigator url="ketixianshouyi">
				<text>可提现收益</text>
				<view class="tu">
					<image src="../../../static/tu/向右.png" mode="widthFix" class="youjiantou"></image>
				</view>
			</navigator>
			<navigator url="daidaozhangshouyi">
				<text>待到账收益</text>
				<view class="tu">
					<image src="../../../static/tu/向右.png" mode="widthFix" class="youjiantou"></image>
				</view>
			</navigator>
			<navigator url="leijitixianshouyi">
				<text>累计提现收益</text>
				<view class="tu">
					<image src="../../../static/tu/向右.png" mode="widthFix" class="youjiantou"></image>
				</view>
			</navigator>
		</view>
		<view class='wei'>
			<navigator url="index" class="quzhuangengduo">去赚更多</navigator>
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
			pan:true,
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
				});
			}
		}
	}
</script>

<style>
	.page{
		width: 100%;
		box-sizing: border-box;
	}
	.tianjiazhanghao{
		width: 100%;
		height: 100upx;
		line-height: 100upx;
		text-align: right;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.tianjia_tu{
		width: 40upx; 
		height: 40upx;
		vertical-align: middle;
	}
	.zongshouyi{
		width: 100%;
		box-sizing: border-box;
		background-color: #BA0643;
		color: #FFFFFF;
		height: 350upx;
		padding-top: 100upx;
	}
	.zongshouyi_shu{
		box-sizing: border-box;
		font-size: 50upx;
		height: 80upx;
		line-height: 80upx;
		text-align: center;
	}
	.zongshouyi_zi{
		box-sizing: border-box;
		font-size: 30upx;
		text-align: center;
		height: 50upx;
		line-height: 50 upx;
	}
	.item{
		width: 100%;
		box-sizing: border-box;
	}
	.item>navigator{
		box-sizing: border-box;
		padding: 0 30upx;
		width: 100%;
		height: 100upx;
		display: flex;
		line-height: 100upx;
		border-bottom: 0.1upx solid #f3f3f3;
		color: #999999;
	}
	.item>navigator>text{
		width: 50%;
		text-align: left;
	}
	.tu{
		width: 50%;
		text-align: right;
	}
	.youjiantou{
		width: 30upx;
		height: 30upx;
	}
	.wei{
		box-sizing: border-box;
		display: flex;
		align-items: center;
		justify-content: center;  
		width: 100%;
		height: 200upx;
	}
	.quzhuangengduo{
			display:inline-block;
			width: 200upx;
			height: 70upx;
			font-size: 35upx;
			box-sizing: border-box;
			border-radius: 10upx;
			color: #FFFFFF;
			text-align: center;
			line-height: 70upx;
			background-color: #BA0643;
	}
	
</style>
