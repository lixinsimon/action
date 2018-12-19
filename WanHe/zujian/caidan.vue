<template>
	<div id="caidan" class="zw-fenlei5" >
		<div v-for="(item,index) in list.fenlei" style="width: 32%;background-color: rgb(255, 255, 255);position: relative;font-size: 14px;font-weight: 600;margin-right: 2%;" class="zw-fenlei-k" > 
			<a :href="item.url" >
				<div class="zw-fenlei-zi zw-shenglue">{{item.ming}}</div>
				<div class="candan_i">
					<img class="caidan_img"  :src="item.tu" />
				</div> 
			</a>
		</div>	
	</div>
</template>

<script>
	export default {
	  name: 'fenlei',
	  data () {
	    return {
	      
	    }
	  },
	   props: ['list'],
	}
</script>

<style>
#caidan div:last-child{
    margin-right:0 !important;
}
</style>