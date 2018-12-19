<template>
	<view>
		<view class="tu4">
			<view class="zuo">
				<navigator :url="shu.tu4[0].url">
					<image class="tu_zuo" :src="shu.tu4[0].tu"></image>
				</navigator>
			</view>
			
			<view class="you">
				<view class="you_shang">
					<navigator :url="shu.tu4[1].url" >
						<image class="tu_you_shang" :src="shu.tu4[1].tu"></image>
					</navigator>
				</view>
				<view class="you_xia">
					<navigator :url="shu.tu4[2].url" >
						<image class="tu_you_xia1" :src="shu.tu4[2].tu" ></image>
					</navigator>
					<navigator :url="shu.tu4[3].url" class="you_xia2">
						<image class="tu_you_xia2" :src="shu.tu4[3].tu" ></image>
					</navigator>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		props: ['shu']
	}
</script>

<style>
	.tu4{
		width: 100%;
		height: 400upx;
		display: flex;
		box-sizing: border-box;
		flex-wrap:wrap;
		}
		
	.zuo{ padding: 0 0 0 20upx; display: inline-block;}
	.tu_zuo{ width: 300upx;height: 370upx; }
	
	.you{ 
		padding: 0 0 0 5upx;
		display: inline-block;
		width: 410upx;
		height: 375upx;
	}
	.you view{
		display: inline-block;
		width: 410upx; 
		height: 180upx;
	}
	.you_xia navigator{
		display: inline;
	}
	.tu_you_shang{width: 410upx; height: 180upx;}
	.tu_you_xia1{width: 202upx; height: 180upx;}
	.tu_you_xia2{width: 205upx; height: 180upx;margin-left: 2upx;}
</style>
 