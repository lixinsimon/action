<template>
	<view>
		<view class="kuang">
			<lable class="tou">真实姓名</lable>
			<input class="shuru" type="text" v-model:value="shu.xingming" placeholder="请输入真实姓名"/>
		</view>
		<view class="kuang">
			<lable class="tou">身份证号</lable>
			<input class="shuru" type="number" v-model:value="shu.shenfenzhenghao" placeholder="请输入身份证号"/>
		</view>
		<view class="button" @click="tijiao">立即认证</view>
		<view class="shengming">声明：实名认证需要1到3个工作日完成审核。</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		
		data:{
			shu:{'xingming':'','shenfenzhenghao':''},
		},
		methods:{
			tijiao:function(){
				var _this = this;
				$z.post('m=zw_shangcheng&k=wode&x=shimingrenzheng',{c:'renzheng',xingming:_this.shu.xingming,shenfenzheng:_this.shu.shenfenzhenghao},function(shu){
					if(shu.shi == 1){
						$z.toast('提交成功');
						setTimeout(function(){
							$z.go();
						},500)					
					}else{
						$z.toast(shu.shu);
						
					}
				});
			}
		}
	}
</script>

<style>
	.kuang{width: 100vw;padding: 20upx;box-sizing: border-box;border-bottom: 1upx solid #000000;display: flex;}
	.tou{width: 25%;line-height: 60upx;}
	.shuru{width: 75%;height: 60upx;}
	.button{width: 70vw;margin:10vw  auto; text-align: center;background: #000000;color: white;padding: 20upx;}
	.shengming{width: 100vw;text-align: center;	color: #999999;font-size: 24upx;}
</style>
