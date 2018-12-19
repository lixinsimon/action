<template>
	<view>
		<view class="tou">
			<navigator class="tianjiazhanghao" url="wode_kahao">
				<icon class="iconfont icon-bianxie"></icon>
				<view class="tianjiazhanghao_wenzi">添加账号</view>
			</navigator>
			<view class="body">
				<icon class="iconfont icon-yue"></icon>
				<view class="jin_e"><text style="font-size:34upx ;">¥ </text>{{shu.ketixian}}</view>
				<view>可提现金额</view>
			</view>
		</view>
		<view class="tixianjin_e">
			<view class="wenzi">提现金额</view>
			<input class="shurukuang" type="text" v-model:value="jine" placeholder="0.00"/>
		</view>

		<radio-group class="radio-group" @change="xuanzhong">
			<label class="radio_lable">
				<text>提现到银行</text>
				<radio value="yinhang" /> 
			</label>
			<label class="radio_lable">
				<text>提现到支付宝</text>
				<radio value="zhifubao"  />
			</label>
		</radio-group>
		
		<view class="button" @click="tixian">提现</view>
		<view style="display: flex;justify-content: center;">
			<navigator class="tixianmingxi" url="leijitixianshouyi">提现明细</navigator>
		</view>
		<view class="shengming">声明:满{{shu.qidian}}元即可提现,请仔细核实您的金额是否准确,为保证账户安全,账户即将被锁定,如需修改,请联系客服.</view>
		
		<view class="bg" v-if="false">
			<view class="mima">
				<view class="tishi">请输入交易密码</view>
				<input type="password" v-model:value="mima" />
				<view class="queren">确认</view>
			</view>
		</view>
		
		
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			fangshi:'',
			jine:'',
			shu:{},
			mima:'',

		},
		onShow:function(){
		   this.CSH();
		},
		methods:{
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=fenxiao&x=tixian',function(s){
					if(s.shi==1){
						that.shu=s.shu;
					}
				})
			},
			xuanzhong:function(e){			
				this.fangshi=e.detail.value;
			},
			

			inp:function(e){
				console.log(e)
			},
			tixian:function(){
				var that=this;
				var tishi='';
				if(!that.fangshi){
					$z.toast('请选择打款方式');
					return false;
				}if(that.shu.zhifubao_zhanghao=='' && that.fangshi=='zhifubao'){			
					tishi='请去完善支付宝信息';				
				}else if(that.shu.kahao=='' && that.fangshi=='yinhang'){
					tishi='请去完善银行卡信息';	
				}else if(that.jine<=0){
					tishi='请输入金额';	
				}			
				
				if((tishi != '请输入金额') && tishi){
					$z.toast(tishi);
					setTimeout(function(){
						uni.navigateTo({url:'wode_kahao'});
					},500);
					return false
				}			
				$z.post('m=zw_shangcheng&k=fenxiao&x=tixian&c=tixian',{fangshi:that.fangshi,jine:that.jine},function(shu){
					$z.toast(shu.shu); 
					 if(shu.shi==1){
						 setTimeout(function(){
							uni.navigateTo({
							    url: 'leijitixianshouyi',							 
							});							 
						 },1000)
						 
					 }
				});
			},
		}
	}
</script>

<style>
	page{background: #f9f9f9;width: 100vw;}
	.tou{width: 100vw;padding: 20upx;box-sizing: border-box;font-size: 36upx;background: white;}
	.tianjiazhanghao{display: flex;width: 100%;justify-content: flex-end;align-items: center;}
	.tianjiazhanghao icon{font-size: 38upx;margin-right: 20upx;margin-bottom: 6upx;}
	
	.body{display: flex;flex-direction: column;align-items: center;justify-content: center;padding-top: 40upx;}
	.body icon{font-size: 100upx;}
	.jin_e{font-size: 46upx;}
	
	.tixianjin_e{width: 100vw;padding: 20upx;display: flex;background: white;margin-top:2upx ;align-items: center;}
	.wenzi{margin-right: 30upx;}
	
	
	.radio-group{width: 100vw;margin-top: 20upx;}
	.radio_lable{padding: 20upx;box-sizing: border-box;background: #FFFFFF;margin-top: 2upx;display: flex;justify-content: space-between;align-items: center;}
	
	.button{background: #000000;width: 90vw;margin: 30upx auto;color: white;text-align: center;display: flex;justify-content: center;
				border-radius:10upx;padding: 20upx;box-sizing: border-box;font-size: 36upx;}
	.tixianmingxi{font-size:28upx ;color: #000000;text-align: center;border-bottom: 1upx solid #000000;display: inline-block;margin-top: -10upx;}
	.shengming{width: 80vw;margin: 0 auto;text-align: center;color: #CCCCCC;font-size: 24upx;margin-top: 20upx;}
	
	.bg{z-index: 1000;width: 100vw;height: 100vh;position: fixed;bottom: 0;left: 0;background: rgba(0,0,0,0.5);}
	.mima{width: 100vw;height: 40vh;position: absolute;bottom: 0;left: 0;background: white;display: flex;flex-direction: column;}
	.tishi{display: inline;margin: 20upx auto;}
</style>
