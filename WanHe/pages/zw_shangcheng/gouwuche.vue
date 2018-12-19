<template>
	<view>
		<view class="toubu"></view>
		<view class="gouwu_tou" v-if="kong">	
			<view class="bianji" @click="bianji(1)" v-if="isBianji==1">
				<icon class="iconfont icon-bianji" style="font-size:32upx ;"></icon>	
				编辑
				</view>
			<view class="bianji" @click="bianji(0)" v-else>
				<icon class="iconfont icon-biaozhundaan" style="font-size:32upx ;"></icon>
				完成
				</view>
		</view>
		
		<scroll-view scroll-y="true" style="padding-bottom: 100upx;padding-top: 82upx;" >
			<view class="gouwu_liebiao" v-for="(t,k) in shu.lie">
				<view class="liebiao_checkbox">
					<checkbox-group  @change="xuan" :id="k" >
						<checkbox :value="t.id" class="checkbox" :checked="t.checked" />
					</checkbox-group>
				</view>
				<view class="liebiao_tu">
					<image :src="t.tu" ></image>
				</view>
				<view class="liebiao_xiangqing">
					<view class="xiangqing_title">{{t.ming}}</view>
					<view class="xiangqing_kucun">库存：<text>{{t.kucun}}</text>{{t.danwei}}</view>
					<view class="xiangqing_jiage"><text>¥{{t.jiage}}</text>
						<view class="jia_jian">  
							<text class="shu_jian daxiao" @click="jiajian(k,0)">-</text>
							<input type="number" :value="t.shuliang"  class="shuliang"/>
							<text class="shu_jia daxiao"  @click="jiajian(k,1)">+</text>
						</view>
					</view>
				</view>
			</view>
		</scroll-view>
		
		<view class="gouwu_wei">
			<checkbox-group  @change="quanxuan">
				<label class="checkbox">
			        <checkbox  value="1" class="checkbox_all"/>全选
			    </label>
			</checkbox-group>
		
			<view class="zongji">总价:¥<text class="zongjia_shu">{{zongjia}}</text></view>
			<view @click="tijiao" class="jiesuan" v-if="isBianji">提交订单</view>			
			<view @click="shanchu" class="jiesuan" v-else>删除</view>
		</view>
		
		<view class="car_kong" v-if="!kong">
			<view class="car_tu">
				<icon class="iconfont icon-gouwuche1" style="font-size: 160upx;"></icon>
			</view>
			<view class="tishiyu">您还没有购买任何宝贝哦!</view>
			<navigator class="fanhuishouye" url="index">返回首页</navigator>
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{},
			zongjia:0,
			jiage:0,
			shangpin:{},
			ids:'',
			isBianji:1,
			kong:1,
		},
		
		onShow:function(){
			this.CSH();
		},
		
		methods:{
			CSH:function(){
				var _this = this;
				$z.post("m=zw_shangcheng&k=dingdan&x=gouwuche",function(shu){					
					if(shu.shi==1){
						_this.shangpin={};
						_this.shu = shu.shu;
	
						setTimeout(_this.jisuan(),300);						
					}else if(shu.shi==0){
						_this.kong=0;
					}							
				});
			}, 
			gouxuan:function(jiage){				
				this.jiage = jiage;
			},
			jisuan:function(){
				this.zongjia=0;
				this.ids='';
				if(!this.shangpin)return;
				
				for(var i in this.shangpin){
					if(this.shangpin[i]){					
						this.zongjia+=parseFloat(this.shu.lie[i].jiage)*parseFloat(this.shu.lie[i].shuliang); 
						this.ids+='_'+this.shu.lie[i].id;
					} 
				}
					
             
			},
			jiajian:function(k,e){				
				if(e){
					this.shu.lie[k].shuliang++;
				}else{
					this.shu.lie[k].shuliang--;
				}
				if(this.shu.lie[k].shuliang<1){
					this.shu.lie[k].shuliang=1; 
				}
				if(this.shu.lie[k].shuliang>this.shu.lie[k].kucun){					
					this.shu.lie[k].shuliang=this.shu.lie[k].kucun;				
				}	
				this.jisuan();
				$z.post('m=zw_shangcheng&k=dingdan&x=gouwuche&c=jia',{id:this.shu.lie[k].id,kucun:this.shu.lie[k].shuliang},function(s){
					if(!s.shi){
						$z.toast(shu.shu);
						this.shu.lie[k].shuliang--; 
					}
				})
				
			},
			xuan:function(e){	
				console.log(e)
				var k=e.mp.currentTarget.id;
				if(e.detail.value[0]){
					this.shangpin[k]=e.detail.value[0];
				}else{
					this.shangpin[k]='';
				}
				this.jisuan();			 	
			},
			quanxuan:function(e){				
				for(var i in this.shu.lie){	
					if(e.detail.value[0]){
						this.shu.lie[i].checked=1;
					}else{
						this.shu.lie[i].checked=0;
					}					 
					this.$set(this.shu.lie,i,this.shu.lie[i]);					
				} 
				if(e.detail.value[0]){
				   this.shangpin=this.shu.lie;
				}else{
					this.shangpin='';
				}				
			    this.jisuan();
			},
			tijiao:function(){
				if(this.ids){					
					uni.navigateTo({
						url:'querendingdan?ids='+this.ids
					})
				}else{
					$z.toast('请勾选商品');
				}
			},
			bianji:function(){
				 this.isBianji=!this.isBianji;				
			},
			shanchu:function(){
				var that=this;
				if(!this.shangpin)return;
				var g='';
				for(var i in this.shangpin){					
					g+=this.shangpin[i]+',';
				}
				g=g.substr(0,g.length-1);
				$z.post('m=zw_shangcheng&k=dingdan&x=gouwuche&c=shanchu',{ids:g},function(s){
					if(s.shi==1){
						that.CSH();
						that.bianji();
						
					}else{
						$z.toast(s.shu);
					}
				})
			}
			
		},
		
	}
</script>

<style>
page{background: #f7f7f7;overflow: hidden;}
.gouwu_tou{
	  position: fixed;
	  top: 60upx;
	  left: 0;
	  z-index: 1000;
		padding-right: 20upx;
		box-sizing: border-box;
		width: 100%;
		height: 80upx;
		text-align: right;
		line-height: 80upx;
		border-bottom: 1upx solid #f3f3f3;
		background: white;
	}
	.toubu{
			width: 100%;
			height: 50upx;
			background: #ce1e17;
			z-index: 10;
		}
.bianji{
		display: inline-block;
		color: #000000;
		width: 100upx;
		text-align: center;
	}
.gouwu_liebiao{
		width: 100%;
		height: 200upx;
		display:flex;
		flex-direction: row;
		padding: 20upx 30upx;
		background: white;
		margin-top: 5upx;
		margin-bottom: 10upx;
		box-sizing: border-box;
	}
.gouwu_liebiao>view{display: inline-block;}
.liebiao_checkbox{ 
	position: relative;
	width: 10%;
}
.checkbox{
	margin-top: 55upx;
}
.checkbox_all{
	margin-left: 30upx;
}
.liebiao_tu{
	width: 20%;
}
.liebiao_tu>image{
	margin-left: 10upx;
	width: 170upx;
	height: 170upx;
}
.liebiao_xiangqing{
	width: 70%;
	margin-left: 50upx;
	height: 200upx;
}
.xiangqing_title{
	width: 100%;
	height: 75upx;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}
	.xiangqing_kucun{
		width: 200upx;
		height: 55upx;}
	.xiangqing_jiage{
		width: 100%;
		height: 70upx;
	}
	.xiangqing_jiage>text{
		color: red;
		font-size: 35upx;
	}
	.jia_jian{
		float: right;
		margin-right: 40upx;
		margin-bottom: 20upx;
		width: 160upx;
		height: 50upx;
		}
	.shuliang{
		display: inline-block;
		width: 50upx;
		height: 55upx;
		text-align: center;
		box-sizing: border-box;
		border-top:1upx solid #EEEEEE ;
		border-bottom:1upx solid #EEEEEE ;
		vertical-align:top;
	}
	.daxiao{
		width: 55upx;
		height: 55upx;
		background-color: #EEEEEE;
		font-size: 40upx;
		text-align: center;
		display: inline-block;
	}
	
	.gouwu_wei{
		position: fixed;
		left: 0;
		bottom: 0;
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: left;
		width: 100%;
		height: 100upx;
		background: white;
	}
	.quanxuan{
		width: 25%;
		height: 100upx;
		line-height: 100upx;
		text-align: center;
	}
	.zongji{
		width: 50%;
		color: #f3312f;
		font-size: 35upx;
		text-align: center;
		height: 100upx;
		line-height: 100upx;
	}
	.jiesuan{
		position: absolute;
		top: 0;
		right: 0;
		width: 25%;
		background-color: #1c2536;
		color:#FFFFFF;
		text-align: center;
		margin: 0 auto;
		height: 100upx;
		line-height: 100upx;
	}

	.car_kong{
		width: 100%;
		margin-top: 300upx;
		box-sizing: border-box;
		text-align: center;
	}
	.car_tu{
		width: 100%;
		margin-top: 40upx;
		text-align: center;
	}
	image{
		width: 200upx;
		height: 200upx;
	}
	.tishiyu{
		color: #999999;
	}
	.fanhuishouye{
		margin-top: 40upx;
		background-color: #000000;
		color: #999999;
		font-size: 30upx;
		width: 200upx;
		height: 75upx;
		line-height: 75upx;
		margin-left: 280upx;
		border-radius: 10upx;
	}

</style>
