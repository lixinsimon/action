<template>
	<view class="page">
		<view class="zhanghao_item">
			<text>头像</text>
			<view @click="xuantouxiang" style="width: 80upx;height: 80upx;border-radius: 50%;">
				<image :src="touxiang" mode="widthFix" class="touxiang"></image>
			</view>
		</view>
		<view class="zhanghao_item">
			<text>昵称</text>
			<input type="text" value=""  class="nicheng shuru"/>
		</view>
		<view class="zhanghao_item">
			<text>个性签名</text>
			<input type="text" value="" class="qianming shuru"/>
		</view>
		<view class="zhanghao_item">
			<text>手机号</text>
			<input style="width: 60%;" type="text" value="" class="haoma shuru"/>
			<text class="bangding">已绑定</text>
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			touxiang:'',
		},
		methods:{
			xuantouxiang:function(){
				var _this = this;
				$z.ShangTu(function(e){				
						_this.touxiang=JSON.parse(e.data).url;
				});	
			}
		},
	}
</script>

<style>
	.page{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	
	.zhanghao_item{
		width: 100%;
		height: 110upx;
		line-height: 110upx;
		box-sizing: border-box;
		border-top: 1upx solid #dcdcdc;
		position: relative;
		display: flex;
		justify-content: flex-start;
	}
	.zhanghao_item>view{
		display: inline-block;
		width: 100upx;
		height: 100upx;
		position: absolute;
		right: 0upx;
		top:10upx;
		text-align: center;
		background-color: #dcdcdc;
		border-radius: 50%;
		overflow: hidden;
	}
	.zhanghao_item>text{width: 20%;}
	.shuru{
		width: 80%;
		height: 100%;
		flex-grow:1 ;
	}
	.touxiang{
		width: 80upx;
		height: 80upx;
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
	   text-align: center;
	   position: absolute;
	   right: 0upx;
	   top: 50upx;
   }
</style>
