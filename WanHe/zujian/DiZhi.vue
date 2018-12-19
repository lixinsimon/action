<template>
  <div class="mpvue-picker">
    <div :class="{'pickerMask':showPicker}" @click="QuXiao" catchtouchmove="true"></div>
    <div class="mpvue-picker-content " :class="{'mpvue-picker-view-show':showPicker}">
      <div class="mpvue-picker__hd" catchtouchmove="true">
        <div class="mpvue-picker__action" @click="QuXiao">取消</div>
        <div class="mpvue-picker__action" @click="QueRen">确定</div>
      </div>
      <!-- 单列 -->
      <picker-view indicator-style="height: 40px;" class="mpvue-picker-view" :value="pickerValue" @change="pickerChangeMul" v-if="JiLianDong===1">
        <block>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulOneOne" :key="index">{{item.label}}</div>
          </picker-view-column>
        </block>
      </picker-view>   
      <!-- 二级联动 -->
      <picker-view indicator-style="height: 40px;" class="mpvue-picker-view" :value="pickerValue" @change="pickerChangeMul" v-if="JiLianDong===2">
        <block>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulTwoOne" :key="index">{{item.label}}</div>
          </picker-view-column>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulTwoTwo" :key="index">{{item.label}}</div>
          </picker-view-column>
        </block>
      </picker-view>
      <!-- 三级联动 -->
      <picker-view indicator-style="height: 40px;" class="mpvue-picker-view" :value="pickerValue" @change="pickerChangeMul" v-if="JiLianDong===3">
        <block>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulThreeOne" :key="index">{{item.label}}</div>
          </picker-view-column>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulThreeTwo" :key="index">{{item.label}}</div>
          </picker-view-column>
          <picker-view-column>
            <div class="picker-item" v-for="(item,index) in pickerValueMulThreeThree" :key="index">{{item.label}}</div>
          </picker-view-column>
        </block>
      </picker-view>
    </div>
  </div>
</template>


<script>	
	import dizhiku from '@/zhiwi/mayuan.city.js'
	export default {
		data(){
			return {
				shu:{},
				pickerValue:[],		
				showPicker:0,
				JiLianDong:1,		
				pickerValueMulOneOne:[],
				pickerValueMulTwoOne:[],
				pickerValueMulTwoTwo:[],
				pickerValueMulThreeOne:[],
				pickerValueMulThreeTwo:[],
				pickerValueMulThreeThree:[],
				ChuShiHua:[0,0,0]
			};						
		},
		props: ['JiLianDong','ChuShiHua'],
		created:function(){
			  var that=this;
			  setTimeout(function(){
				 if(that.JiLianDong==2){
				 	that.pickerValueMulTwoOne=dizhiku;
				 	that.pickerValueMulTwoTwo=dizhiku[0]['children'];						
				 }else if(that.JiLianDong==3){
				 	that.pickerValueMulThreeOne=dizhiku;
				 	that.pickerValueMulThreeTwo=dizhiku[0]['children'];
				 	that.pickerValueMulThreeThree=that.pickerValueMulThreeTwo[0]['children'];
				 }else{
				 	that.pickerValueMulOneOne=dizhiku;
				 } 
				 that.pickerValue=that.ChuShiHua;				
			  },10);
			 
		},
		methods:{
			pickerChangeMul:function(e){					
				this.pickerValue=e.detail.value;					
				var yi=dizhiku[this.pickerValue[0]];							
				this.shu['zhi']=yi.label;
				this.shu['id']=yi.value;
				this.shu['k']=this.pickerValue[0]+','+this.pickerValue[1]+','+this.pickerValue[2];
				if(this.JiLianDong==2){
					this.pickerValueMulTwoTwo=yi['children'];
					this.shu['zhi']+=' '+this.pickerValueMulTwoTwo[this.pickerValue[1]].label;				
					this.shu['id']+=','+this.pickerValueMulTwoTwo[this.pickerValue[1]].value;						
				}else if(this.JiLianDong==3){
					this.pickerValueMulThreeTwo=yi['children'];					
					this.pickerValueMulThreeThree=this.pickerValueMulThreeTwo[this.pickerValue[1]]['children'];
					 
					this.shu['zhi']+=' '+this.pickerValueMulThreeTwo[this.pickerValue[1]].label;
					this.shu['zhi']+=' '+this.pickerValueMulThreeThree[this.pickerValue[2]].label;	
					
					this.shu['id']+=','+this.pickerValueMulThreeTwo[this.pickerValue[1]].value;
					this.shu['id']+=','+this.pickerValueMulThreeThree[this.pickerValue[2]].value;		
				}		
			},
			QuXiao:function(){
				this.showPicker=0;				 
				this.$emit('QuXiao', this.shu);				
			},
			QueRen:function(){
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
