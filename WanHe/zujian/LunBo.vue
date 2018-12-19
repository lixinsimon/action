<template>
  <view>
    <swiper indicator-dots="true" autoplay="true"  indicator-active-color='#FFF' indicator-color='#B7D0E1' circular="true" class="lun_bo">
					<swiper-item  v-for="l in shu.lunbo" wx:key="*this">
							<navigator :url="l.url"><image :src="l.tu" class="lunbo_img"></image></navigator>
					</swiper-item>
      </swiper>	
  </view>
</template>

<script>	
export default {
   props: ['shu'],
}
</script>
<style>
	swiper{height: 400upx;}
	image{width: 750upx;height: 400upx;}
</style>



