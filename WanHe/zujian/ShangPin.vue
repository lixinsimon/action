<template>
	<view>
		<view class="shangpin">
			<navigator  v-for="l in shu.shangpin" :url="'./xiangqing?id='+l.id" class="shangpin_">
				<image :src="l.tu"  class="shangpin_tu_"></image>
				<text class="biaoti">
					  {{l.ming}}
				</text>
				<view class="jiege">
					  <text class="xianjia">¥{{l.jiage}}</text>
					  <text class="yuanjia">¥{{l.yuanjia}}</text>
				</view>
				<view class="hequan">
					<text>可获赠</text><text style="color: #FF0000;">{{l.jifen}}</text><text style="color: #b8700b;">和劵</text>
				</view>
			</navigator>			
		</view>
	</view>
</template>

<script>
	export default {
		props: ['shu']
	}
</script>
<style>
	.shangpin{
		display: flex;
		flex-direction:row;
		width: 100%;
		flex-wrap: wrap;
		justify-content: flex-start;
		
	}
	.shangpin_{
		width: 46%;
		min-height: 530upx;
		margin:5upx 0upx 1upx 20upx ;
		margin-bottom: 10upx;
	}
	.shangpin_tu_{
		width: 345upx;
		height: 345upx;
	}
	.biaoti{
		width: 335upx;
		height: 80upx;
		margin-left: 10upx;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		font-size: 32upx;
	}
	.xianjia{
		color: #FF0000;
		font-size: 40upx;
		margin-left: 10upx;
	}
	.yuanjia{
		text-decoration: line-through;
		color: #CCCCCC;
	}
	.vip{
		width: 100upx;
		height: 40upx;
		margin-left: 10upx;
		display: inline-block;
		border-radius: 1upx;
		font-weight:bold;
		text-align: center;
		background-color:#C49F51;
		color: #FFFFFF;
		border: 1upx solid #C49F51
	}
	.chengben{
		width: 120upx;
		height: 40upx;
		display: inline-block;
		border-radius: 1upx;
		text-align: center;
		border: 1upx solid #C49F51;
		color:#C49F51;
		
	}
	.liquan_{
		width: 30upx;
		height: 18upx;
		float: right;
		margin-top: 10upx;
		margin-right: 4upx;
	}
	.hequan{
		width: 60%;
		margin-left: 10upx;
		border: 1upx solid #DCDCDC;
		text-align: center;
		font-size: 20upx;
		line-height: 30upx;
		margin-bottom: 5upx;
	}
</style>