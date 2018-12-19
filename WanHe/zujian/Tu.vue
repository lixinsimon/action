<template>
	<view>
		<view class="tu">
			<navigator :url="shu.url" class="tu-image">			
						<image :src="shu.tu" class="tu_img" mode="widthFix"></image>			
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
	.tu{ 
		width: 100%;
		padding: 0 20upx;
		display: inline-block;
		margin-top: 20upx;
	}
	.tu>navigator{
		display: inline-block;
		border-radius: 20upx;
	}
	.tu_img{
		width: 706upx;
		}
</style>