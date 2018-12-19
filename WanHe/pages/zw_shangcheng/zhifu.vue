<template>
	<view class="querendingdan" v-if="shu.dingdan.leixing==2">
		<view class="dingdanhao item">
			<text>订单号:</text>
			<text>{{shu.dingdan.dingdanhao}}</text>
		</view>
		<view class="jin_e item">
			<text style="float: left;">和券</text>
			
			<text class="jin_e_shu">{{shu.dingdan.zongjia}}</text>
		</view> 
		<radio-group class="radio-group" @change="ZhiFuQuDao">		
			<view class="yu_e_zhifu item">
				<icon class="iconfont icon-yue" ></icon>		
				<text style="margin-left: 10upx;">和券 ({{shu.jifen}})</text>
				<input type="radio" value="jifen" color='#000'></input>
			</view>
		</radio-group>		
		<view class="zhifu item" @click="zhifu">兑换</view>
	</view>
	
	<view class="querendingdan" v-else>
		<view class="dingdanhao item">
			<text>订单号:</text>
			<text>{{shu.dingdan.dingdanhao}}</text>
		</view>
		<view class="jin_e item">
			<text style="float: left;">金额</text>
			<icon class="iconfont icon-renminbi1688"></icon>
			<text class="jin_e_shu">{{shu.dingdan.zongjia}}</text>
		</view> 
		<radio-group class="radio-group" @change="ZhiFuQuDao">
			<view class="weixinzhifu item" v-if="shu.zhifu.alipay.kaiguan==1">
				<icon class="iconfont icon-alipay"></icon>					
				<text style="margin-left: 10upx;">支付宝</text> 
				<input type="radio" value="zhifubao" color='#000'></input>
			</view>
			<view class="weixinzhifu item" v-if="shu.zhifu.wechat.kaiguan==1">
				<icon class="iconfont icon-weixin2" ></icon>					
				<text style="margin-left: 10upx;">微信支付</text> 
				<input type="radio" value="weixin" color='#000'></input>
			</view>			
			<view class="yu_e_zhifu item" v-if="shu.zhifu.yu_e.kaiguan==1">
				<icon class="iconfont icon-yue" ></icon>		
				<text style="margin-left: 10upx;">余额支付 ({{shu.zong_yu_e}}元)</text>
				<input type="radio" value="yu_e" color='#000'></input>
			</view>
		</radio-group>		
		<view class="zhifu item" @click="zhifu">支付</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{dingdan:{}},
			mima:''
		},
		onLoad:function(e){
			this.dingdanid=e.dingdanid;
		},
		onShow:function(){
			var that=this;
			$z.post('m=zw_shangcheng&k=dingdan&x=zhifu',{dingdanid:that.dingdanid},function(shu){	
				$z.L(shu);
				if(shu.shi==1){
					that.shu=shu.shu;
				}
			});
		},
		methods:{
			ZhiFuQuDao:function(e){
				this.shu.zhifuqudao=e.detail.value;			
			},		
			zhifu:function(){
				var that=this;				
				if(!that.shu.zhifuqudao){
					$z.toast('请选择支付方式');
					return false;
				}				
				$z.post('m=zw_shangcheng&k=dingdan&x=zhifu',{dingdanid:that.dingdanid,c:'zhifu',zhifuqudao:that.shu.zhifuqudao,mima:that.mima},function(shu){	
				
					if(shu.shi==0){
						 $z.toast(shu.shu,200);
					}else if(shu.shi==2){							
						 that.queren=1;						
						 return false;
					}else if(that.shu.zhifuqudao=='yu_e' || that.shu.zhifuqudao=='daofu' || that.shu.zhifuqudao=='jifen'){
						  that.ZhiFuChengGong();
					}else if(that.shu.zhifuqudao=='weixin'){
						  that.WeiXin(shu.shu);
					}else if(that.shu.zhifuqudao=='zhifubao'){
						  that.zhifubao(shu.shu);
					}
				});
			},
			WeiXin:function(shu){
				var that=this;
				uni.requestPayment({
					provider: 'wxpay',
					timeStamp: shu.timeStamp,
					nonceStr: shu.nonceStr,
					package:  shu.package,
					signType: shu.signType,
					paySign: shu.paySign,
					success: function (res) {
						   that.ZhiFuChengGong();
					},
					fail: function (err) {
						$z.toast('取消支付');
						console.log(err);
					}
				});
			},
			zhifubao:function(shu){	
					var that = this;
					uni.requestPayment({
						provider: 'alipay',
						orderInfo: shu, //订单数据
						success: function (res) {
							that.ZhiFuChengGong();
						},
						fail: function (err) {
							$z.toast('取消支付');						
						}
					});
			},
			ZhiFuChengGong:function(){
				$z.toast('支付成功');
				setTimeout(function(){							 
					uni.redirectTo({url: 'dingdan?zhuangtai=10'});							
				},500);
			
			}
		}
	}
</script>

<style>
	.icon-alipay{font-size: 40upx; color: #0591D8;}
	.icon-weixin2{font-size: 40upx;color: #04BE01;}
	.icon-yue{font-size: 40upx;color: #000000;}
	.querendingdan{
		width: 100%;
		padding: 0 30upx;
		box-sizing: border-box;
	}
	.jin_e{
		text-align: right;
	}
	.icon-renminbi1688{
		font-size: 30upx;
	}
	.jin_e_shu{
		color: #f3312f;
	}
	.zhifu_tu{
		width: 35upx;
		height:30upx;
		vertical-align: middle;
	}
	.item{
		width: 100%;
		height: 100upx;
		line-height: 100upx;
		box-sizing: border-box;
		position: relative;
	}
	input{
		position: absolute;
		right: 0;
		top: 1upx;
	}
	.zhifu{
		padding: 0 30upx;
		text-align: center;
		font-size: 35upx;
		background-color: #1c2536;
		color: #FFFFFF;
		border-radius: 10upx;
		margin-top: 20upx;
	}
</style>
