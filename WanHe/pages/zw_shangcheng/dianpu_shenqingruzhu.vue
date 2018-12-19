<template>
	<view>
		<form @submit="tijiao">
			<view class="tou">
				<image class="logobg" src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/V9cfE99rGGF4ysE9FRE49Fg644RAcY.png" mode="widthFix"></image>
				<view class="logo" @click="ShangTu('logo')">
					<image :src="shu.logo" mode="widthFix"  v-if="shu.logo"></image>
					<text v-else>+</text>					
				</view>		
				<input class="dianpuming" type="text" name='ming'  placeholder="店铺名" placeholder-style="color:white;"/>
			</view>
			
			<view class="shuruxiang">
				<image src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/zvyo7BmXoyMY62ie9z7jY228Zivz9I.png" mode="widthFix"></image>
				<input type="text"  name='gongsiming'  placeholder="公司名称"/>
			</view>
			<view class="fengexian"><view></view></view>
			<view class="shuruxiang">
				<image src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/uTtY6krzDunjyJJKTRWUDT9ytTdjTf.png" mode="widthFix"></image>
				<input type="number" name='dianhua'  placeholder="联系电话"/>
			</view>
			<view class="fengexian"><view></view></view>
			<view class="shuruxiang" >
				<image src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/Q1fN1ZdNNmj96pz9DOw3P4WNwDDFN9.png" mode="widthFix"></image>
				<input type="text" :value="shu.shengshiqu"  nama='shengshiqu' disabled placeholder="省市地区"  @click="XuanDiZhi"/>
			</view>
			<view class="fengexian"><view></view></view>
			<view class="shuruxiang">
				<image src="https://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/U0Tlb5LHH5t0rdF38t8KkH8P5dKbZP.png" mode="widthFix"></image>
				<input type="text"  name="dizhi" placeholder="详细地址"/>
				<icon class="iconfont icon-dizhi"></icon>
			</view>
				<view class="fengexian"><view></view></view>
				<view class="shuruxiang"  @click="ShangTu('zhizhao')" >		
					<view style="width: 650upx;">营业执照</view>
					<view  class="zhizhao">
						<image :src="shu.zhizhao" v-if="shu.zhizhao"/>
						<image src="http://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/EIjNIhdhAJCpUiHiI6k22IzNIiHssS.png" v-else/>					
					</view>
				</view>
			
			 <button class="tijiao"  formType="submit" v-if="!shenhe">申请入驻</button>	
		   <button class="tijiao" style="background: #C3C3C3;"  v-else>审核中</button>	
		</form>
		<DiZhi ref="dizhiku" :JiLianDong='JiLianDong' :ChuShiHua='ChuShiHua' @QueRen='QueRen'></DiZhi>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	import DiZhi from "@/zujian/DiZhi.vue"
	export default {
		data:{					
			shu:{shengshiqu:'',logo:'',zhizhao:''}, 
			ChuShiHua:[1,1,8],
			JiLianDong:3,			
			shenhe:1
		},
		onShow:function(){
			this.CSH();
		},		
		components:{DiZhi}, 
		methods:{
			CSH:function(){
				  var _this = this;
					$z.post('m=zw_shangcheng&k=dianpu&x=shenqingruzhu',{c:'panduan'},function(shu){
					     _this.shenhe =shu.shi;
							if(shu.shi==1){
									_this.shu=shu.shu;
									_this.shenhe ==1;
							}								
					});
			},
			tijiao:function(e){
			    var that=this;
					uni.showModal({
						title: '确认支付',
						content: '申请入驻需要200和券',
						success: function (res) {
								if (res.confirm) {
										that._tijiao(e.detail.value);
								}
						}
				});
			},
			_tijiao:function(s){
				var _this = this;				
				s.logo=_this.shu.logo;
				s.zhizhao=_this.shu.zhizhao;		
				s.shengshiqu=_this.shu.shengshiqu;	
				$z.post('m=zw_shangcheng&k=dianpu&x=shenqingruzhu',s,function(shu){	
					 $z.toast(shu.shu);
					  if(shu.shi){
							 $z.go();
						}
				});
				
			},
			ShangTu:function(a){
				var _this = this;
				$z.ShangTu(function(e){						
				    _this.$set(_this.shu,a,e.url);
				});			
			},
			XuanDiZhi:function(){
				this.$refs.dizhiku.DaKai();				 
			},	
			QueRen:function(e){
				// console.log(e)
				this.$set(this.shu,'shengshiqu',e.zhi);
			},
			mzsmkg:function (e) {
				this.mzsmflag=e;
			},
			yulan:function(e){
				uni.previewImage({
				  current: e, // 当前显示图片的http链接
				  urls: [e] // 需要预览的图片http链接列表
				});
			}
		}
	}
</script>

<style>
	page{background: #F3F3F3;width: 100vw;}
	.tou{width: 100vw;position: relative;}
	.logobg{width: 100%;}
	.logo{z-index: 10;background: white;width: 25vw;height: 25vw;border-radius: 20upx;position: absolute;top:8vw;left: 8vw;
				display: flex;justify-content: center;align-items: center;font-size: 80upx;overflow: hidden;}
	.logo>image{width: 100%;}
	.dianpuming{z-index: 10;position: absolute;top:21.5vw;left: 39vw;}
	
	.shuruxiang{background: white;padding: 30upx;width: 100vw;box-sizing: border-box;display: flex;align-items: center;}
	.shuruxiang>image{width: 36upx;height: 32upx;}
	.shuruxiang>input{flex-grow:1;margin-left: 10upx;}
	.shuruxiang>icon{font-size: 40upx;}
	.fengexian{width: 100%;background:white;}
	.fengexian>view{width: 95%;border-top: 1upx solid #E0E0E0;height: 0;margin: 0 auto;}
	
	/* .tupian{width: 100%;display: flex;background:url();padding: 0 30upx;box- */
	.zhizhao{width: 50upx;height:50upx;float: right;display: inline-block;} 
	.zhizhao image{width: 50upx;height: 50upx;} 
	.quxiao{height: 30upx;position: absolute;top: -5upx;right: -5upx;}
	
	.tongyi{width: 100vw;padding: 30upx;background: white;box-sizing: border-box;display: flex;align-items: center;color: #333333;}
	.tongyiyuan{width: 28upx;height: 28upx;border-radius: 50%;display: flex;justify-content: center;align-items: center;box-sizing: border-box;}
	.tongyi image{width: 28upx;height: 28upx;}
	.shuoming{margin-left: 10upx;}
	.tongyi text{color: #E1C178;border-bottom: 1upx solid #E1C178;}	
	.tijiao{width: 100vw;padding: 10upx 20upx;border: 0;background: #990134; color: #FFFFFF;border-radius: 0;position: fixed;bottom: 0;} 	
	.mianzeshengming_bg{z-index:1000; width: 100vw;height: 100vh;position: fixed;top: 0;left: 0;background: rgba(0,0,0,0.2);}
	.mianzeshengming{width: 90vw;height: 70vh;margin:10vh auto;background: white;overflow: hidden;overflow-y: scroll;padding:30upx;
						box-sizing: border-box;border-radius: 10upx;}
	
	.mzsm_tou{width: 100%;display: flex;color: #333333;font-size: 30upx;justify-content: center;align-items: center;position: relative;}
	.mzsm_tou>icon{position: absolute;top: -20upx;right:-10upx;font-size: 40upx;}
	::webkit-scrollbar{width: 0;height: 0;color: transprent;}
	
	
</style>
