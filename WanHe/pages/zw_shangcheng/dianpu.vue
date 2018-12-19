<template>
	<view style="z-index: 99;">		
		<view class="tou">
			<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/PZLS6WdULZ8d0s6F2LA6HlL6VAo29y.png"  class="tu"></image>
			<view class="touxiang">
				<image :src="shu.logo" class="touxiang_tu"></image>
			</view>
			<view class="nicheng">{{shu.ming}}[ID:{{shu.id}}]</view>
			<view class="nicheng">{{shu.jiejian}}</view>
		</view>
		
		<view style="width: 100%;padding: 0 50upx;box-sizing: border-box;">
				<view class="body_tou">
					<navigator class="body_tou_item"  url="wode_qianbao?zhuangtai=1">
						<view class="shouru">{{shu.keti}}</view>
						<view class="zi">可提现收益</view>
					</navigator>
					<navigator class="body_tou_item"  url="dianpu_jifen?zhuangtai=0">
						<view class="dingdan">{{shu.jifen}}</view> 
						<view class="zi">赠和券</view>
					</navigator>
					<navigator class="body_tou_item"  url="wode_qianbao?zhuangtai=100">
						<view class="xiaoliang">{{shu.leiji}}</view>
						<view class="zi">累计收益</view>
					</navigator>
				</view>
			</view>
		<view style="width: 100%;padding: 0 50upx;box-sizing: border-box;">
			<view class="body_wei">
				<navigator class="body_wei_item" url="dianpu_dingdan">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/S2zKCK8hHYkyS1T5P5TWdOtk5557w2.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">订单管理</view>
				</navigator>	
				<!-- <view class="body_wei_item" @click="zhezhao">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/FPpjzjIh6J0KkM7M7ee7m808pJq9P8.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">发货管理</view>
				</view> -->
				<!-- <navigator class="body_wei_item" url="wodetuandui">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/VF1533aF1Y1x5YYYF4axXOm4X1yVa1.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">售后管理</view>
				</navigator> -->
				<navigator class="body_wei_item" url="leijitixianshouyi">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/cVIvh65LI25ZH6Pr8vLRILr53pf882.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">提现明细</view>
				</navigator>
				<!-- <navigator class="body_wei_item" url="tixian">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/QO4c1k0kkk94Cn2H84IC89ES4Y096Y.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">精选销量</view>
				</navigator> -->
				<navigator class="body_wei_item" url="dianpu_shangpin">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/uYM6p077BM51M9oemEk7mI5y5T1z67.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">商品管理</view>
				</navigator>
				<navigator class="body_wei_item" url="dianpu_shezhi">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/IMX4hMhzQXJ3vhrh44MAm3xrj4hdv4.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">店铺设置</view>
				</navigator>
				<!-- <navigator class="body_wei_item" url="dianpuzhinan">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/oC8K5QZC85ozaV95C5zu3dZQ95qucV.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">店铺指南</view>
				</navigator>
				<navigator class="body_wei_item" url="wodedianpu">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/b4XsAapsUpZxfVXPOWfU2dYo3hSatt.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">查看店铺</view>
				</navigator> -->
				
				<navigator class="body_wei_item" url="dianpu_fabushangpin">
					<view class=""><image src="http://daka.zhiwi.cn/gongyong/shangchuan/images//2018_11/b4XsAapsUpZxfVXPOWfU2dYo3hSatt.png" mode="widthFix" class="item_tu"></image></view>
					<view class="">发布商品</view>
				</navigator>
				<view class="haibaotuiguang_bg" v-if="xiaoshi">
					<image mode="widthFix" class="haibao" :src="haibao" @click="quxiao"></image>
					<view class="baocuntupian" @click="xiazai">保存图片</view>
					<icon class="xiazai iconfont icon-icon--" @click="xiazai"></icon>
				</view>	
				
			</view>
		</view>
		
		<view class="meiyoukaidian" v-if="kaidian<1">
			<image src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/p2R30SPDXKD3D0RwDdkEii2IkURzDU.png" mode="widthFix"></image>
			<view>{{shu}}</view>
			<navigator class="lijikaidian" url="dianpu_shenqingruzhu" v-if="shu.shi!=-3">立即开店</navigator>
		</view>
	</view>
	
</template>

<script>
	import $z from '@/zhiwi';
	export default {		
		data:{
			shu:{},
			xiaoshi:false,
			haibao:"",
			kaidian:0
		},
		onShow:function(){			
			this.CSH();
		},
		methods:{

			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=dianpu',function(shu){
					that.shu=shu.shu; 
					that.kaidian=shu.shi;
					if(shu.shi===0){
						  $z.toast(shu.shu); 						
					}
				})
			},
			zhezhao:function(){
			    var that=this;
				$z.post('m=zw_shangcheng&k=fenxiao&x=tuiguang',{c:'xiazhai'},function(s){					
					if(s.shi==1){
						that.haibao=s.shu;
						that.xiaoshi=true;
					}else{						
						$z.toast(shu.shu);						
					}
					
				})
				
				
			},
			quxiao:function(){
				this.xiaoshi=false
			},
			xiazai:function(){
				uni.saveImageToPhotosAlbum({
					filePath: this.haibao,
					success: function () {
						console.log('save success');
						uni.showToast({
							title: '保存成功', 
							duration: 2000
						});
					},
					fail:function(){
						console.log('保存失败') 
						uni.showToast({
							title: '保存失败',
							icon:'none',
							duration: 2000
						});
					}
				});
			},	
		}
	};
</script>

<style>
	page{
		background-color: #f3f3f3;
		z-index: 1;
	}
	.tu{
		width: 100%;
		height: 340upx;
		z-index: -1;
		position: absolute;
		left: 0upx;
		top: 0upx;
	}
	.tou{
		z-index: 999;
		width: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		
	}
	.touxiang{
		display: flex;
		align-items: center;
		justify-content: center;
		box-sizing: border-box;
		width: 130upx;
		height: 130upx;
		border-radius: 50%;
	}
	.touxiang_tu{
		width: 100upx;
		height: 100upx;	
		border-radius: 50%;
		
	}
	.nicheng{
		color: #FFFFFF;
		text-align: center;
		height:50upx;
		line-height: 50upx;
		width: 100%;
		box-sizing: border-box;
	}
	.body{
		width: 100%;
		box-sizing: border-box;
		background-color: #F3F3F3;
		z-index: 999;
	}
	.body_tou_item{
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.zi{
		margin-top: 10upx;
		color: #999999;
	}
	.body_tou{
		display: flex;
		align-items: center;
		justify-content: center;
		background-color: #FFFFFF;
		box-sizing: border-box;
		width: 100%;
		border-radius: 10upx;
		height: 200upx;
	}
	.body_tou_item{
		width: 30%;
		height: 150upx;
	}
	.body_wei{
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		background-color: #FFFFFF;
		margin-top: 30upx;
		border-radius: 10upx;
	}
	.body_wei_item{
		width:33.3%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		height: 200upx;
	}
	.item_tu{
		width: 60upx;
		height: 60upx;
	}
	
	
	.haibaotuiguang_bg{z-index:1000;width: 100vw;height: 100vh;position: fixed;top: 0;left: 0;right: 100vw;bottom: 100vh;overflow: hidden;background: black;
						display: flex;align-items: center;justify-content:center;overflow-y: scroll;}
	.haibao{width: 100vw;;display: block;}
	.baocuntupian{position: fixed;top: 90vh;width: 150upx;margin: 0 auto;font-size: 30upx;color: white;text-align: center;background: rgb(0,0,0,0.5);border: 1upx solid white ;}
	.xiazai{position: fixed;top: 90vh;right: 5vw;font-size: 48upx;color: white;}
	
	.meiyoukaidian{z-index: 1000;position: fixed;top: 0;left: 0;width: 100vw;height: 100vh;display: flex;align-items: center;justify-content: center;flex-direction: column;background: white;}
	.meiyoukaidian>image{width: 30vw;}
	.meiyoukaidian>view{display: inline;margin-top: 20upx;color: #CCCCCC;}
	.lijikaidian{width: 28vw;padding: 20upx;background: #000000;color: white;text-align: center;margin-top: 30upx;border-radius: 10upx;}
</style>
