<template>
	<view class="fenlei">
		<navigator v-for="l in shu.fenlei"  :style="'width:'+ width+'%'" :url="l.url">		
				<view class="img">
					<image :src="l.tu" class="img"></image>
				</view>			
				<text>{{l.ming}}</text>		 
		</navigator>	
	</view>
</template>

<script>
	export default {
	  data () {
	    return {
        width:20
	    }
	  },
	  props: ['shu']
	
	}

</script>

<style>
  .fenlei{width: 123%;display: flex;flex-direction: row;padding: 20upx 0upx;flex-wrap: wrap;}	
  .fenlei navigator{flex-direction: column;display:flex; margin-bottom: 20upx;}
  .fenlei .img{display: flex;flex-direction: row;justify-content: center;align-content: center;}
  .fenlei .img image{	width: 100upx;	height: 100upx;}	
  .fenlei text{text-align: center;}
</style>