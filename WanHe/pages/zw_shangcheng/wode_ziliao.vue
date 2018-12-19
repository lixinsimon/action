<template>
	<view class="page">
		<view class="zhanghao_item" @click="touxiang">
			<text>头像</text>
			<image :src="shu.touxiang"  class="touxiang"></image>
		</view>
		<view class="zhanghao_item">
			<text>昵称</text>
			<input type="text" :value="shu.nicheng" v-model="shu.nicheng" class="nicheng shuru"/>
		</view>
		<view class="zhanghao_item">
			<text>姓名</text>
			<input type="text" :value="shu.xingming" v-model="shu.xingming" class="qianming shuru"/>
		</view>
<!-- 		<view class="zhanghao_item">
			<text>手机号</text>
			<input type="text" value="" class="haoma shuru"/>
			<text class="bangding">已绑定</text> 
		</view> --> 
		
		<view class="baocun">				
				<button @click="tijiao" class="button_baocun">保存</button>		
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
			this.CSH();
		},
		methods:{
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=wode&x=xiugaixinxi',function(shu){				
					_this.shu = shu.shu;				
				});
			
			}, 
			touxiang:function(){
			  	var _this=this;
					$z.ShangTu(function(e){							 
						   _this.shu.touxiang=e.url;
					});
			},
			tijiao:function(){
				   var _this = this;
					 if(_this.shu.touxiang==''){
					 	$z.toast('请上传头像');
					 	return false;
					 }
					 if(_this.shu.nicheng==''){
						  $z.toast('请输入昵称');
							return false;
					 }
					 if(_this.shu.xingming==''){
								$z.toast('请输入姓名');
								return false;
					 }
					 
				   $z.post('m=zw_shangcheng&k=wode&x=xiugaixinxi&c=xiugaixinxi',{touxiang:_this.shu.touxiang,nicheng:_this.shu.nicheng,xingming:_this.shu.xingming},function(shu){
						  $z.L(shu.shu);
				       if(shu.shi==1){								 
								   setTimeout($z.go(),500)
							 }
				   
				   });
			}
		}
	}
</script>

<style>
	.page{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.shuru{
		display: inline-block;
		height: 100upx;
	}
	.zhanghao_item{
		width: 100%;
		height: 110upx;
		line-height: 110upx;
		box-sizing: border-box;
		border-top: 1upx solid #dcdcdc;
		position: relative;
	}
	.zhanghao_item>navigator{
		display: inline-block;
		width: 100upx;
		height: 100upx;
		position: absolute;
		right: 0upx;
		text-align: center;
		background-color: #dcdcdc;
		border-radius: 50%;
	}
	.touxiang{
		width: 100upx;
		height: 100upx;
		margin-top: 6upx;
		float: right;
		border-radius: 50%;
	}
	.nicheng{
		position: absolute;
		right: 0upx;
		
	}
	.qianming{
		position: absolute;
		right: 0upx;
	}
	.haoma{
		position: absolute;
		right: 150upx;
	}
   .bangding{
	   display: inline-block;
	   width: 100upx;
	   height: 40upx;
	   line-height: 39upx;
	   font-size: 25upx;
	   box-sizing: border-box;
	   border: 1upx solid #000000;
	   border-radius: 10upx;
	   text-align: right;
	   position: absolute;
	   right: 0upx;
	   top: 50upx;
   }
	 	.button_baocun{
	 		width: 100%;
	 		color: #FFFFFF;
	 		height: 100upx;
	 		text-align: center;
	 		line-height: 100upx;
	 		font-size: 30upx;
	 		background-color: #1B2436;
	 		position: absolute;
	 		bottom: 0upx;
	 		right: 0upx;
	 		border-radius:0;
	 
	 	}
</style>
