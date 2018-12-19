<template>
	<view>
		<radio-group class="radio-group">
			<view class="moren" :style="'margin-left:'+panduan[i]*2+'rpx'"  v-for="(l,i) in shu" @touchmove="huadong($event,i)" @touchend="clear">
				<view class="left">
					<view class="xinxi">
						<text class="xingming">{{l.ming}}</text>
						<text class="dianhua">{{l.dianhua}}</text>
					</view>
					<view class="dizhi">
						<text class="moren_zi" v-if="l.moren==1">[默认地址]</text>
						<text class="moren_dizhi">{{l.shengshiqu}} {{l.dizhi}}</text>
					</view>
				</view>
				<label class="radio right" @click="xuanze(l.id)">
					<!-- <radio value="" :checked="l.moren"/> -->
					<view class="danxuan">
						<icon type="success" v-if="l.moren == 1"></icon>
					</view>
				</label>
				
				<view class="anniu">
					<!-- <view class="bianji" @click="bianji">编辑</view> -->
					<view class="shanchu" @click="shanchu(l.id)" style="background: #1c2536;">删除</view> 
				</view>
				
			</view>
		</radio-group>
		<navigator class="zengjiadizhi" url="../zw_shangcheng/zengjiadizhi">增新地址</navigator>
	</view> 
</template>
<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{},
			flag:0,
			move:[],
			panduan:[],
		},
		
		onShow:function(){
			this.CSH();
		},
		
		methods:{
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=wode&x=dizhi',function(shu){
					_this.shu = shu.shu;
					$z.L(shu.shu); 
				});
				this.panduan=[];
			},
			xuanze:function(e){
				var _this = this;
				$z.post('m=zw_shangcheng&k=wode&x=dizhi',{c:'shezhimoren',id:e},function(shu){
					$z.L(shu.shu); 
				});
				this.CSH();
			},
			huadong:function(event,i){
				if(this.move.length<1){
					this.move.push(event.clientX);
				}else if(this.move.length<2){
					this.move.push(event.clientX);
				}else{
					this.move[0]=this.move[1];
					this.move[1]=event.clientX
					
					if((this.move[1]-this.move[0])<0){
						this.panduan[i] = -140;
					}else if((this.move[1]-this.move[0])>=0){
						this.panduan[i] = 0;
					}
				}
			},
			clear:function(){
				this.move=[];
			},
			
			shanchu:function(id){
				$z.post('m=zw_shangcheng&k=wode&x=dizhi',{c:'shanchu',id:id},function(shu){
					
				})
				this.CSH();
			}
		}
	}
</script>
<style>
	page{width: 100vw;background-color: #dcdcdc;overflow: hidden;}
	.radio-group{width: 100vw;overflow: hidden;}
	.shanchu{background: black;}
	.moren{
		width: 140vw;
		display: flex;
		height: 150upx;
		box-sizing: border-box;
		background-color: #FFFFFF;
		margin-top: 10upx;
		margin-bottom: 20upx;
		padding: 10upx 30upx;
		position: relative;
		align-items: center;
		transition: 0.4s all;
	}
	.left{width: 70%;}
	.right{width: 10%;}
	.danxuan{width: 46upx;height: 46upx;border: 1upx solid #dddddd;border-radius: 50%;box-sizing: border-box;}
	.anniu{display: flex;width: 25%;height: 130upx;}
	.bianji,.shanchu{width: 100%;font-size: 36upx;background: #DCDCDC;color: white;display: flex;align-items: center;justify-content: center;}
	
	.xinxi{
		width: 100%;
		height: 40upx;
		font-size: 35upx;
	}
	.xingming{
		width: 200upx;
		height: 40upx;
		margin-right: 30upx;
	}
	.dianhua{
		width: 400upx;
		height: 40upx;
	}
	.dizhi{
		width: 100%;
		height: 40upx;
		margin-top: 10upx;
	}
	.moren_zi{
		color: #f3312f;
	}
	.check_tu{
		width: 50upx;
		height: 50upx;
	}
	.checked{
		position: absolute;
		right: 20upx;
		top: 50upx;
		opacity: 1;
	}
	.unchecked{
		position: absolute;
		right: 20upx;
		top: 50upx;
		opacity: 0;
	}
	.zengjiadizhi{
		width: 100%;
		height: 110upx;
		background-color: #1c2536;
		color: #FFFFFF;
		font-size: 40upx;
		text-align: center;
		line-height: 110upx;
		position: fixed;
		bottom: 0upx;
	}
</style>
