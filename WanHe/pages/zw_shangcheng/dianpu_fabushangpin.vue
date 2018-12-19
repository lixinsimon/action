<template>
	<view>
		<form @submit="baocun">
		<view class="shangchuantupian">
			<view class="tianjia" v-for="l in tu" :style="'background-image: url('+l+')'" @click="shangtu(index)">
				<view class="tianjia_wenzi" v-if="!l">
					 <text style="font-size: 50upx;">+</text>
					 <text v-if="index">细节</text>	
					 <text v-else>主图</text>	
				</view>	 			
			</view>	
		</view>
		
		<view class="biaoti_shurukuang">
			<lable class="shurukuang1_text">标题</lable>
			<input class="input1" type="text" name='ming' placeholder="请填写商品标题"/>
		</view>
		<view class="fengexian"><view></view></view>
		
		<view class="shurukuang1">
			<lable class="shurukuang1_text">价格</lable>
			<input class="input1" type="digit" name="jiage" placeholder="请输入现价"/>
		</view>
		
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">原价</lable>
			<input class="input1" type="digit" name='yuanjia' placeholder="请输入原价"/>
		</view>
				
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">库存</lable>
			<input class="input1" type="number" name="kucun" placeholder="请输入多少件"/>
		</view>
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">重量</lable>
			<input class="input1" type="number" name="zhongliang" placeholder="请输入单件重量kg"/>
		</view>
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">单位</lable>
			<input class="input1" type="text" name="danwei" value="个" placeholder="请输入单位"/>
		</view>
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">和券</lable>
			<input class="input1" type="number" name="hequan" placeholder="请输入送和券数量"/>
		</view>
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1"  @click="FenLei">
			<lable class="shurukuang1_text">分类</lable>
			<input class="input1"  disabled :value="fenlei" name='fenlei' placeholder="请选择" placeholder-style="text-align: right;"/>
			<icon class="iconfont icon-arrow-right-copy-copy" style="font-size: 40upx;color: #DCDCDC;margin-top: -10upx;"></icon>
		</view>
		<view class="fengexian"><view></view></view>
		<navigator class="shurukuang1" :url="'dianpu_xiangqingxinxi?shu='+xiangqing">
			<lable class="shurukuang1_text">详情</lable>
			<input class="input1"  disabled  placeholder="填写" name='neirong' placeholder-style="text-align: right;"/>
			<icon class="iconfont icon-arrow-right-copy-copy" style="font-size: 40upx;color: #DCDCDC;margin-top: -10upx;"></icon>
		</navigator>
		<view class="fengexian"><view></view></view>
		<navigator class="shurukuang1" :url="'dianpu_shuxing?shu='+shuxing">
			<lable class="shurukuang1_text">属性</lable>
			<input class="input1"  disabled  placeholder="填写" name='shuxing' placeholder-style="text-align: right;"/>
			<icon class="iconfont icon-arrow-right-copy-copy" style="font-size: 40upx;color: #DCDCDC;margin-top: -10upx;"></icon>
		</navigator>
		<view class="fengexian"><view></view></view>
		
		<view class="shurukuang1">
			<lable class="shurukuang1_text" style="width: 20%;">专区</lable>
			<view class="input1" style="width: 80%;">
				<radio-group class="checkbox-group"  @change="ZhuanQu">
					<label class="checkbox">				
						<radio value="0" color='#000' />普通区
					</label>
					<label class="checkbox" >				
						<radio value="1" color='#000'/>和券区
					</label>
				</radio-group>
			</view>	
		</view>
		<button class="baocun" formType="submit"><text>保存</text></button>
		<LianDong ref="FenLeiLie" :JiLianDong='JiLianDong' :ChuShiHua='ChuShiHua' :ShuJu="ShuJu" @QueRen='QueRen'></LianDong>
	
		</form>
	</view>
</template>

<script> 
	import $z from '@/zhiwi';
	import LianDong from "@/zujian/LianDong.vue"
	export default {
		data:{
			xiangqing:'',
			shuxing:'',
			shu:[],
			fenlei:'',
			tu:['','','',''],
			ChuShiHua:[0,0],
			JiLianDong:2,
			ShuJu:[]
		},
		
		components:{LianDong}, 
		onShow:function() {
			this.CSH();
		},
		
		methods:{		
			CSH:function(){
				var _this = this;			
				$z.post('m=zw_shangcheng&k=liebiao&x=fenlei',function(s){			
						if(s.shi==1){				 
								_this.ShuJu=s.shu;
						}		 			
				})
			},
			FenLei:function(){
				 this.$refs.FenLeiLie.DaKai();	
			},
			QueRen:function(e){	
				  this.shu['fenlei']=e.id
				  this.fenlei=e.zhi					
			}, 	
			shangtu:function(e){
			  	var that=this;
				  $z.ShangTu(function(s){
					  	that.$set(that.tu,e,s.url);						
					},1)
			},		
			ZhuanQu:function(e){
				 this.shu['zhuanqu']=e.detail.value;
			},
			baocun:function(e){
				var that = this;		
				var shu=e.detail.value;
				shu['xiangqing']=$z.Qu('xiangqing');
				shu['shuxing']=$z.Qu('shuxing');
				shu['fenlei']=that.shu['fenlei'];			
				shu['zhuanqu']=that.shu['zhuanqu'];
				shu['tu']=that.tu;
				shu['xiangqing']=that.xiangqing;
				shu['shuxing']=that.shuxing;				
			  $z.post('m=zw_shangcheng&k=dianpu&x=fabushangpin',{shu:JSON.stringify(shu)},function(shu){	
						if(shu.shi==1){
							$z.toast('发布成功，等待后台审核');								
							$z.Shan('xiangqing');
							$z.Shan('shuxing');							
							setTimeout(function(){
								uni.navigateTo({
									url: 'dianpu_shangpin',							 
								});
							},500);
						}else{
							$z.toast(shu.shu);	
						}
					})
			},

		},
	}
</script>

<style>
	page{width: 100vw;margin: 0;padding: 0;display: flex;flex-direction: column;}
	
	.fengexian{width: 100vw;background: white;padding: 0 30upx;box-sizing: border-box;}
	.fengexian>view{width: 100%;height: 0;border-top:1upx solid #DCDCDC;}
	 
	.shangchuantupian{width: 100vw;padding: 52upx 30upx;box-sizing: border-box;display: flex;justify-content: space-between;align-items: center;color: #DCDCDC;}
	.tianjia{width: 150upx;height: 150upx;border: 2upx dashed #DCDCDC;display: flex;box-sizing: border-box;
					align-items: center;justify-content: center;position: relative;background-repeat: no-repeat; background-position: center;background-size: cover;}
	.tianjia_wenzi{display: flex;flex-direction:column;font-size: 24upx;justify-content: center;align-items: center;}
	.tupian{z-index:10;width: 152upx;height: 152upx;display: flex;align-items: center;position: absolute;top: -1;left: -1;background: white;}
	.tupian>image{width: 100%;height: 100%;}
	.guan{position: absolute;top: -10upx;right: -10upx;}
	 
	.biaoti_shurukuang{width: 100vw;padding:0 30upx 80upx 30upx;display: flex;background: white;align-items: center;box-sizing: border-box;}
	.shurukuang1_text{width: 15%;font-size: 30upx;color: #333333;}
	.input1{width: 85%;}
	.shurukuang1{width: 100vw;padding: 30upx;display: flex;background: white;align-items: center;box-sizing: border-box;}
	

	
	 
	.baocun{width: 90%;background:#1c2536;display: flex;justify-content: center;align-items: center;color: white;
						border-radius: 10upx;margin: 10upx auto;font-size:40upx;}


	.anniu{z-index: 100;width: 100%;display: flex;justify-content: space-between;padding: 20upx;box-sizing: border-box;position: absolute;top: 0;left: 0;}
	.anniu>view{}
	
	
	
</style>








































<!-- <template>
	<view :style="'overflow-y:'+hua+';'+ 'height:'+gao+';'">
		<view class="shangchuantupian">
			<view class="tupian" v-for="tu in tupian">
				<image :src="tu" mode="widthFix"></image>
			</view>
			<view class="tianjia" @click="xuanzezhaopian"><text>+</text></view>
		</view>
		
		
		<view class="shurukuang1" style="height: 150upx;">
			<lable class="shurukuang1_text">标题</lable>
			<input class="input1" type="text" v-model:value="biaoti" placeholder="请填写商品标题"/>
		</view>
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">价格</lable>
			<input class="input1" type="number" v-model:value="jiage" placeholder="价格"/>
		</view>
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">原价</lable>
			<input class="input1" type="number" v-model:value="yuanjia" placeholder="原价"/>
		</view>
		<view class="fengexian"><view></view></view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">重量</lable>
			<input class="input1" type="number" v-model:value="zhongliang" placeholder="重量"/>
		</view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">单位</lable>
			<input class="input1" type="number" v-model:value="danwei" placeholder="单位"/>
		</view>
		<view class="shurukuang1">
			<lable class="shurukuang1_text">库存</lable>
			<input class="input1" type="number" v-model:value="kucun" placeholder="库存"/>
		</view>
		
		<view class="shurukuang1" @click="chufa(true)">
			<lable class="shurukuang1_text">分类</lable>
			<input class="input2" type="number" disabled :value="fenlei[0].ming" />
			<input class="input2" type="number" disabled :value="fenlei[1].ming" />
		</view>
		
		<view class="shurukuang1">
			<lable class="shurukuang1_text">标签</lable>
			<view class="input1">
				<checkbox-group class="checkbox-group" @change="checkboxChange">
					<label class="checkbox">
						<checkbox value="xinpin"/>新品
					</label>
					<label class="checkbox">
						<checkbox value="miaosha"/>秒杀
					</label>
					<label class="checkbox">
						<checkbox value="baoyou"/>包邮
					</label>
					<label class="checkbox">
						<checkbox value="remai"/>热卖
					</label>
					
				</checkbox-group>
			</view>
		</view>
		
		<view class="shurukuang1">
			<lable class="shurukuang1_text">详情</lable>
			<input class="input2" type="number" v-model:value="xiangqing" disabled placeholder="详情" @click="xiangqingtan(!xiangqingflag)"/>
			<view class="youjiantou">
				<icon class="iconfont icon-jiantouyou" @click="xiangqingtan(!xiangqingflag)"></icon>
			</view>
		</view>
		
		
		<view class="tianjiashuxing" @click="tianjiashuxing"><text>添加属性</text></view>
		
		<view class="shuxing" v-for="(item,i) in shuxing">
			<input type="text"  v-model:value="item.key" placeholder="属性名"/>
			<view>-</view>
			<input type="text" v-model:value="item.value"  placeholder="属性值"/>
			<icon @click="shanchushuxing(i)" class="iconfont icon-close"></icon>
		</view>
		
		<view class="baocun" @click="baocun"><text>保存</text></view>
		
		<view class="xiangqingbg" v-if="xiangqingflag">
			<view class="xiangqing">
				<textarea class="xiangqinginput" v-model:value="xiangqing" placeholder="请输入商品详情" maxlength="-1"/>
				<view class="xiangqingbotton">
					<view class="xiangqinganniu" @click="qingkong">清空</view>
					<view class="xiangqinganniu" @click="xiangqingtan(!xiangqingflag)">保存</view>
				</view>
			</view>
		</view>
		
		<view class="xiangqingbg" v-if="flag1">
			<view class="mpvue-picker">
				<view :class="{'pickerMask':showPicker}" @click="QuXiao" catchtouchmove="true"></view>
				<view class="mpvue-picker-content " :class="{'mpvue-picker-view-show':showPicker}">
					<picker-view indicator-style="height: 40px;" class="mpvue-picker-view"  @change="pickerChangeMul" v-if="flag1">
						<view class="anniu">
							<view @click="chufa(false)">取消</view>
							<view @click="queren">确认</view>
						</view>
						<block>
							<picker-view-column >
								<view class="picker-item" v-for="(item,index) in pickerValueMulTwoOne" :key="index">{{item.ming}}</view>
							</picker-view-column>
							<picker-view-column>
								<view class="picker-item" v-for="(item,index) in pickerValueMulTwoTwo" :key="index">{{item.ming}}</view>
							</picker-view-column>
						</block>
					</picker-view>
				</view>
			</view>
		</view>
		</view>
	</view>
</template>

<script> 
	import $z from '@/zhiwi';
	export default {
		data:{
			biaoti:'',
			jiage:'',
			yuanjia:'',
			zhongliang:'',
			danwei:'',
			kucun:'',
			biaoqian:[],
			tupian:[],
			shuxing:[],
			xiangqing:'',
			fenlei:[{'ming':'','id':''},{'ming':'','id':''}],
			
			hua:'scroll',
			gao:'auto',
			pickerValue:[],
			pickerValueMulTwoOne:[],
			pickerValueMulTwoTwo:[],
			
			flag1:false,
			xiangqingflag:false,
		},
		
		onShow:function() {
			this.CSH();
		},
		
		methods:{
			pickerChangeMul:function(e){	
				this.pickerValue=e.detail.value;					
				this.pickerValueMulTwoTwo = this.pickerValueMulTwoOne[this.pickerValue[0]].haizi;
			},
			
			CSH:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=liebiao&x=fenlei',function(s){
					if(s.shi==1){
						_this.pickerValueMulTwoOne=s.shu;
						_this.pickerValueMulTwoTwo = _this.pickerValueMulTwoOne[0].haizi;
						_this.pickerValue=[0,0];

					}
					
				})
			},
			 
			queren:function(){
				this.fenlei[0].ming=this.pickerValueMulTwoOne[this.pickerValue[0]].ming;
				this.fenlei[1].ming=this.pickerValueMulTwoTwo[this.pickerValue[1]].ming;
				this.fenlei[0].id=this.pickerValueMulTwoTwo[this.pickerValue[1]].fuji_id;
				this.fenlei[1].id=this.pickerValueMulTwoTwo[this.pickerValue[1]].id;
				this.flag1=false;
				this.hua='scroll';
				this.gao="auto";
			},    
			
			checkboxChange:function(e){
				this.biaoqian=e.detail.value;
			},
			chufa:function(e){
				this.flag1=e;
				if(e){
					this.hua='hidden';
					this.gao="100vh";
				}else{
					this.hua='scroll';
					this.gao="auto";
				}
			},
			xiangqingtan:function(e){
				this.xiangqingflag=e;
			},
			qingkong:function(){
				this.xiangqing='';
			},
			
			xuanzezhaopian:function(){	
				var _this = this;
				$z.ShangTu(function(e){
					 var temp =  JSON.parse(e.data);
					 _this.tupian.push(temp.url);
				},6);				
			},
			tianjiashuxing:function(){
				this.shuxing.push({'key':'','value':''});
			},
			shanchushuxing:function(e){
				this.shuxing.splice(e,1);
			},
			
			arrayTostring:function(e){
				var temp = [];
				for (var item in e) {	
						temp.push(JSON.stringify(e[item]));
				}
				console.log(temp.toString())
				return temp.toString();
			},
			
			baocun:function(){
				var _this = this;				 
					$z.post('m=zw_shangcheng&k=dianpu&x=fabushangpin',{
							ming:_this.biaoti,
							jiage:_this.jiage,
							yuanjia:_this.yuanjia,
							zhongliang:_this.zhongliang,
							danwei:_this.danwei,
							kucun:_this.kucun,
							shuxing:JSON.stringify(_this.shuxing),
							biaoqian:_this.biaoqian,
							tu:_this.tupian,
							xiangqing:_this.xiangqing,
							fenlei_yiji:_this.fenlei[0].id,
							fenlei_erji:_this.fenlei[1].id,
							},function(shu){	
								
					
						if(shu.shi==1){
							$z.toast('发布成功，等待后台审核');	
              setTimeout(function(){
								uni.navigateTo({
									url: 'dianpu_shangpin',							 
								});
							},500)
							 
						}else{
							$z.toast(shu.shu);	

						}
					})
	
			},
			
		},
	}
</script>

<style>
	page{width: 100vw;margin: 0;padding: 0;background: #EEEEEE;display: flex;flex-direction: column;}
	
	.fengexian{width: 100vw;background: white;padding: 0 20upx;box-sizing: border-box;}
	.fengexian>view{width: 100%;height: 0;border-top:1upx solid #DCDCDC;}
	.shurukuang1{width: 100vw;padding: 20upx;display: flex;background: white;align-items: center;/* margin-top: 2upx; */box-sizing: border-box;}
	.shurukuang1_text{width: 20%;}
	.input1{width: 80%;}
	.input2{width: 75%;}
	.youjiantou{width: 5%;display: flex;align-items: center;}
	.icon-jiantouyou{font-size: 44upx;}
	
	.checkbox-group{width: 100%; display: flex;justify-content: space-between;}
	
	.shangchuantupian{width: 100vw;padding: 20upx;display: flex;flex-wrap: wrap;background: white;margin-top: 2upx;box-sizing: border-box;}
	.tupian{width: 17vw;height: 17vw;padding: 5upx;display: flex;justify-content: center;align-items: center;overflow: hidden;}
	.tupian>image{width: 100%;}
	.tianjia{width: 18vw;height: 18vw;background:#EEEEEE;display: flex;justify-content: center;align-items: center;font-size: 50upx;}
	
	.tianjiashuxing{width: 90%;padding: 20upx;background: red;display: flex;justify-content: center;align-items: center;color: white;margin: 10upx auto;}
	.shuxing{width: 100vw;padding: 20upx;box-sizing: border-box;display: flex;justify-content: space-between;
						align-items: center;background: white;margin-top: 5upx;}
	.shuxing>input{width: 45%;margin-left: 10upx;}
	.shuxing>icon{flex-grow: 1;font-size: 40upx;}
	.baocun{width: 90%;padding: 20upx;background: red;display: flex;justify-content: center;align-items: center;color: white;margin: 10upx auto;}
	
	.xiangqingbg{z-index: 10;background: rgba(0,0,0,0.5);width: 100vw;height: 100vh;position: fixed;left: 0;bottom: 0;}
	.xiangqing{width: 90%;margin: 200upx auto;background: white;padding: 20upx;border-radius: 10upx;}
	.xiangqinginput{height: 600upx;margin: 0 auto;width: 100%;}
	.xiangqingbotton{width: 100%;display: flex;justify-content: space-between;}
	
	.mpvue-picker-view {
	  position: fixed;
	  bottom: 0;
	  left: 0;
	  width: 100%;
	  height: 500px;
	  background-color: rgba(255, 255, 255, 1);
	}
	.picker-item {
	  text-align: center;
	  line-height: 40px;
	  font-size: 28upx;
	}
	
	
	
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
	
	
	.anniu{z-index: 100;width: 100%;display: flex;justify-content: space-between;padding: 20upx;box-sizing: border-box;position: absolute;top: 0;left: 0;}
	.anniu>view{}
</style>
 -->