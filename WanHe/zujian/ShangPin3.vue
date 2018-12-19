<template>
	<view>
		<view class="shangpin3">
			<navigator  v-for="l in shu.shangpin" :url="'./xiangqing?id='+l.id" class="shangpin_1">
				<image :src="l.tu" class="shangpin_tu"></image>
				<text class="ming">
					{{l.ming}}
				</text>
				<view class="yuanjia">
					<text class="jiage">¥{{l.jiage}}</text>
					<text style="margin-left: 10upx;">{{l.yuanjia}}</text>
					
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
	
	.hequan{
		min-width: 70%;
		margin-left: 10upx;
		border: 1upx solid #DCDCDC;
		text-align: center;
		font-size: 20upx;
		line-height: 30upx;
		margin-bottom: 5upx;
	}
	.shangpin3{
		display: flex;
		flex-direction:row;
		width: 100%;
		/* height: 390upx; */
		flex-wrap: wrap;
		/* margin-left:20upx; */
		padding: 10upx;
		box-sizing: border-box;
		align-items: center;
		justify-content: center;
	
	}
	.shangpin_1{width: 33%;padding: 10upx;box-sizing: border-box;}
	.shangpin_tu{
		width: 30vw;
		height: 30vw;
	}
	.ming{
		width: 200upx;
		font-size: 20upx;
		height: 50upx;
		display: inline-block;
		/* height: 80upx; */
		overflow: hidden;
        text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
	}
	.yuanjia{
		text-align: left;
		text-decoration: line-through;
		color: #CCCCCC;
	}
	.jiage{
		color: #F72929;
		display: inline-block;
		margin-left: 0upx;
	}
	.songliquan{
		float: right;
		margin-right: 4upx;
	}
	.liquan{
		width: 30upx;
		height: 18upx;
		margin-top: 10upx;
		float: right;
		margin-right: 4upx;
	}
</style>
