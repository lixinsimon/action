<template>
  <div class="mpvue-picker">
    <div :class="{'pickerMask':showPicker}" @click="QuXiao" catchtouchmove="true"></div>
    <div class="mpvue-picker-content " :class="{'mpvue-picker-view-show':showPicker}">
      <div class="mpvue-picker__hd" catchtouchmove="true">
        <div class="mpvue-picker__action" @click="QuXiao">取消</div>
        <div class="mpvue-picker__action" @click="QueRen">确定</div>
      </div>
      <!-- 单列 -->
      <picker-view indicator-style="height: 40px;" class="mpvue-picker-view" :value="pickerValue2" @change="pickerChangeMul" v-if="JiLianDong===1">
        <block>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulOneOne" :key="index">{{item.ming}}</div>
          </picker-view-column>
        </block>
      </picker-view>   
      <!-- 二级联动 -->
      <picker-view indicator-style="height: 40px;" class="mpvue-picker-view" :value="pickerValue" @change="pickerChangeMul" v-if="JiLianDong===2">
        <block>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulTwoOne" :key="index">{{item.ming}}</div>
          </picker-view-column>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulTwoTwo" :key="index">{{item.ming}}</div>
          </picker-view-column>
        </block>
      </picker-view>
      <!-- 三级联动 -->
      <picker-view indicator-style="height: 40px;" class="mpvue-picker-view" :value="pickerValue1" @change="pickerChangeMul" v-if="JiLianDong===3">
        <block>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulThreeOne" :key="index">{{item.ming}}</div>
          </picker-view-column>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulThreeTwo" :key="index">{{item.ming}}</div>
          </picker-view-column>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulThreeThree" :key="index">{{item.ming}}</div>
          </picker-view-column>
        </block>
      </picker-view>
    </div>
  </div>
</template>


<script>	
import $z from '@/zhiwi'
	export default {
		data(){
			return {
				shu:{},
				pickerValue:[0,0,0],		
				showPicker:0,
				JiLianDong:2,		
				pickerValueMulOneOne:[],
				pickerValueMulTwoOne:[],
				pickerValueMulTwoTwo:[],
				pickerValueMulThreeOne:[],
				pickerValueMulThreeTwo:[],
				pickerValueMulThreeThree:[]			
			};						
		},
		props: ['JiLianDong','ChuShiHua','ShuJu'],
		created:function(){
			  var that=this;
				var ting=setInterval(function(){
					if(that.ShuJu){					
						if(that.JiLianDong==2){
						that.pickerValueMulTwoOne=that.ShuJu;							
						that.pickerValueMulTwoTwo=that.ShuJu[0]['haizi'];						
						}else if(that.JiLianDong==3){
						that.pickerValueMulThreeOne=that.ShuJu;
						that.pickerValueMulThreeTwo=that.ShuJu[0]['haizi'];
						that.pickerValueMulThreeThree=that.pickerValueMulThreeTwo[0]['haizi'];
						}else{
						that.pickerValueMulOneOne=that.ShuJu;
						} 						
					}		 		
				},500);
			
			
		},
		methods:{
			pickerChangeMul:function(e){		
				this.pickerValue=e.detail.value;			
			  var yi=this.ShuJu[this.pickerValue[0]];					
				if(this.JiLianDong==2){				
					for(var i in yi['haizi']){
						this.$set(this.pickerValueMulTwoTwo,i,yi['haizi'][i]);
					}				
				}else if(this.JiLianDong==3){			
					for(var i in yi['haizi']){
						this.$set(this.pickerValueMulThreeTwo,i,yi['haizi'][i]);
					}	
					var  ThreeThree=this.pickerValueMulThreeTwo[this.pickerValue[1]]['haizi'];		
					for(var i in ThreeThree){
						this.$set(this.pickerValueMulThreeThree,i,ThreeThree[i]);
					}					
				}
			
			},
			QuXiao:function(){
				this.showPicker=0;				 
				this.$emit('QuXiao', this.shu);				
			},
			QueRen:function(){	
				var yi=this.ShuJu[this.pickerValue[0]];					
				this.shu['zhi']=yi.ming;
				this.shu['id']=yi.id;
				this.shu['k']=this.pickerValue[0];		
				if(this.JiLianDong==2){					
					this.shu['zhi']+=' '+this.pickerValueMulTwoTwo[this.pickerValue[1]].ming;				
					this.shu['id']+=','+this.pickerValueMulTwoTwo[this.pickerValue[1]].id;	
					this.shu['k']+=','+this.pickerValue[1];
				}else if(this.JiLianDong==3){							 
					this.shu['zhi']+=' '+this.pickerValueMulThreeTwo[this.pickerValue[1]].ming;
					this.shu['zhi']+=' '+this.pickerValueMulThreeThree[this.pickerValue[2]].ming;					
					this.shu['id']+=','+this.pickerValueMulThreeTwo[this.pickerValue[1]].id;
					this.shu['id']+=','+this.pickerValueMulThreeThree[this.pickerValue[2]].id;
					this.shu['k']+=','+this.pickerValue[1]+','+this.pickerValue[2];		
				}			
				this.showPicker=0;
				this.$emit('QueRen', this.shu);			
			},		
			DaKai:function(){				
				this.showPicker=1; 
			}
		}
	}
</script>

<style>
.pickerMask {
  position: fixed;
  z-index: 1000;
  top: 0;
  right: 0;
  left: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
}
.mpvue-picker-content {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  transition: all 0.3s ease;
  transform: translateY(100%);
  z-index: 3000;
}
.mpvue-picker-view-show {
  transform: translateY(0);
}
.mpvue-picker__hd {
  display: flex;
  padding: 20upx 28upx;
  background-color: #fff;
  position: relative;
  text-align: center;
  font-size: 40upx;
}
.mpvue-picker__hd:after {
  content: ' ';
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  height: 1px;
  border-bottom: 1px solid #e5e5e5;
  color: #e5e5e5;
  transform-origin: 0 100%;
  transform: scaleY(0.5);
}
.mpvue-picker__action {
  display: block;
  flex: 1;
  color: #1aad19;
}
.mpvue-picker__action:first-child {
  text-align: left;
  color: #888;
}
.mpvue-picker__action:last-child {
  text-align: right;
}
.picker-item {
  text-align: center;
  line-height: 40px;
  font-size: 28upx;
}
.mpvue-picker-view {
  position: relative;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 500px;
  background-color: rgba(255, 255, 255, 1);
}
</style>
