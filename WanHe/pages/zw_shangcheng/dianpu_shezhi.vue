<template>
	<view>
		<view class="item">
			<view>店铺头像</view>
			<view style="display: flex;justify-content: flex-end;flex-grow: 1;">
				<view class="touxiang" @click="xuantu">
						<image :src="shu.logo" v-if="shu.logo" mode="widthFix"></image>
				</view>
			</view>
		</view>
		<view class="item">
			<view>店铺名称</view>
			<view class="shuru">
				<input type="text" :value="shu.ming" v-model="shu.ming"  placeholder="名称"/>
			</view>
		</view>
		<view class="item">
			<view>店铺简介</view>
			<view class="shuru">
				<input type="text" :value="shu.jianjie" v-model="shu.jianjie" placeholder="请输入十五个字" />
			</view>
		</view>
		<view @click="tijiao" style="width: 100%; box-sizing: border-box;padding: 0 30upx;">
			<view class="queding">确定</view>
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
				  var that=this;
				  $z.post('m=zw_shangcheng&k=dianpu',{c:'shengqing'},function(shu){
						  if(shu.shi){
								that.shu=shu.shu;
							}
					});
			},
			tijiao:function(){
					var that=this;
					$z.post('m=zw_shangcheng&k=dianpu',{c:'shezhi',logo:that.shu.logo,ming:that.shu.ming,jianjie:that.shu.jianjie},function(shu){
							if(shu.shi){
							   that.CSH();
							}
							$z.toast(shu.shu);
					});
					
			},
			xuantu:function(){
					var _this = this;
						$z.ShangTu(function(e){							
							 _this.shu.logo=e.url;
						});
			}
		},
	}
</script>

<style>
	page{
	  background-color: #f3f3f3;
	 }
	.item{
		background-color: #FFFFFF;
		width: 100%;
		height: 120upx;
		display: flex;
		align-items: center;
		padding: 0 30upx;
		box-sizing: border-box;
		border-top: 0.1upx solid #f3f3f3;
	}
	.shuru{flex-grow: 1;}
	input{
		width: 100%;
		text-align: right;
	}
	.item>view{
		width: 25%;
	}
	.touxiang{
		background:url(https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018/12/mW2IfUgJ7S174SW1Ju7Z4OJqu6Z3X6.png) no-repeat ; 
		background-size:100%;
		width: 100upx;
		height: 100upx;
		border-radius: 50%; 
		overflow: hidden;
	}
	.touxiang>image{
		background: white;
		width: 100%;
		height: 100%;
	} 
	.queding{
		background-color: #1c2536;
		margin-top: 30upx;
		color: #FFFFFF;
		text-align: center;
		border-radius: 10upx;
		height:80upx;
		line-height: 80upx;
	}
</style>
