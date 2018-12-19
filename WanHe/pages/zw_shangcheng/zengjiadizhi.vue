<template>
	<view>
		<form @submit="tijiao" style="overflow: hidden; width: 100%;">
			<view class="dizhi_item">
				<view>收货人</view>
				<input type="text" :value="shu.ming" name='ming' placeholder="请输入姓名" class="shouhuoren"/>
			</view>
			<view class="dizhi_item">
				<view>手机号码</view>
				<input type="phone" :value="shu.dianhua"  name='dianhua' placeholder="请确保手机畅通" class="dianhua"/>
			</view>
			<view class="dizhi_item">
				<view>所在地区</view>
				<input type="text" :value="shu.shengshiqu" name='shengshiqu' class="suozaidiqu" @click="XuanZhiDi" disabled/>
			</view>
			<view class="dizhi_item">
				<view >详细地址</view>
				<input type="text"  :value="shu.dizhi" name='dizhi' class="xiangxidizhi"/>
			</view>
			<view class="baocun">				
				   <button formType="submit" class="button_baocun">保存</button>		
			</view>
		</form>		
		<DiZhi ref="dizhiku" :JiLianDong='JiLianDong' :ChuShiHua='ChuShiHua' @QueRen='QueRen'></DiZhi>
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	import DiZhi from "@/zujian/DiZhi.vue"
	export default {
		data:{
			ChuShiHua:[1,1,8],
			JiLianDong:3,	
			shu:{shengshiqu:''}
		},
		components:{DiZhi}, 
		methods:{
			tijiao:function(e){				
				$z.post('m=zw_shangcheng&k=wode&x=dizhi&c=post',e.detail.value,function(s){
					$z.toast(s.shu);
					if(s.shi==1){
						setTimeout($z.go(),500);						
					}
				})				
			},		
			XuanZhiDi:function(){
				 this.$refs.dizhiku.DaKai();				 
			},	
			QueRen:function(e){
				this.$set(this.shu,'shengshiqu',e.zhi);
			}		
		},
	}
</script>

<style>
	page{
		background-color: #f3f3f3;
		width: 100%;
		overflow: hidden;
	}
	.dizhi_item{
		display: flex;
		flex-direction: row;	
		height: 80upx;
		padding: 15upx 30upx;
		line-height: 120upx;
		border-top: 1upx solid #f3f3f3;
		background-color: #FFFFFF;
	}
	.dizhi_item>view{
		width: 20%;
		height: 80upx;
		line-height: 80upx;
		
	}
	.dizhi_item>input{
		width: 80%;
		height: 60upx;
		line-height: 60upx;
		margin-left: 20upx;
	}
	.baocun{
		width: 100%;
		height: 100upx;
		position: absolute;
		bottom: 0upx;
	}
	.baocun>label{
		display: block;
		width: 50%;
		height: 100upx;
		line-height: 100upx;
		text-align: center;
	}
	.button_baocun{
		width: 100%;
		color: #FFFFFF;
		height: 100upx;
		text-align: center;
		line-height: 100upx;
		font-size: 30upx;
		background-color: #1c2536;
		position: absolute;
		bottom: 0upx;
		right: 0upx;
		border-radius:0;

	}
	.check_tu{
		width: 50upx;
		height: 50upx;
	}
	.checked{
		position: absolute;
		left: 20upx;
		bottom: 25upx;
		opacity: 1;
	}
	.unchecked{
		position: absolute;
		left: 20upx;
		bottom: 25upx;
		opacity: 0;
	}
</style>
