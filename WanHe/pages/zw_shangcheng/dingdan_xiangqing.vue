<template>
	<view>
		<view class="top">
			<view class="dindan_zhuangtai background neibianju">已取消</view> 
			<navigator v-for="l in shu.dingdan.dingdan_shangpin" class="shangpin background neibianju" :url="'xiangqing?id='+l.shangpin">
				<view class="tu" :style="'background-image: url('+l.tu+');'"></view>
				<view class="ming"><text>{{l.ming}}</text></view>
				<view class="shuliang"><text>X{{l.shuliang}}</text></view>
			</navigator>
			<view class="peisong background neibianju"><text>配送方式</text><text style="font-size: 24upx;">{{shu.dingdan.peisong}}</text></view>
			<view class="shouhuoren background neibianju"><text>收货人：</text><text>{{shu.dingdan.shouhuoren}}</text><text>{{shu.dingdan.shouhuodianhua}}</text></view>
			<view class="shouhuodizhi background neibianju"><text>收货地址:</text><text>{{shu.dingdan.shouhuodizhi}}</text></view>
			<view class="xiaoji background neibianju"><text>小计（包含快递）:</text><text style="color: red;font-size: 24upx;">￥{{shu.dingdan.zongjia}}</text></view>
			<view class="kuaidi background neibianju"><text>快递.支付详情</text></view>
		</view>
		
		<view class="botton">
			<view><text>订单编号:</text><text>{{id}}</text></view>
			<view><text>创建时间:</text><text>{{shu.dingdan.xiadanshijian}}</text></view>
			<view><text>支付时间:</text><text>{{shu.dingdan.zhifushijian}}</text></view>
		</view>
		
		<navigator v-if="false" url="" class="anniu"><text>再次购买</text></navigator>
		
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			id:'',
			shu:{},
		},
		
		onLoad:function(e){
			this.id = e.id;
		},
		
		onShow:function(){
			setTimeout(this.CSH(),200);
		},
		
		methods:{
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=dingdan&x=dingdanxiangqing',{id:_this.id},function(s){		
					if(s.shi==1){
						_this.shu = s.shu;
					}
					
				});
			},
		},
	}
</script>

<style>
	page{display: flex;flex-direction: column;width: 100vw;height: 100vh;font-size: 32upx;}
	.top{background: #EEEEEE;padding: 0;margin: 0;display: flex;flex-direction: column;}
	.background{background: white;}
	.neibianju{padding: 30upx;box-sizing: border-box;}
	.dindan_zhuangtai{width: 100%;text-align: right;}
	.shangpin{width: 100%;display: flex;margin-top: 2upx;}
	.tu{width: 130upx;height: 130upx;display: flex;align-items: center;background-size: cover;background-repeat: no-repeat;}
	.ming{width: 70vw;display: flex;align-items: flex-start;margin-left: 20upx;}
	.shuliang{flex-grow: 1;display: flex;align-items: flex-end;}
	.peisong{width: 100vw;display: flex;justify-content: space-between;margin-top: 2upx;}
	.shouhuoren{width: 100vw;display: flex;justify-content: flex-start;margin-top: 2upx;}
	.shouhuoren>text{margin-right: 20upx;}
	.shouhuodizhi{width: 100vw;display: flex;justify-content: flex-start;margin-right: 20upx;margin-top: 2upx;}
	.shouhuodizhi>text{margin-right: 20upx;}
	.xiaoji{width: 100vw;display: flex;justify-content: space-between;margin-top: 2upx;}
	.kuaidi{width: 100vw;display: flex;justify-content: center;align-items: center;margin-top: 2upx;}
	
	.botton{width: 100vw;display: flex;flex-direction: column;font-size: 24upx;color: #999999;align-items: flex-start;padding: 0 20upx;box-sizing: border-box;}
	.botton>view{width: 100%;display: flex;justify-content: flex-start;align-items: center;}
	.botton text{margin-right: 10upx;}
	
	.anniu{background: #1c2536;color: white;padding: 10upx 30upx;border-radius: 30upx;position: fixed;bottom: 80upx;right: 20upx;}
</style>
