<template>
<div class="z_img tu" style="width: 100%;float: left;margin-top: 0.2rem;width: 99.5%;box-sizing: border-box;background: #fff;border-radius: 2px;">
	<div style="width: 100%;height: 50px;line-height: 50px;">
		<i class="icon-clock" style="color: #ff6600;margin-right: 5px;font-size: 15px;margin-left: 5px;"></i><span style="color: #ff6600;font-size: 16px;font-weight: bold;">抢购</span>
		<p class="qianggou_p">
			<span>01</span>天<span>20</span>时<span>56</span>分<span>01</span>秒			
		</p>
		<input type="hidden" id="jieshushijian"  :value="list.jieshushijian.jieshushijian" />
	</div>
	<div style="width: 100%;overflow: hidden;overflow-x: auto;" class="nai_zi">
		<div style="width: 10000px;">
			<div class="hezi" :style="'width:'+ list.hezikuan +'px;'">
				<div class="kuandu" :style="'width:'+ list.kuandu +'px;'"    v-for="(item,index) in list.shangpin">
					<a class="qianggou_lianjie">
						<img :height="list.gaodu" :src="item.tu"  style="width: 100%;">
						<div style="float: left;width: 100%;text-align: center;background: #66cc00;margin-top: 10px;">
							<p style="color: #fff;">{{item.ming}}</p>
							<span style="color: #fff;">￥<font style="font-size: 16px;font-weight: bold;">{{item.jiage}}</font></span><br />
							<span style="text-decoration: line-through;color: #ccff99;">原价:￥{{item.yuanjia}}</span>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

</template>

<script>
	var time = null; 
	export default {
	  name: 'miaosha',
	  data () {
	    return {
	      
	    }
	  },
	   props: ['list'],
	   mounted:function(){
	   	    var that = this;
	   	    var a = document.getElementsByClassName('qianggou_p');
	   		getNewSyTime(that.list.jieshushijian.jieshushijian,a[0].childNodes);
	   		time = setInterval(function(){
	   			if(that.$route.name=='index'){
   					getNewSyTime(that.list.jieshushijian.jieshushijian,a[0].childNodes);
	   			}else{
	   				clearInterval(time);
	   			}
	   		},1000)
	   }
	}
	
	function getNewSyTime(sec,a) {
		var nowTime = new Date();
        var endTime = new Date(sec * 1000);
        var t = endTime.getTime() - nowTime.getTime();
        var sec=Math.floor(t/1000%60);
        var d=Math.floor(t/1000/60/60/24);
        var hour=Math.floor(t/1000/60/60%24);
        var min=Math.floor(t/1000/60%60);
//      var sec=Math.floor(t/1000%60);
        if(t<0){
        	a.innerHTML = '已结束';
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
        	sec='0'+sec;
        }
//        console.log(d+' '+hour+' '+min+' '+sec);
          a[0].innerHTML = d;
          a[2].innerHTML = hour;
          a[4].innerHTML = min;
          a[6].innerHTML = sec;
//  	$('.qianggou_p span').eq(0).html(d);
//  	$('.qianggou_p span').eq(1).html(hour);
//  	$('.qianggou_p span').eq(2).html(min);
//  	$('.qianggou_p span').eq(3).html(sec);
      }
	

	
</script>

<style>
</style>