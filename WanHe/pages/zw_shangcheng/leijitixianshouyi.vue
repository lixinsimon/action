<template>
	<view>
		<view class="nav">
			
			<view class="nav-bar">
				<view :class="{active:(flag==1)}" @click="xuanze(1)" >全部</view>
				<view :class="{active:(flag==0)}" @click="xuanze(0)" >待审核</view>
				<view :class="{active:(flag==10)}" @click="xuanze(10)" >待打款</view>
				<view :class="{active:(flag==20)}" @click="xuanze(20)" >已打款</view>
				<view :class="{active:(flag==5)}" @click="xuanze(5)" >无效</view>
		    </view>
		
			<view class="item" v-for="l in shu.lie">
				<view class="dingdanhao">订单号:{{l.dingdanhao}}</view>
				<view class="jin_e">￥{{l.jin_e}}</view>
				<view class="tixianfangshi">提现方式:{{l.tixianfangshi}}</view>
				<view class="shijian">{{l.shijian}}</view>
			</view>
			
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data: {
			flag:1,
			shu:{},
		},
		onShow:function(){
			this.CSH();
		},
		
		methods:{
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=fenxiao&x=tixianmingxi',function(shu){
					_this.shu = shu.shu;
				});
			},
			switchSlider: function (e) {
				this.setData({
				current: e.target.dataset.index
				})
			},
			changeSlider: function (e) {
				this.setData({
				current: e.detail.current
            })
			},
			
			xuanze:function(e){
				this.flag = e;
				if(e != 1){
					var _this = this;
					$z.post('m=zw_shangcheng&k=fenxiao&x=tixianmingxi',{zhuangtai:e},function(shu){
						_this.shu = shu.shu;
					});
				}else{
					this.CSH();
				}
			},
		}
	}
</script>

<style>
	.nav{
		width: 100%;
		box-sizing: border-box;
	}
	.nav-bar{
		width: 100%;
		display: flex;
		box-sizing: border-box;
		height: 100upx;
		border-top: 0.1upx solid #f3f3f3;
		line-height: 100upx;
		text-align: center;
	}
	.active{
		color: #990134;
		border-bottom: 2upx solid #990134;
		
	}
	.nav-bar>view{
		width: 20%;
		border-bottom-width: 5upx;
		border-bottom-height: 5upx;
	}
	.neirong{
		
	}
	.gengduo{
		widht:100%;
		height: 100upx;
		text-align: center;
		color: #999999;
	}
	
	.item{
		text-align: left;
		width: 100vw;
		padding: 20upx;
		box-sizing: border-box;
		height: 120upx;
		display: flex;
		flex-wrap: wrap;
	}
	
	.dingdanhao{width: 75%;}
	.jin_e{width: 25%;text-align: right;}
	.tixianfangshi{width: 50%;}
	.shijian{width: 50%;text-align: right;}
	
	
</style>
