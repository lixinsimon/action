<template>
	<view class="page">
		<view class="shimingrenzheng" @click="renzheng">
			<view class="renzheng1">实名认证</view>
			<view class="renzheng2" v-if="!shu.renzheng">未认证</view>
			<view class="renzheng2" v-else style="color: #999999;">已认证</view>
			<icon class="renzheng3 iconfont icon-jiantouyou" v-if="!shu.renzheng" ></icon>
			<icon class="renzheng3 iconfont icon-jiantouyou" v-else style="color: #999999;"></icon>
		</view>
		<view class="tips">
			<image src="" mode="widthFix" class="tishi_tu"></image>
			<text>请输入您的个人信息，方便提现</text>
		</view>
	
		<view class="item">
			<text>支付宝账号</text>
			<input type="text" v-model:value="shu.zhifubao_zhanghao" class="yhkh"/>
		</view>
		<view class="item">
			<text>持卡人</text>
			<input type="text" v-model:value="shu.chikaren" class="yhqm" placeholder="请输入全名"/>
		</view>
		<view class="item">
			<text>银行卡号</text>
			<input type="number" v-model:value="shu.kahao" class="khh"/>
		</view>
		<view class="item">
			<text>开户银行</text>
			<input type="text" v-model:value="shu.kaihuhang" class="zfb" placeholder="开户行" />
		</view>
		
		<view class="item">
			<text>手机号码</text>
			<input type="number" v-model:value="shu.shouji" class="xm" placeholder="手机号"/>
		</view>
		<view class="tijiao"  @click="tijiao">
			<button>提交</button>
		</view>
		<view class="beizhu">
			备注：请认真填写，提交后，不得再次修改。如需修改请联系客服
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{		
			shu:{},
		},
		onShow:function(){
			this.CSH();
		},
		methods:{
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=wode&x=tixianxinxi',function(shu){
					    if(!shu.shu.renzheng){
								uni.navigateTo({
									url:'wode_shiming'
								})
							}
						  _this.shu=shu.shu;
				});
			},		
			
			tijiao:function(){
				var _this = this;				
				$z.post('m=zw_shangcheng&k=wode&x=tixianxinxi',{
					    c:'baocun',					 
						zhifubao_zhanghao:_this.shu.zhifubao_zhanghao,
						chikaren:_this.shu.chikaren,
						kahao:_this.shu.kahao,
						kaihuhang:_this.shu.kaihuhang,
						shouji:_this.shu.shouji,
						},function(shu){							
					    $z.toast(shu.shu);		
						if(shu.shi==1){
							setTimeout(function(){
								$z.go();
							},500);
						}
				});
			},
		}
	}
</script>

<style>
	.page{ 
		width: 100%; 
		box-sizing: border-box;
	}
	.tips{
		width: 100%;
		height: 70upx;
		padding: 0 30upx;
		background-color: #f3f3f3;
		display: flex;
		align-items: center;
	}
	.tishi_tu{
		width: 30upx;
		height: 30upx;
		margin-right: 30upx;
	}
	input{
		margin-left: 30upx;
		vertical-align: middle;
	}
	.item{
		width: 100%;
		height: 100upx;
		padding: 0 30upx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.tijiao{
		width: 100%;
		padding:  0 30upx;
		display: flex;
		align-items: center;
		margin: 40upx 0upx;
		box-sizing: border-box;
	}
	.tijiao>button{
		width:100%;
		background-color: #990134;
		color: #FFFFFF;
		font-size: 35upx;
	}
	.beizhu{
		text-align: center;
		width: 100%;
		height: 50upx;
		padding: 0 30upx;
		font-size: 22upx;
		box-sizing: border-box;
		line-height: 50upx;
		color: #999999;
	}
	.shimingrenzheng{width: 100vw;padding: 20upx;box-sizing: border-box;display: flex;border-top:1upx solid black ;}
	.renzheng1{width: 80%;margin-top: 15upx;}
	.renzheng2{width: 15%;margin-top: 15upx;}
	.renzheng3{width: 5%;font-size: 36upx;margin-bottom: 10upx;}
</style>
