<template>
	<view>
		<view class="tou">
			<view class="tou_left" @click="FenLei">
				<text>分类</text>
				<icon class="iconfont icon-xiangxia"></icon>
			</view>			
				<view class="tou_right">
					<icon class="iconfont icon-sousuo1"></icon>
					<input type="text" v-model:value="guanjianci" @confirm="souso" confirm-type="search" placeholder="请输入你要搜索的内容"/>
				</view>
			
		</view>
		
		<view class="nav">
			<view class="nav_bar" @click="xuanzhong(1,0)" :class="{xuanzhong:index == 0}">
				<text>销售中</text>				
			</view>
			<view class="nav_bar" @click="xuanzhong(0,1)" :class="{xuanzhong:index == 1}">
				<text>已下架</text>
			</view>
		</view>

		
		<swiper :current="index" @change="bindChange" :style="'height:'+((xsz_height > yxj_height) ? xsz_height : yxj_height)+'px;'">
			<swiper-item >
				<scroll-view scroll-y="true" class="lie_view" :style="'height:'+xsz_height+'px;'">
					<view class="lie" v-for="item in shu[0]">
						<view class="lie_left">
							<image class="shangpintu" :src="item.tu" mode="widthFix"></image>
							<image class="dui" v-if="dui_flag" src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/lr6XD0G0XCe0M56tbM6MZGm6zrdPgb.png" ></image>
						</view>
						<view class="lie_right">
							<view class="biaoti">{{item.ming}}</view>
							<view class="shuoming">{{item.fenlei_yiji_ming}}-{{item.fenlei_erji_ming}}</view>
							<view class="shuoming">
								<text>库存 {{item.kucun}}</text>
								<text>赠品 和券{{item.hequan}}</text>
							</view>
							<view class="jiage">
								<text class="xianjia">￥{{item.jiage}}</text>
								<text class="yuanjia">￥{{item.yuanjia}}</text>
							</view>
							<view class="anniu_xiajia" @click="xiajia(item.id)"><text>下架</text></view>
						
						</view>
					</view>
				</scroll-view>				
			</swiper-item>
			
			<swiper-item >
				<scroll-view scroll-y="true" class="lie_view" :style="'height:'+yxj_height+'px;'">
					<view class="lie" v-for="item in shu[1]">
						<view class="lie_left">
							<image class="shangpintu" :src="item.tu" mode="widthFix"></image>
							<image class="dui" v-if="dui_flag" src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/lr6XD0G0XCe0M56tbM6MZGm6zrdPgb.png" ></image>
						</view>
						<view class="lie_right">
							<view class="biaoti">{{item.ming}}</view>
							<view class="shuoming">{{item.fenlei_yiji_ming}}-{{item.fenlei_erji_ming}}</view>
							<view class="shuoming">
								<text>库存 {{item.kucun}}&nbsp;&nbsp;</text>
								<text>赠品 和券{{item.hequan}}</text>
							</view>
							<view class="jiage">
								<text class="xianjia">￥{{item.jiage}}</text>
								<text class="yuanjia">￥{{item.yuanjia}}</text>
							</view>
							<view class="anniu_xiajia" @click="shangjia(item.id)"><text>上架</text></view>
						
						</view>
					</view>
				</scroll-view>				
			</swiper-item>
			
		</swiper>
		
		<LianDong ref="FenLeiLie" :JiLianDong='JiLianDong' :ChuShiHua='ChuShiHua' :ShuJu="ShuJu" @QueRen='QueRen'></LianDong>
		
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	import LianDong from "@/zujian/LianDong.vue"
	export default {
		data:{
			guanjianci:'',
			
			shu:[[],[]],
			
			index:0,
			zhuangtai:1,
			dui_flag:1,
			
			jitiao:10,
			ye:[1,1],
			tjc_ye:[1,1],
			
			xsz_height:'',
			yxj_height:'',
			
			fenlei:[],
			ChuShiHua:[0,0],
			JiLianDong:2,
			ShuJu:[]
		},
		components:{LianDong}, 
		onShow:function(){			
			this.CSH();
		},

		onPullDownRefresh:function(){
			this.CSH();
			setTimeout(uni.stopPullDownRefresh(),500);
		},
		onReachBottom:function(){ 
			this.jiazai();
		},
		
		methods:{
			CSH:function(){
				var _this = this;
				var k;			
				console.log(111)
				$z.post('m=zw_shangcheng&k=dianpu&x=shangpin',{ye:_this.ye,jitiao:_this.jitiao,zhuangtai:_this.zhuangtai,guanjianci:_this.guanjianci,fenlei:_this.fenlei},function(s){
					if(s.shi==1){
						console.log(2222222222)
						k=0;
						for(var i in s.shu.lie){
							_this.$set(_this.shu[_this.index],k++,s.shu.lie[i]);
						}			
						_this.jisuangao(k);
						_this.ShuJu=s.shu.fenlei;
					}
				});

				
			},
			
			jiazai:function(){
				var _this = this;
				var zt = 1;
				var leng;		
				$z.post('m=zw_shangcheng&k=dianpu&x=shangpin',{ye:_this.ye[_this.index]+1,jitiao:_this.jitiao,zhuangtai:_this.zhuangtai,guanjianci:_this.guanjianci,fenlei:_this.fenlei},function(s){
					if(s.shi){
						leng=_this.shu[_this.index].length;
						for(var i in s.shu.lie){
							_this.$set(_this.shu[_this.index],leng++,s.shu.lie[i]);
						}
						_this.ye[_this.index]++;
					}else{
						$z.toast(s.shu);
					}
					
				}); 
				
				setTimeout(function(){
					_this.jisuangao(leng);
				},200);
				
			},
			
			xuanzhong:function(e,index){
				this.zhuangtai=e;
				this.index=index;
			},

			xuanzefenlei:function(e){
				this.fenlei_xuanzhong=e;
			},
			
			bindChange:function(e){
				if(e.detail.current == 0){
					this.zhuangtai=1;
				}else if(e.detail.current == 1){
					this.zhuangtai=2;
				}

				this.index=e.detail.current;
				this.CSH();
			},
			
			FenLei:function(){
				this.$refs.FenLeiLie.DaKai();
			},
			
			
			QueRen:function(e){				
			   this.fenlei= e.id;
			   this.ye[this.index]=1;				
			   this.shu[this.index]=[]; 
			   this.CSH();	
					
			}, 
			
			jisuangao:function(e){
				var len = 0;
				for(var i in this.shu[this.index]){
					len++;
				}
				if(this.index == 0){
					this.xsz_height=len*(109+1);
				}else if(this.index == 1){
					this.yxj_height=len*(109+1);
				}
			},
			

			souso:function(e){
				this.ye[this.index]=1;				
				this.shu[this.index]=[]; 
				this.CSH();			
			},
			
			xiajia:function(e){
				var _this = this;

				$z.post('m=zw_shangcheng&k=dianpu&x=shangpin',{c:'xiajia',id:e},function(s){
					if(s.shi){
						$z.toast(s.shu);
						setTimeout(_this.CSH(),200);
					}else{
						$z.toast(s.shu);
					}
				}); 
			},
			shangjia:function(e){
				var _this = this;
				$z.post('m=zw_shangcheng&k=dianpu&x=shangpin',{c:'shangjia',id:e},function(s){
					if(s.shi){
						$z.toast(s.shu);
						setTimeout(_this.CSH(),200);
					}else{
						$z.toast(s.shu);
					}
				}); 
			},
		},

			
		
	}
</script>

<style>
	swiper{width: 100vw;}
	swiper-item{width: 100vw;}
	
	.tou{width: 100vw;padding: 41upx 30upx 21upx;box-sizing: border-box;display: flex;align-items: center;font-size: 28upx;}
	.tou_left{width: 110upx;display: flex;justify-content: center;align-items: center;}
	.tou_left>icon{font-size: 28upx;margin-top: -10upx;}
	.tou_right{flex-grow: 1;height: 60upx;display: flex;align-items: center;background: #F3F3F3;border-radius:30upx;}
	.tou_right>icon{width: 40upx;font-size: 38upx;margin-top: -10upx;margin-left: 20upx;color: #999999;}
	.tou_right>input{flex-grow: 1;}
	
	.nav{width: 100vw;height: 85upx;padding: 10upx 39upx 0 39upx;box-sizing: border-box;display: flex;justify-content: space-between;
			background: white;font-size: 28upx;}
	.nav_bar{width: 300upx;color: #999999;display: flex;justify-content: center;}
	.xuanzhong{border-bottom: 4upx solid #CC2E22;color: #CC2E22;}
	
	.lie_view{width: 100vw;height: 100%;margin-top: 1upx;display: flex;flex-direction: column;}
	.lie{width: 100vw;padding: 21upx 20upx 20upx 30upx;box-sizing: border-box;display: flex;margin-bottom: 1upx;z-index: 1000;}
	.lie_left{width: 179upx;height: 179upx;position: relative;background: #F3F3F3;overflow: hidden;display: flex;align-items: center;}
	.shangpintu{width: 100%;}
	.dui{position: absolute;width: 91upx;height: 91upx;top: 0;left: 0;}
	.lie_right{flex-grow: 1;height: 179upx;display: flex;flex-direction: column;position: relative;margin-left:20upx;}
	.lie_right>view{margin: 6upx 0;}
	.biaoti{font-size: 24upx;}
	.shuoming{font-size: 20upx;color: #999999;}
	.xianjia{color: #CC2E22;font-size: 28upx;}
	.yuanjia{color: #999999;font-size: 20upx;text-decoration: line-through;}
	.anniu_xiajia{position: absolute;width: 114upx;height: 56upx;display: flex;top:110upx;right:0;border-radius: 10upx;
				justify-content: center;align-items: center;font-size: 24upx;color: white;background: black;}
				
	.fenlei_viwe{width:150upx;height:110%;display: flex;flex-direction: column;position: absolute;top:95upx;background: white;padding: 5upx 0;}
	.fenlei{width: 100%;padding:10upx 5upx;text-align: center;}	
	.xuanzhongfenlei{background: rgba(0,0,0,0.2);}
	
	::-webkit-scrollbar { width: 0; height: 0;color: transparent;}
</style>
