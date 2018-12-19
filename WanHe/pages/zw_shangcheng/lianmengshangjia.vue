<template>
	<view>
		<view class="tou">
			<icon class="iconfont icon-sousuo1"></icon>
		<input type="text" value="" placeholder="请输入搜索的商家" class="input"/>
		</view>
		<view class="head">
			<button type="primary" @tap="chooseLocation" class="ding">
				<text class="iconfont icon-dizhi dizhide"></text>				
				<block v-if="hasLocation === false">
					<text class="uni-h2 uni-center uni-common-mt">未选择位置</text>
				</block>
				<block v-if="hasLocation === true">
					<text class="uni-hello-text uni-center" style="margin-top:10px;">
						{{locationAddress}}
					</text>
				</block>
			</button>
			<view class="ps">根据您所在地区选择实体店 30秒完成预约进店</view>
		</view>
		<view class="dizhi" v-for="didi in xun" wx:key="index">
			<view class="h1">
				<text>南京-德基广场店</text>	
				<text class="yuyue">进店预约</text>
			</view>
			<view class="xian"></view>
			<view class="h2">
				<text class="iconfont icon-dizhi"></text>	
				<text>江苏省南京市炫舞区中山路18号</text>
			</view>
			<view class="h2">
				<text class="iconfont icon-dianhua"></text>	
				<text>预约电话：15485226645</text>
			</view>
			<button class="kefu" open-type="contact" session-from="weapp">
				<image  src="http://qianxi.zhiwi.cn/gongyong/shangchuan/images//2018_11/tSEE00EZ7881f880EiZsqYsw77X88i.png"></image>
			</button>	
		</view>
		<DiZhi ref="dizhiku" :JiLianDong='JiLianDong' :ChuShiHua='ChuShiHua' @QueRen='QueRen'></DiZhi>
	</view>
</template>

<script>
	
	export default {
		data() {
			return {
				item:"南京",
				xun:4,
				ChuShiHua:[1,1,8],
				JiLianDong:3,
				hasLocation: false,
				locationAddress: ''
			};
		},
		methods:{
			chooseLocation: function () {
				uni.chooseLocation({
					success: (res)=>{
						this.hasLocation = true,
							this.locationAddress = res.address
					}
				})
			},
		}
	}
</script>

<style>
page{
	background:#F3F3F3;
	color: #333333;
}
.icon-sousuo1{
	float:left;
	margin-left:20upx;
	font-size:42upx;
	width:34upx;
	line-height:70upx;
	margin-top:30upx;
	position:absolute;
	left:66upx;
	z-index:2;
}
.input{
	width:90%;
	margin:0 auto;
	background:#bbb;
	position:relative;
	top:20upx;
	height:77upx;
	padding-top:8upx;
	border-radius:16upx;
}
.tou{
	width:100%;
	text-align: center;
	height: 100upx;
	line-height: 100upx;
	background: white;
	font-size: 32upx;
}
.head{
	width: 100%;
	height: 190upx;
	background: white;
	border: 1upx solid #F3F3F3;
}
.ding{
	width:670upx;
	margin: 20upx auto;
	height: 90upx;
	background: #FE739A;
	color: white;
	border-radius: 40upx;
	line-height: 90upx;
	text-align: center;
}
.dizhide{
	font-size: 43upx;
	margin-right: 20upx;
}
.ps{
	width: 100%;
	color: #999999;
	font-size: 24upx;
	text-align: center;
}
.dizhi{
	width: 90%;
	height: 210upx;
	margin: 20upx auto;
	background: white;
	border-radius: 20upx;
}
.h1{
	width: 90%;
	margin: 0 auto;
	line-height: 80upx;
}
.xian{
	width: 100%;
	height: 2upx;
	background:#F3F3F3;
}
.h2{
	width: 90%;
	margin: 10upx auto;
}
.h2 .iconfont{
	color: #999999;
	margin-right: 20upx;
}
.yuyue{
	float: right;
	color: #FE739A;
}
.kefu{
	width: 57upx;
	height: 202upx;
	position: fixed;
	right: 0;
	top: 48%;
	padding-left: 0px;
}
.kefu image{
	width: 57upx;
	height: 202upx;
}
</style>
