<template>
	<view>
		<view class="tou">
			<image class="logobg" src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/V9cfE99rGGF4ysE9FRE49Fg644RAcY.png" mode="widthFix"></image>
			<image class="logo" :src="shu.huiyuan.touxiang" mode="widthFix"></image>
			<input class="dianpuming" type="text" :value="shu.huiyuan.nicheng"  disabled=""/>
		</view>
		<view class="biaoti">
			<image src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/P27qjQtQQgn8GNjM7dFN678aJdIq6d.png" mode="widthFix"></image>
			<view class="biaoti_text">请选择身份</view>
		</view>
		
		<view class="dengji">
			<view  v-for="(item,index) in shu.dengji">
				<view class="item huise" v-if="item.id<=shu.huiyuan.fenxiaodengji"> 
					<text>{{item.ming}}</text>
					<text>{{item.tiaojian}}</text>
				</view>
				<view :class="['item',(flag === index)?'bianse':'']" @click="xuanzhong(index)" v-else>
					<text>{{item.ming}}</text>
					<text>{{item.tiaojian}}</text> 
				</view>			
			</view>
		</view>
		
		<view class="biaoti">
			<image src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/P27qjQtQQgn8GNjM7dFN678aJdIq6d.png" mode="widthFix"></image>
			<view class="biaoti_text">说明</view>
		</view>
		
		<view class="miaoshu">
			<rich-text v-html="shu.fenxiao.xieyi"></rich-text> 
		</view>		
		<view class="lijigoumai" @click="tijiao"><text>立即购买</text></view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{			
			flag:'',
			shu:{huiyuan:{},fenxiao:{},dengji:{}},
			zhifuqudao:'weixin'
		},
		onShow:function(){
			this.CSH();
		},
		methods:{
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=fenxiao&x=yindaogoumai',function(shu){				
					if(shu.shi==1){
						that.shu=shu.shu;
					}
				})
			},
			xuanzhong:function(e){				
				this.flag=e;
			},
			tijiao:function(){
				var that = this;
				if(this.flag===''){
					$z.toast('请选择身份');
					return false;
				}
				var dengji=that.shu.dengji[this.flag].id;				
				$z.post('m=zw_shangcheng&k=fenxiao&x=yindaogoumai&c=zhifu',{zhifuqudao:that.zhifuqudao,dengji:dengji},function(shu){				
					if(shu.shi==0){
						$z.toast(shu.shu);
						return false;
					}else if(that.zhifuqudao=='yu_e'){
						that.ZhiFuChengGong();
					}else if(that.zhifuqudao=='weixin'){
						that.weixin(shu.shu);
					}else if(that.zhifuqudao=='zhifubao'){
						that.zhifubao(shu.shu);
					}


				})
			},
			weixin:function(shu){			
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
				$z.toast('恭喜成为会员');
				this.flag='';
				this.CSH();
				setTimeout($z.go(),500);
			}
		}
	}
</script>

<style>
	page{background: #F3F3F3;width: 100vw;}
	.tou{width: 100vw;position: relative;}
	.logobg{width: 100%;}
	.logo{z-index: 10;width: 21vw;height: 21vw;position: absolute;top:10vw;left: 10vw;}
	.dianpuming{z-index: 10;position: absolute;top:21.5vw;left: 39vw;}
	
	.biaoti{width: 100%;padding: 30upx;box-sizing: border-box;display: flex;}
	.biaoti>image{width: 44upx;}
	.biaoti_text{margin-top:10upx ;margin-left: -34upx;font-family: PingFang-SC-Medium;font-size: 30upx;color: #333333;}
	
	.dengji{width: 100vw;padding: 0 30upx;box-sizing: border-box;display: flex;justify-content: space-between;flex-wrap: wrap;margin-top: 10upx;}
	.item{width: 200upx;height: 90upx;margin-bottom: 40upx;border: 1upx solid #DCDCDC;border-radius: 4upx;font-size: 24upx;
			display: flex;flex-direction: column;justify-content: center;align-items:center ;font-family: PingFang-SC-Medium;}
	.bianse{background: #E1C178;color: white;}
	
	.miaoshu{width: 690upx;height: 271upx;margin: 0 auto;border: 2upx dashed #999999;background: white;padding: 20upx;box-sizing: border-box;}
	
	.lijigoumai{width: 710upx;height: 82upx;display: flex;justify-content: center;align-items: center;background: #333333;color: white;font-size: 30upx;
					border-radius: 10upx;margin: 40upx auto;}
	.huise{color: #ccc;}
</style>
