<template>
	<div class="z_img tu" style="width: 100%;float: left;overflow: hidden;overflow-x: auto;margin-top: 0.2rem;width: 99.2%;box-sizing: border-box;">
		<div style="width: 10000px;">
			<div class="hezi" :style="'width:'+ list.hezikuan +'px;'">
				<div class="kuandu" :style="'width:'+ list.kuandu +'px;'"    v-for="(item,index) in list.shangpin">
					<a :href="'#/shangpin_xiangqing?id='+item.id">
						<img :height="list.gaodu" :src="item.tu"  style="width: 100%;">
						<div><p>{{item.ming}}</p><span>￥{{item.jiage}}</span><span style="float: right;color: #ccc;text-decoration: line-through;">￥{{item.yuanjia}}</span></div>
					</a>
				</div>
			</div>
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
	
	
	
	
	
</style>