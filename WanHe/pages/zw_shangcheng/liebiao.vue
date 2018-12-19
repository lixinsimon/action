<template>
	<view>
		<view class="nav">
			<view :class="(active==0)?'nav-bar active':'nav-bar'" @click="qiehuan(0)">综合</view>
			<view :class="(active==1 || active==2)?'nav-bar active':'nav-bar'" @click="qiehuan(1)"> 
				<text>销量</text>
				<icon :class="(active==1)?'iconfont icon-xiangshang active':'iconfont icon-xiangshang'"></icon>
				<icon :class="(active==2)?'iconfont icon-xiangxia active':'iconfont icon-xiangxia'"></icon>
		    </view>
			<view :class="(active==3)?'nav-bar active':'nav-bar'" @click="qiehuan(3)">新品</view>	
				
			<view :class="(active==4 || active==5)?'nav-bar active':'nav-bar'" @click="qiehuan(4)">
				<text>价格</text>
				<icon :class="(active==4)?'iconfont icon-xiangshang active':'iconfont icon-xiangshang'"></icon>
				<icon :class="(active==5)?'iconfont icon-xiangxia active':'iconfont icon-xiangxia'"></icon>
			</view>
		
			
		</view>
		<view class="body">
			<navigator class="item" v-for="l in shu.shangpinlie" :url="'xiangqing?id='+l.id">
				<view class="item_tu">
					<image :src="l.tu" class="image"></image>
				</view>
				<view class="title">{{l.ming}}</view>
				<view class="jiage_yishou">
					<view class="jiage">¥{{l.jiage}}</view>
					<view class="yishou">出售 {{l.chushoushu}}</view>
				</view>
			</navigator>		
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	export default {
		data:{
			shu:{shangpinlie:{}},
			ye:1,
			jitiao:6,
			active:0			
		},
		onLoad:function(e){				
			this.id=e.id;		    
		},
		onShow:function(){
			this.CSH();			
		},
		onReachBottom:function(){
			this.jiazhai();
		},
		onPullDownRefresh:function(){
			this.CSH();			
			setTimeout(function () {
				uni.stopPullDownRefresh();
			}, 1000);
		},
		methods:{ 
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=liebiao&x=lie',{ye:1,jitiao:that.jitiao*that.ye,id:this.id,paixu:that.active},function(s){				
					if(s.shi==1){
						that.shu=s.shu; 
					}
				});				
			},
			qiehuan:function(e){
				if(this.active==1 && e==1){
					this.active=2;
				}else if(this.active==4 && e==4){
					this.active=5;
				}else{
					this.active=e; 
				}			
				this.CSH();
				
			},
			jiazhai:function(){
				var that=this;				
				$z.post('m=zw_shangcheng&k=liebiao&x=lie',{ye:that.ye+1,jitiao:that.jitiao,id:this.id,paixu:that.active},function(shu){			   
					if(shu.shi==1){	
						for(let i in shu.shu.shangpinlie){							
							that.$set(that.shu.shangpinlie,that.shu.shangpinlie.length,shu.shu.shangpinlie[i]);
						}						 	
						that.ye++; 
					}else{
						$z.toast('没有更多');
					}
					
				})
			}
		}
	}
</script>

<style>
	
	.icon-xiangshang{position:absolute;top:-24upx;left:115upx;font-size:20upx;color: #999999;}
	.icon-xiangxia{position:absolute;top:-10upx;left:115upx;font-size:20upx;color: #999999;}
	.item_tu{height: 320upx;}
	.tou{
		display: flex;
		width: 100%;
		padding: 0 30upx;
		height: 200upx;
		align-items: center;
		box-sizing: border-box;
		background-color: #000000;
		color: #FFFFFF;
	}
	.touxiang_tu{
		border-radius: 50%;
		width: 15%;
	}
	.dianpu_xiangqing{
		width: 85%;
	}
	.dianpu_title{
		height: 35upx;
		line-height: 35upx;
	}
	.jibie{
		display: inline-block;
		box-sizing: border-box;
		border:1upx solid #f3312f;
		color: #f3312f;
		font-size: 22upx;
		height: 35upx;
		line-height: 35upx;
		border-radius: 5upx;
	}
	.mingcheng{
		display: inline-block;
		box-sizing: border-box;
		height: 35upx;
		line-height: 35upx;
	}
	.gonggao{
		font-size: 22upx;
		height: 35upx;
		line-height: 35upx;
	}
	.nav{
		display: flex;
		box-sizing: border-box;
		width: 100%;
		height: 60upx;
		align-items: center;
		padding: 0 30upx;
		position: fixed;
		top: 0;
		background: #FFFFFF;
	}
	.nav-bar{
		display: flex;
		justify-content: center;
		width: 25%;
		color: #999999;
		position: relative;
	}
	.tu{
		width: 15upx;
		height: 15upx;
	}
	.active{
		color: #000000;
	}
	.tubiao{
		width: 10upx;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.tu_xia{
		margin-top: 5upx;
	}
	.image{
		width: 100%;
		height: 100%;
	}
	.body{
		display: flex;
		flex-wrap: wrap;
		width: 100%;
		box-sizing: border-box;
		margin-top: 60upx;
	}
	.item{
		width: 46%;
		margin-left: 20upx;
		margin-top: 10upx;
	}
	.title{
		overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
	}
	.jiage_yishou{
		display: flex;
		height: 50upx;
		line-height: 50upx;
		width: 100%;
	}
	.jiage{
		color: #f3312f;
		width: 50%;
	}
	.yishou{
		width: 50%;
		text-align: right;
		color: #999999;
		font-size: 20upx;
	}
</style>
