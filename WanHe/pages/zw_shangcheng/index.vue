<template>
	<view>	
		<view class="toubu"></view>		
		<view class="toubusousuo">
			<input type="text" value="" placeholder="请输入您要搜索的商品" placeholder-class="input" style="margin-left: 110upx; width:400upx;"/>
			<view>
				<page-head :title="title"></page-head>
				 <view class="uni-padding-wrap uni-common-mt">
					<view class="uni-list">
						<view class="uni-cell">
							<view class="uni-input">{{result}}</view>
						</view>
					</view>
					<view class="uni-btn-v">
						<view @tap="scanCode" class="iconfont icon-saoma" id="saoma"></view>
					</view>
				</view>
			</view>
			<icon class="iconfont icon-sousuo1" id="toubuaniu"></icon>
			<navigator class="iconfont icon-xiaoxi1" url="xiaoxi"></navigator>
		</view>
		 <view style="overflow: hidden;margin-top: 50upx;">
			<view v-for="l in zujian">
				<LunBo v-if="l.zujian=='lunbo'" :shu='l'></LunBo>
				<FenLei v-if="l.zujian=='fenlei'" :shu='l'></FenLei>
				<Tu4 v-if="l.zujian=='tu4'" :shu='l'></Tu4>
				<ShangPin3 v-if="l.zujian=='shangpin3'" :shu='l'></ShangPin3>
				<Tu v-if="l.zujian=='tu'" :shu='l'></Tu>
				<ShangPin v-if="l.zujian=='shangpin'" :shu='l'></ShangPin>
			</view>
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi'
	import LunBo from "@/zujian/LunBo.vue"
	import FenLei from "@/zujian/FenLei.vue"
	import Tu4 from "@/zujian/Tu4.vue"
	import ShangPin3 from "@/zujian/ShangPin3.vue"
	import Tu from "@/zujian/Tu.vue"
	import ShangPin from "@/zujian/ShangPin.vue"
	export default {
		data: {
			zujian: {}
		},
		   components: {
			FenLei,
			LunBo,
			Tu4,
			ShangPin3,
			Tu,
			ShangPin
		},
		onShow: function() {

		
		
			this.CHS();
		},
		onUnload: function() {
			this.result = '';
		},
		methods: {
			CHS: function() {
				var that = this;
				$z.post('m=zw_shangcheng', {
					k: 'index'
				}, function(s) {
					if (s.shi == 1) {
						that.zujian = s.shu.shuju;
					}
				});
			},
			scanCode: function() {
				var that = this
				uni.scanCode({
					success: function(res) {
						that.result = res.result
					},
					fail: function(res) {}
				})
			}
		}

	}
</script>
<style>
	.iconfont {
		font-size: 38upx;
		font-style: 0upx;
		margin-top: 23px;
	}

	.icon-xiaoxi1 {
	position:relative;
	left:610upx;
	top: -63upx;
	color: #fff;
	width: 40upx;
	}
.hequanqu{
	width: 100%;
	height: 200upx;
	margin: 20upx 0;
}
.hequanqu image{
	height: 100%;
	width: 100%;
}
	#saoma {
		width: 54upx;
		line-height: 41upx;
		font-size: 49upx;
		margin-left: 510upx;
		padding: 0;
		z-index: 15;
		margin-top: -38upx;
		color: white;
	}

	button::after {
		border: none;
	}

	.toubu {
		width: 100%;
		height: 50upx;
		background: #ce1e17;
		position: fixed;
		top: 0upx;
		z-index: 99999;
	}

	.toubusousuo {
		width: 80%;
		height: 60upx;
		text-align: center;
		margin-left: 49upx;
		margin-top: 0upx;
		position: absolute;
		top: 61upx;
		z-index: 10;
		
		background:rgba(165,88,88,0.6);
	}

	.input {
		margin-top: 6upx;
		font-size: 30upx;
		color:rgba(255,255,255,0.6);
	}

	.icon-sousuo1 {
		width: 20upx;
		position: absolute;
		top: -21upx;
		left: 33upx;
		color: #fff;
		z-index: 11;
	}
</style>
