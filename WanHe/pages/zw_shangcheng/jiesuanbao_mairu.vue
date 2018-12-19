<template>
	<view >
		<view class="biaoti baise">{{shu.biaoti}}</view>
		<view class="shuliang baise">
			<input type="number" v-model:value="shuliang" :placeholder="shu.qitou+'和券起'"/>
			<!-- <view class="quanbumaru">全部买入</view> -->
		</view>
		<view class="shouming baise">
			<view  v-for="l in shu.shouyi">投入<text class="huangse">{{l.yuan}}</text>以上 日放量比例<text class="huangse">{{l.bilie}}%</text></view>
			<view>周期<text class="huangse">{{shu.tian}}</text>天 预计<text class="huangse">明天</text> 计算收益</view>
		</view>
		<view class="mairu_anniu" @click="mairu">买入</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:[],
			ye:1,
			jitiao:6
		},
		onLoad:function(e){
			this.id=e.id;			
		},
		onShow:function(){
			this.CSH();
		},
		methods:{
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=jiesuanbao&c=mairu',{id:that.id},function(shu){
					if(shu.shi==1){
						that.shu=shu.shu;
					}else{
						$z.toast(shu.shu);
					}
				})
			},
			mairu:function(){
				var that=this;			
				$z.post('m=zw_shangcheng&k=jiesuanbao&c=shengqingmairu',{id:that.id,shuliang:that.shuliang},function(shu){
					$z.toast(shu.shu);
					if(shu.shi){
						setTimeout(function(){
							uni.navigateTo({
								url: 'jiesuanbao_jilu',	 						
							});
						},1000)
					}
				})
			}
		
		},
	}
</script>

<style>
page{background: #F3F3F3;}
.baise{background: #FFFFFF;}
.huangse{color: #C49F51;}
.biaoti{padding: 20upx;margin-bottom: 1upx;}
.shuliang{padding: 30upx;}
.shuliang:before{
	 content: "数量：";
	 display: inline-block;
	 font-size: 50upx;
	 margin-right: 20upx;
}
.shuliang input{display: inline-block;}
.shouming{padding: 30upx; margin-top: 1upx; color: #888888;}
.quanbumaru{display: inline-block;float: right;}
.mairu_anniu{position: fixed;bottom: 0;background: #1c2536;color: #FFFFFF;padding: 30upx 0upx;text-align: center;width: 100%;font-size:40upx;}
</style>
