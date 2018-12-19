<template>
	<view>
		<view class="nav">
			<navigator url="">
				<view class="nav_bar active" >店铺</view>
			</navigator>
			<navigator url="">
				<view class="nav_bar">商品</view>
			</navigator>
		</view>
		<view class="dianpu_body" style="display: none;">
			<navigator class="dianpu_item">
				<view class="dianpu_item_tu">
					<image src="../../../static/tu/完成.png" class="tu"></image>
				</view>
				<view class="dianpu_item_title">美度官方旗舰店</view>
				<view class="dianpu_item_xiangqing">
					<text>查看详情</text>
				</view>
			</navigator>
			<navigator class="dianpu_item">
				<view class="dianpu_item_tu">
					<image src="../../../static/tu/完成.png" class="tu"></image>
				</view>
				<view class="dianpu_item_title">美度官方旗舰店</view>
				<view class="dianpu_item_xiangqing">
					<text>查看详情</text>
				</view>
			</navigator>
		</view>
		<view class="shangpin_body">
			<view class="shangpin_body_item">
				<view class="shangpin_item_tou">
					<view class="shangpin_tu">
						<image src="../../../static/tu/完成.png" class="tu"></image>
					</view>
					<view class="shangpin_item_body">
						<view class="shangpin_title">国外代购国外代购国外代购国外代购国外</view>
						<view class="shangpin_fenlei">儿童150克</view>
						<view class="jiage_shuliang">
							<view class="jiage">¥35.40</view>
							<view class="yuanjia">¥45.40</view>
							<view class="shuliang">X1</view>
						</view>
					</view>
				</view>
				<view class="shangpin_item_wei">
					<view class="gongji">
						共计1件 应付总额：
						<test class="zong_e">¥35.40</test>
						(含运费0.00)
					</view>
					<view class="xiangqing_jiesuan">
						<view class="xiangqing">查看详情</view>
						<view class="lijigoumai">立即购买</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
	export default {
		data() {
			return {
				
			};
		}
	}
</script>
<style>
	.nav{
		display: flex;
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
		border-bottom: 0.1upx solid #f3f3f3;
	}
	.nav>navigator{
		width: 50%;
		height: 55upx;
		display: flex;
		justify-content: center;
	}
	.nav_bar{
		width: 80upx;
		text-align: center;
		height: 50upx;
		color: #999999;
	}
	.active{
		border-bottom: 5upx solid #000000;
	}
	.dianpu_body{
		width: 100%;
		box-sizing: border-box;
	}
	.dianpu_item{
		display: flex;
		width: 100%;
		height: 180upx;
		align-dianpu_items: center;
		padding: 0 30upx;
		border-bottom: 0.1upx solid #f3f3f3;
		box-sizing: border-box;
	}
	.tu{
		width: 100upx;
		height: 100upx;
	}
	.dianpu_item_tu{
		width: 25%;
	}
	.dianpu_item_title{
		width: 50%;
	}
	.dianpu_item_xiangqing{
		width: 25%;
	}
	.dianpu_item_xiangqing>text{
		display: inline-block;
		height: 50upx;
		width: 150upx;
		border: 1upx solid #999999;
		color: #999999;
		text-align: center;
		line-height: 50upx;
	}
	.shangpin_body_item{
		width: 100%;
		box-sizing: border-box;
		height: 350upx;
	}
	.shangpin_item_tou{
		display: flex;
		justify-content: center;
		align-items: center;
		width: 100%;
		height: 200upx;
		padding: 0 30upx;
		border-bottom: 0.1upx solid #f3f3f3;
		box-sizing: border-box;
	}
	.shangpin_tu{
		width: 20%;
		height: 100upx;
	}
	.shangpin_item_body{
		width: 80%;
	}
	.shangpin_body{
		width: 100%;
		box-sizing: border-box;
	}
	.shangpin_fenlei{
		height: 50upx;
		line-height: 50upx;
		font-size: 22upx;
		color: #999999;
	}
	.shangpin_title{
		overflow: hidden;
		height: 50upx;
		width: 100%;
	}
	.jiage_shuliang{
		display: flex;
		align-items: center;
		height: 50upx;
	}
	.jiage{
		width: 20%;
		color: #f3312f;
	}
	.yuanjia{
		width: 10%;
		text-decoration: line-through;
		font-size: 22upx;
		color: #999999;
		margin-left: 10upx;
	}
	.shuliang{
		width: 70%;
		text-align: right;
	}
	.shangpin_item_wei{
		width: 100%;
		height: 150upx;
		padding: 0 30upx;
		box-sizing: border-box;
	}
	.gongji{
		color: #999999;
		text-align: right;
		height: 80upx;
		line-height: 80upx;
	}
	.zong_e{
		color: #f3312f;
	}
	
	.xiangqing_jiesuan{
		display: flex;
		justify-content: flex-end;
		align-items: center;
	}
	.xiangqing{
		height: 50upx;
		width: 150upx;
		border: 1upx solid #999999;
		color: #999999;
		text-align: center;
		line-height: 50upx;
		box-sizing: border-box;
		margin-right: 30upx;
		border-radius: 5upx;
	}
	.lijigoumai{
		height: 50upx;
		width: 150upx;
		background-color: #000000;
		color: #FFFFFF;
		text-align: center;
		line-height: 50upx;
		box-sizing: border-box;
	}
</style>
