<template>
	
	<view :class="{jinzhi:tankuang}">
		<view class="lunbo">
			<swiper indicator-dots="true" autoplay="true" indicator-active-color='#FFF' indicator-color='#B7D0E1' circular="true" class="lun_bo">
				<swiper-item  v-for="tu in shu.shangpin.xijietu" wx:key="*this">
					<image :src="tu" class="lunbo_img" mode="aspectFill" ></image>
				</swiper-item>
			</swiper>	
		</view>
		<view class="body" >
			<view class="item_title">
				<view >{{shu.shangpin.ming}}</view>
			</view>
			<view class="jiage">
				<text class="xianjia">¥{{shu.shangpin.jiage}}</text>
				<text class="yuanjia">¥{{shu.shangpin.yuanjia}}</text>
				<text class="hequan">
					<text>可获赠</text><text style="color:#f00;">{{shu.shangpin.jifen}}</text><text style="color: #b8700b;">和劵</text>
				</text>
			</view>
			<view class="jibenxinxi">
				<view class="xiaoliang">销量： {{shu.shangpin.chushoushu}}</view>
				<view class="kucun">库存：{{shu.shangpin.kucun}}{{shu.shangpin.danwei}}</view>
				<view class="yunfei">{{shu.shangpin.shuxing}}</view>
			</view>
		  <view  class="neirong">
			    <view v-html="shu.shangpin.xiangqing"></view>
			</view>
		</view>
		
		<view class="wei" v-if="DiBuCaiDan==1">
			<view class="kefu"  @click="KuFu">
				<view class="wei_tu iconfont icon-kefu1" style="font-size: 38upx;"></view>
				<text>客服</text>
			</view>
			<navigator class="dianpu" url="gouwuche" open-type="switchTab">
				  <view class="wei_tu iconfont icon-gouwuche1" style="font-size: 38upx;"></view>
				  <text>购物车</text>
			</navigator>
			<view class="jiarugouwuche" @click="gouwuche">加入购物车</view>
			<view class="lijigoumai"    @click="jili">立即购买</view>
		</view>
		
		
		<!-- 库存不足 -->
		<view class="wei" v-else-if="DiBuCaiDan==-2">
			<view class="kefu"  @click="KuFu">
				<view class="wei_tu iconfont icon-kefu1" style="font-size: 38upx;"></view>
				<text>客服</text>
			</view>			
			<view class="lijigoumai" style="width: 100%;">库存不足</view>
		</view>
		<!-- 兑换 -->
		<view class="wei" v-else-if="DiBuCaiDan==-5">
			<view class="kefu" @click="KuFu">
				<view class="wei_tu iconfont icon-kefu1" style="font-size: 38upx;"></view>
				<text>客服</text>
			</view>		
			<view class="lijigoumai" style="width: 100%;"  @click="duihuan">立即兑换</view>
		</view>
		
		
		
		
		<view class="zhao" v-show="tankuang" >
			
			<view class="zhe"></view>
			
			<view class="guige">
				<view class="head">
					<image :src="guige_tu" class="toutu"></image>
					<view class="xinxi">
						<view  class="guigeming">
							{{shu.shangpin.ming}}
						</view>
						<view class="xianjia1">￥{{guige.guige_xuanze_jiage}}<text class="iconfont icon-cuo" @click="cang"></text> </view>
						<view class="cunjian">库存：{{guige.guige_xuanze_kucun}}{{shu.shangpin.danwei}}</view>
					</view> 
				</view>
				
				<view class="body11">
					<view v-for="(g,i) in shu.guige">
							<view class="tt1">{{g.guigezu_ming}}</view>
							<!-- <view class="juti" v-for="(h,k) in g.haizi">
								   <view :class="{yan:(hhh==k)}" @click="neicun(k,h.guigezu_id)">{{h.guige_ming}}</view>							
							</view> -->
							<radio-group class="juti radio-group" @change="XuanZhongGuiGe">
									<label class="radio" v-for="(h,k) in g.haizi" @click="guigetu(h.guige_tu)">
											 <radio :value="h.guige_id"  :checked="h.checked"/>{{h.guige_ming}}
									</label>
							</radio-group>
					</view>
				</view>
				
				<view class="shuliang1">
					<text style="line-height: 80upx;">数量</text>
					<view class="jiajian" style="margin-top: 20upx;">
						<text class="on" @click="jiajian(0)">-</text>
						<text class="on" style="font-size: 30upx;background: white;line-height:60upx ;">{{shuliang}}</text>
						<text class="on" @click="jiajian(1)">+</text>
					</view>
				</view>
				
				
			</view>
		</view>
	</view>
</template> 

<script>
	import $z from '@/zhiwi'
	export default {
		data:{		
			shu:{shangpin:{}},		
			shuliang:1,
			guige:{guige_xuanze_chengben:0.00,guige_xuanze_kucun:0,guige_xuanze_jiage:0.00},
			tankuang:false,		
			guige_tu:'',		
			guigexunshun:{},
			DiBuCaiDan:1
		},
		onLoad:function(e){
			console.log(e)
			this.id=e.id;
			this.tankuang=false;
		//	this.id=1111
		},
		onShow:function(){
			this.CSH();
			this.tankuang=0;
		},
		methods:{ 
			CSH:function(){
				var that=this;				
				$z.post('m=zw_shangcheng&k=xiangqing',{id:that.id},function(shu){					
					if(shu.shi){ 
						$z.L(shu);
						that.shu=shu.shu;
						that.guige_tu=that.shu.shangpin.tu; 
						that.guige.guige_xuanze_chengben=	shu.shu.shangpin.chengben;	
						that.guige.guige_xuanze_jiage=	shu.shu.shangpin.jiage;
						that.guige.guige_xuanze_kucun=	shu.shu.shangpin.kucun;
					}
					that.DiBuCaiDan=shu.shi;
				}); 
			},
			guigetu:function(e){
				 if(e){
					  this.guige_tu=e;
				 }
				
			},
			XuanZhongGuiGe:function(e){	
				  var g='';				
					var eventid=e.mp.currentTarget.dataset.eventid.slice(6);					
				  this.$set(this.guigexunshun,eventid,e.mp.detail.value);			
				  for(var i in this.guigexunshun){
						  g+=this.guigexunshun[i]+'_';
					};
					g=g.substr(0,g.length-1);									
					if(this.shu.guige_xuanze[g]){
						this.guige=this.shu.guige_xuanze[g];
						this.shu.shangpin.kucun=this.guige.guige_xuanze_kucun;
						if(this.shuliang>this.shu.shangpin.kucun){
							   this.shuliang=this.shu.shangpin.kucun;
						}
					
					}
          
				
			},
			gouwuche:function(){
				  this.mai();
			    this.tankuang=1;				
			},
			cang:function(){
				this.tankuang=!this.tankuang;
			},
			jili:function(){ 			
				 this.mai(1);
				 this.tankuang=1;				 
			},	
			duihuan:function(){ 			
				this.mai(2);
				this.tankuang=1;				 
			},			
			jiajian:function(e){				
				if(e){
					this.shuliang++;
				}else{
					this.shuliang--;
				}
				if(this.shuliang<1){
					 this.shuliang=1;
				}
				if(this.shuliang>this.shu.shangpin.kucun){					
					  this.shuliang=this.shu.shangpin.kucun;				
				}
				
			},	
			mai:function(e){
				var that=this;
				if(!this.tankuang){
					return false;
				}		
				if(this.shu.shangpin.kaiqiguige==1 && !this.guige.id){					
					$z.toast('选择规格');
					return false;
				}
			
				if(!(this.shu.shangpin.kucun>0)){
					$z.toast('库存不足');
					return false;
				}
				var canshu='ids='+that.id+'&guigeid='+that.guige.id+'&shuliang='+that.shuliang;
				if(e==1){
					uni.navigateTo({
						url:'querendingdan?'+canshu
					})
				}else if(e==2){
					uni.navigateTo({
						 url:'dingdan_duihuan?'+canshu
					})
				}else{
					$z.post("m=zw_shangcheng&k=dingdan&x=gouwuche&c=tianjia&"+canshu,function(s){					
						$z.toast(s.shu);								
					})
				}
			},
			KuFu:function(){
					uni.makePhoneCall({
							phoneNumber: this.shu.kefu
					});
			}
		}
	}
</script>

<style>
	.guigeming{
		width: 390upx;
		height: 80upx;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
	}
	.hequan{
		min-width: 30%;
		margin-left: 10upx;
		border: 1upx solid #DCDCDC;
		text-align: center;
		font-size: 20upx;
		line-height: 30upx;
		margin-bottom: 5upx;
		display: inline-block;
	}
	.body11>view:last-child{
		margin-bottom: 50upx;
	}
	.jinzhi{
		position:fixed;
		left:0px;
		bottom:0px;
	}
	.zhe{
		width: 100%;
		height: 400upx;
		position: fixed;
		top: 0;
		left: 0;
		opacity: 0.5;
		background: #000000;
	}
	.guige{
		position: fixed;
		bottom: 100upx;
		left: 0;
		width: 100%;
		height: 893upx;
		background: white;
	}
	.body{width: 100%;overflow: hidden;}
	.yan1{
		background: #000000;
		color: white !important;
	}
	.yan{
		background: #000000;
		color: white !important;
	}
	.jiajian>.on{
		display: block;
		width:60upx;
		font-size: 40upx;
		background: #EEEEEE;
		float: left;
		text-align: center;
	}
	.jiajian{
		float: right;
		
	}
	.shuliang1{
		border-top: 1upx solid #EEEEEE;
		width:85%;
		height: 100upx;
		margin-left: 80upx;
		clear: both;
		position: fixed;
		bottom: 100upx;
		left: 0;
	}
	.juti view{
		float: left;
		padding: 10upx;
		box-sizing: border-box;
		margin-right: 40upx;
		border: 1upx solid #333333;
		color: #333333;
		font-size: 24upx;
	}
	.juti{
		width: 100%;
		color: #333333;
		
	}
	.tt1{
		line-height: 80upx;
		width: 100%;
		overflow: hidden;
	}
	.neirong{
		margin-bottom: 90upx;
	}
	.body11{
		width:85%;
		margin-left: 80upx;
		
		clear: both;
		min-height: 280px;
		max-height: 600upx;
		overflow-x: hidden;
		overflow-y: scroll;
	}
	
	.icon-cuo{
		color: #000000;
		font-size: 36upx;
		position: absolute;
		right: 30upx;
		top: 40upx;
	}
	.cunjian{
		color: dimgray;
		font-size: 24upx;
		margin-top: 25upx;
	}
	.xianjia1{
		overflow: hidden;
		color: red;
		width: 100%;
		font-size: 24upx;
	}
	.vip{
		float:left;
		color: white;
		background: #c49f51;
		border: 1upx #c49f51 solid;
		font-size: 24upx;
		text-align: center;
		line-height: 30upx;
		width: 80upx;
	}
	.vipjiage{
		float: left;
		color: #c49f51;
		border: 1upx #c49f51 solid;
		font-size: 24upx;
		text-align: center;
		line-height: 30upx;
		width: 120upx;
	}
	.xinxi{
		width: 62%;
		height: 180upx;
		float: right;
		margin-top: 8upx;
		margin-right: 30upx;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	.lunbo{		
		width: 100%;
		box-sizing: border-box;
		background-color: #f3f3f3;
		min-height: 500upx;
	}
	swiper{
		min-height: 500upx;
		text-align: center;
	}
	.lunbo_img{
		width: 100%;
		min-height: 500upx;		
	}
	.item_title{
		width: 100%;
		height: 80upx;
		margin-top: 6upx;
		position: relative;
		padding: 0 30upx;
		box-sizing: border-box;
		box-sizing: border-box;
		text-overflow: ellipsis;
        overflow: hidden;
        display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical10
	}
	.item_title view{
		width: 100%;
	}
	.jiage{
		width: 100%;
		height: 80upx;
		line-height: 80upx;
		padding: 0 30upx;
	}
	.jibenxinxi{
		display: flex;
		height: 80upx;
		line-height: 80upx;
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.xianjia{
		font-size: 40upx;
		color: #f3312f;
		display: inline-block;
		margin-right: 20upx;
	}
	.yuanjia{
		text-decoration: line-through;
		display: inline-block;
		color: #999999;
	}
	.jibenxinxi>view{
		width: 33.3%;
		color: #999999;
	}
	.kucun{
		text-align: center;
	}
	.yunfei{
		text-align: right;
	}
	.fuwu{
		display: flex;
		align-items: center;
		height: 80upx;
		line-height: 80upx;
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
		border-top: 1upx solid #F3F3F3;
	}
	.fuwu_item{
		width: 25%;
		color: #999999;
		text-align:center;
	}
	.fuwu_tu,.fenxiang_tu,.xiangyou_tu{
		width: 30upx;
		height: 30upx;
		vertical-align: middle;
	}
	.wei{
		display: flex;
		width: 100%;
		height: 100upx;
		box-sizing: border-box;
		align-items: center;
		position:fixed;
		bottom: 0;
		background: white;
	}
	.wei_tu{
		height: 50upx;
		line-height: 50upx;
	}
	.dianpu,.kefu{
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		width: 20%;
		box-sizing: border-box;
	}
	.dianpu{
		border-top: 1upx solid #F3F3F3;
		height: 100upx;
	}
	.kefu{
		height: 100upx;
		border-top: 1upx solid #F3F3F3;
		border-right: 1upx solid #F3F3F3;
	}
	.lijigoumai{
		width: 30%;
		box-sizing: border-box;
		text-align: center;
		color: #FFFFFF;
		background-color: #1c2536;
		height: 100upx;
		line-height: 100upx;
	}
	.jiarugouwuche{
		width: 30%;
		box-sizing: border-box;
		text-align: center;
		color: #FFFFFF;
		background-color: #999999;
		height: 100upx;
		line-height: 100upx;
	}
	.head{
		width: 94%;
		border-bottom: 1upx solid #EEEEEE;;
		float: right;
		position: relative;
		height: 200upx;
	}
	.toutu{
		position: absolute;
		left: 20upx;
		top: -40upx;
		width: 200upx;
		height: 200upx;
		border-radius: 20upx;
	}
</style>
