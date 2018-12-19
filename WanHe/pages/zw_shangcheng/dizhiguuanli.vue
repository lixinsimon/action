<template>
	<view class="beijing">
		<navigator class="tianjia" url="zengjiadizhi">添加新地址<text class="iconfont icon-jia"></text></navigator>
		<view class="shouhuo" v-for="l in shu" @click="dizhi(l)">
			<view class="h1">
				<text>收货人：{{l.ming}}</text><text style="float: right;">{{l.dianhua}}</text>
			</view>
			<view class="h2">地址：{{l.shengshiqu}}</view>
		</view>
	</view>
	
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{
			shu:{}
		},
		onShow:function(){
			this.CSH()
		},
		methods:{
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=wode&x=dizhi',function(shu){						
					if(shu.shi==1){ 
						that.shu=shu.shu;						
					}
				});
			},
			dizhi:function(e){
				$z.Cun('dizhi',e);
				$z.go();
			}
		}
	}
</script>

<style>

.beijing{
	background: #EEEEEE;
	
	height: 100vh;
	border: 1upx solid #EEEEEE;
}
.shouhuo{

	height: 120upx;
	background: white;
	margin: 10upx 0;
	border: 1px solid white;
}
.h1{
	line-height: 50upx;
	width: 90%;
	margin: 0 auto;
	margin-top: 20upx;
}
.h2{ 
	width: 90%;
	margin: 0 auto;
	font-size: 24upx;
}
.tianjia{
	width: 100%;
	background: white;
	height: 100upx;
	text-align: center;
	line-height: 100upx;
	font-size: 32upx;
	font-weight: 600;
}
/* 	page{
		background-color: #dcdcdc;
	}
	.moren{
		width: 100%;
		height: 150upx;
		box-sizing: border-box;
		background-color: #FFFFFF;
		margin-top: 10upx;
		margin-bottom: 20upx;
		padding: 40upx 30upx;
		position: relative;
	}
	.xinxi{
		width: 100%;
		height: 40upx;
		font-size: 35upx;
	}
	.xingming{
		width: 200upx;
		height: 40upx;
		margin-right: 30upx;
	}
	.dianhua{
		float: right;
		height: 40upx;
	}
	.dizhi{
		width: 100%;
		height: 40upx;
		margin-top: 10upx;
	}
	.moren_zi{
		color: #f3312f;
	}
	.check_tu{
		width: 50upx;
		height: 50upx;
	}
	.checked{
		position: absolute;
		right: 20upx;
		top: 50upx;
		opacity: 1;
	}
	.unchecked{
		position: absolute;
		right: 20upx;
		top: 50upx;
		opacity: 0;
	}
	.zengjiadizhi{
		width: 100%;
		height: 110upx;
		background-color: #000000;
		color: #FFFFFF;
		font-size: 40upx;
		text-align: center;
		line-height: 110upx;
		position: fixed;
		bottom: 0upx;
	} */
</style>
