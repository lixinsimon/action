<template>
	<view>
		<view class="nav">
			<view class="nav_bar" @click="xuanzhong(0)" :class="{xuanzhong:index === 0}">
				<text>出售</text>				
			</view>
			<view class="nav_bar" @click="xuanzhong(1)" :class="{xuanzhong:index === 1}">
				<text>求购</text>		
			</view>
		</view>
		
		<swiper :current="index" @change="bindChang" class="swiper">			
			<swiper-item>
				<scroll-view class="jilu_view" scroll-y="true" :style="'height:'+cs_height+'px;'">
					<navigator class="jilu" v-for="(l,i) in shu[0]" :url="'jiaoyi_xiangqing?id='+l.id">
						<view class="left">
							<view class="left_top"><text>出售</text><text style=" color: #CC2E22;">{{l.shuliang}}</text>和券</view>
							<view class="left_botton">{{l.nicheng}}[会员ID:{{l.hyid}}]</view>
						</view>
						<view class="right">
							<text>+{{l.jiage}}</text>
							<view class="anniu_mai"><text>买入</text></view>
						</view>
					</navigator>
				</scroll-view>
			</swiper-item>
			<swiper-item>				
				<scroll-view class="jilu_view" scroll-y="true" :style="'height:'+qg_height+'px;'">
					<navigator class="jilu" v-for="(l,i) in shu[1]" :url="'jiaoyi_xiangqing?id='+l.id" >
						<view class="left">
							<view class="left_top"><text>求购</text><text style=" color: #CC2E22;">{{l.shuliang}}</text>和券</view>
							<view class="left_botton">{{l.nicheng}}[会员ID:{{l.hyid}}]</view>
						</view>
						<view class="right">
							<text>+{{l.jiage}}</text>
							<view class="anniu_mai"><text>卖他</text></view>
						</view>
					</navigator>
				</scroll-view>
			</swiper-item>
		</swiper>
		
		
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{		
			index:0,					
			shu:[{},{}],
			jitiao:10,
			ye:[1,1],
			
			cs_height:'',
			qg_height:'',
		},
		onShow:function(){
			this.CSH();
		},
		onPullDownRefresh:function(){
			setTimeout(this.jiazai(),200);
			uni.stopPullDownRefresh();
		},
		onReachBottom:function(){ 
			this.jiazai();
		},
		methods:{		
				CSH:function(){
						var that=this;
						if(that.shu.zhixing){
							return false;
						}
						that.shu.zhixing=1;
						setTimeout(function(){
							that.shu.zhixing=0;
						},200)
						$z.post('m=zw_shangcheng&k=jiaoyi',{ye:1,jitiao:that.ye[that.index]*that.jitiao,maimai:that.index},function(s){	
								if(s.shi){	
									var k=0;									
									for(var i in s.shu){
										that.$set(that.shu[that.index],k++,s.shu[i]);
									}
							}
							that.jisuangao();
						});
						
				},
				jiazai:function(){
						var that=this;
						$z.post('m=zw_shangcheng&k=jiaoyi',{ye:that.ye[that.index]+1,jitiao:that.jitiao,maimai:that.index},function(shu){					
							if(shu.shi){
								var leng=that.shu[that.index].length
								for(var i in shu.shu){
									that.$set(that.shu[that.index],leng++,shu.shu[i]);
								}
								that.ye[that.index]++;
							}else{
								$z.toast(shu.shu);
							}
							that.jisuangao();
						})
				},
				
				jisuangao:function(){
					var length = 0;
					for(var i in this.shu[this.index]){
						length++;
					}
					if(this.index == 0){
						this.cs_height=length*(74+1);
					}else if(this.index == 1){
						this.qg_height=length*(74+1);
					}
				},
				xuanzhong:function(index){				
					 this.index=index;			
					 this.CSH();
				},
				bindChang:function(e){		
					this.index = e.detail.current;
				  this.CSH();
				}			
		},
	}
</script>

<style>
	  .swiper{height:1110upx;}
		.nav{width: 100vw;height: 105upx;padding: 39upx 39upx 0 39upx;box-sizing: border-box;display: flex;justify-content: space-between;background: white;font-size: 28upx;}
		.nav_bar{width: 300upx;color: #999999;display: flex;justify-content: center;}	
		.xuanzhong{border-bottom: 4upx solid #CC2E22;color: #CC2E22;}		
		.jilu_view{width: 100vw;background: #F1EEEE;display: flex;flex-direction: column;font-size: 28upx;}
		.jilu{width: 100%;padding: 30upx;box-sizing: border-box;display: flex;background: white;margin-bottom:2upx ;justify-content: space-between;}
		.left{width: 50%;display: flex;flex-direction: column;}
		.left_botton{font-size: 24upx;color:#C3C3C3 ;}
		.right{display: flex;flex-direction: column;color: red;justify-content: flex-end;}		
		.anniu_mai{width: 80upx;height: 50upx;display: flex;border-radius: 10upx;justify-content: center;align-items: center;font-size: 24upx;color: white;background: #1c2536;}					
		::-webkit-scrollbar { width: 0; height: 0;color: transparent;}
</style>
