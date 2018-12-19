<template>
	<div>
		<div class="tui_shang" v-for="(shangpin,index) in list">
			<div class="shang_tou">
				<img :src="shangpin.tu" />
			</div>
			<div class="dangqian">
				<p class="p1">参与价:￥{{shangpin.jiage}}</p>
				<p class="p2">￥<span>{{shangpin.yuanjia}}</span></p>
			</div> 
			<div class="shang_ming">{{shangpin.ming}}</div>
			<div class="canyu">
				<p>{{shangpin.taobaoid}}</p>
				<button @click="tiaozhuan(shangpin.id)" v-if="shangpin.yijieshu">参与砍价</button>
				<button disabled="disabled" style="background: #c3c3c3;" v-else>已结束</button>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
	  name: 'kanjia_shangpin',
	  data () {
	    return {
	      
	    }
	  },
	   props: ['list'],
	    mounted:function(){
	    	var that = this;
	   		for(let i=0,l=that.list.length;i<l;i++){
	   			that.list[i].taobaoid = getNewSyTime(that.list[i].jieshushijian);
	   		}    
	   		setInterval(function(){
	   			for(let i=0,l=that.list.length;i<l;i++){
		   			that.list[i].taobaoid = getNewSyTime(that.list[i].jieshushijian);
		   		}  
	   		},1000) 
	   },
	}
	
	function getNewSyTime(sec) {
		var nowTime = new Date();
        var endTime = new Date(sec * 1000);
        var t = endTime.getTime() - nowTime.getTime();
        var sec=Math.floor(t/1000%60);
        var d=Math.floor(t/1000/60/60/24);
        var hour= d *24 + Math.floor(t/1000/60/60%24);
        var min=Math.floor(t/1000/60%60);
        var sec=Math.floor(t/1000%60);
        if(t<0){
        	if(jieshu == 1){
        		V.shuju[i].yijieshu = false;
        	}else if(jieshu == 2){
        		V.jinxing[i].yijieshu = false;
        	}else if(jieshu == 3){
        		V.kaishi[i].yijieshu = false;
        	}else{
        		V.quanbu[i].yijieshu = false;
        	}
        	return '已结束';            	
        }
//          if(d<10){
//          	d='0'+d;
//          }
         if(hour<10){
        	hour='0'+hour;
        }
         if(min<10){
        	min='0'+min;
        }
        if(sec<10){
        	return hour+':'+min+':'+'0'+sec;
        }else{
        	return hour+':'+min+':'+sec;
        }
  }
</script>

<style>
</style>