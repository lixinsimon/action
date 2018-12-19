<template>
	<view>
		<form action="">
		<view class="querendingdan">
			<navigator url="dizhiguuanli" class="kuang">
				
				<icon class="iconfont icon-dizhi icon_left"></icon>
				<view class="dizhi_center" v-if="shu.dizhi">
					<view class="dizhi_center_top">
						<view>收货人：{{shu.dizhi.ming}}</view>
						<view>{{shu.dizhi.dianhua}}</view>
					</view>
					<view  class="dizhi_center_button">{{shu.dizhi.dizhi}}</view>				
				</view>
				
				<view class="dizhi_center" style="line-height:110upx;" v-else>
					请填写收货地址				
				</view>
				<icon class="iconfont icon-jiantou icon_right"></icon>	
			</navigator>		
			
			<view class="dingdan_items">
				<view v-for="(l,i) in shu.gouwuchelie">
					<view class="items"  v-for="(s,k) in l.shangpin">
						<image :src="s.tu" mode="widthFix" class="item_tu"></image>
						<view class="items_xiangqing">
							<view class="items_title">{{s.ming}}</view>
							<view class="items_leixing"></view>
							<view class="items_jiage">¥{{s.jiage}}</view>
							<view class="items_geshu">X <text>{{s.shuliang}}</text></view>
						</view>
					</view>
				</view>
				<view class="liuyan">
					<view class="liuyan_zi">买家留言:</view>
					<view class="shuruliuyan">
						<input type="text" maxlength="39" placeholder="限制在39个字内" />
					</view>
				</view>
			</view>
		    <view class="weibu">
		    	<view class="zongjia">
		    		<text>总计：</text>
					<text class="zongjia_shu">¥ {{shu.zongjia}} </text> 
					<text class="yunfei"> (含运费{{shu.yunfei}})</text>
		    	</view>
				<view class="qufukuan" @click="XiaDingDan">去付款</view>
		    </view>
		</view>
		</form>
		

		
		
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{
			shu:{}			
		},
		onLoad:function(e){	
			$z.L(e);
			this.ids=e.ids;
			this.guigeid=e.guigeid;
			this.shuliang=e.shuliang;
		},
		onShow:function(){
			this.CSH();			
		},
		methods:{ 
			CSH:function(){
				var that=this;	
				var dizhi=$z.Qu('dizhi');
				$z.post("m=zw_shangcheng&k=dingdan&x=querendingdan",{ids:that.ids,guigeid:that.guigeid,shuliang:that.shuliang},function(shu){
				    if(shu.shi==1){
						that.shu=shu.shu;					
						if(dizhi){that.shu.dizhi=dizhi;}
					}else{
						$z.toast(shu.shu);
					}
				})
			},
			XiaDingDan:function(){
				var that=this;
		
				$z.post("m=zw_shangcheng&k=dingdan&x=querendingdan&c=shengchengdingdan",{ids:that.ids,
						guigeid:that.guigeid,
						shuliang:that.shuliang,
						dizhi_id: that.shu.dizhi.id},function(shu){
					$z.L(shu);
					if(shu.shi==1){
						uni.redirectTo({
							url: 'zhifu?dingdanid='+shu.shu.dingdanid							
						});
					}else{
						$z.toast(shu.shu);
					}
				})
			}
		}
	}
</script>

<style>	
	page{
		background-color: #f3f3f3;
	}
	.querendingdan{width: 100%;overflow: hidden;}
	.kuang{height: 120upx;display: flex;padding:10upx;box-sizing:border-box;background: white;}
	.kuang icon{width: 10%;font-size: 36upx;text-align: center;margin-top: 20upx;}
	.dizhi_center{width: 80%;}
	.dizhi_center_top{display: flex;}
	.dizhi_center_top view{padding: 10upx;}
	.dizhi_center_button{padding-left:10upx	;}
/* 	.lianxia{
		width: 100vw;
		height: 60upx; 
		line-height: 60upx;
		display: flex;
	}
	.lianxia icon{
		width: 10%;
	}
	
	.shouhuo1{
		min-height: 150upx;
		width: 100%;
	}
	.querendingdan{
		width: 100%;
		padding: 0 30upx;
		box-sizing: border-box;
	}
	.dizhi{
		display: flex;
		flex-direction: row;
		width: 100%;
		min-height: 100upx;
		
		line-height: 100upx;
		position: relative;
		border-top:1upx solid #f3f3f3 ;
	}
	.dizhi text{}
	.icon{
		width: 30upx;
		height: 30upx;
		vertical-align: middle;
	} */
	.xiangyou_tu{
	    position:absolute;
		right: 0;
		top:35%;
	}
	.dingdan_items{
		width: 100%;
		height: 300upx;
		border-top: 0.2upx solid #f3f3f3;
		margin-bottom: 20upx;
	}
	.items{
		width: 100%;
		display: flex;
		flex-direction: row;
		background-color: #FFFFFF;
		margin-top: 10upx;
	}
	.items_xiangqing{
		margin-left: 100upx;
		width: 100%;
	}
	.item_tu{
		width: 150upx;
		height: 150upx;
		margin-top: 30upx;
		margin-left: 40upx;
	}
	.items_title{
		width: 100%;
		overflow: hidden;
		height: 60upx;
		line-height: 60upx;
	}
	.items_leixing{
		width: 100%;
		height: 60upx;
		line-height: 60upx;
		color: #989999;
		font-size: 25upx;
	}
	.items_jiage{
		display: inline-block;
		line-height: 60upx;
		height: 60upx;
		width: 50%;
		color: #f3312f;
	}
	.items_geshu{
		display: inline-block;
		line-height: 60upx;
		height: 60upx;
		width: 50%;
		text-align: right;
	}
	.liuyan{
		border-top: 0.1upx solid #f3f3f3;
		border-bottom: 0.1upx solid #f3f3f3;
		width: 100%;
		height: 100upx;
		display: flex;
		align-items: center;
		padding: 0 30upx;
		background-color: #FFFFFF;
		margin-top: 15upx;
	}
	.liuyan_zi{
		width: 20%;
		height: 100upx;
		line-height: 100upx;
	}
	.shuruliuyan{
		width: 80%;
		height: 100upx;
		line-height: 100upx;
		display: flex;
		justify-content: flex-start;
		align-items: center;
	}
	.weibu{
		position: absolute;
		bottom: 0upx;
		left: 0upx;
		box-sizing: border-box;
		bottom: 0upx;
		width:100%;
		height:100upx;
		display: flex;
		background-color: #FFFFFF;
	}
	.zongjia{
		width: 65%;
		height: 100upx;
		line-height: 100upx;
		text-align: center;
		font-size: 30upx;
	}
	.zongjia_shu{
		color: f3312f;
	}
	.qufukuan{
		width: 35%;
		background-color: #1c2536;
		color: #dcdcdc;
		font-size: 40upx;
		height: 100upx;
		line-height: 100upx;
		text-align: center;
	}
</style>
