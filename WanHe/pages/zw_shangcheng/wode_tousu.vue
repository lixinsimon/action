<template>
	<view>
		<view class="tousujianyi">
			<textarea bindblur="bindTextAreaBlur" auto-height placeholder="在此写下您的留言,我们会竭诚为您服务!" v-model="text"/>
			<view class="zhaopian">
				<view class="tupian"  v-for="(tu,i) in tupian">
					<image :src="tu" mode="widthFix"></image>
				</view>
				<view class="tianjiakuang"  @click="xuanzezhaopian">+</view>
				<!-- <view class="shuoming">添加照片(最多6张)</view> -->
			</view>
			<view class="button" type="submit" @click="tijiao">提交</view>
		</view>
	</view>
</template>

<script>
import $z from '@/zhiwi';
export default {  
    data: { 
        text: '',
        tupian: [],
        flag: '1'
    }, 
    methods: {
        xuanzezhaopian: function() {
            var _this = this;
            $z.ShangTu(function(e) {
                _this.tupian.push(e.url);
				
            });
        },

        tijiao: function() {
            var _this = this;
            $z.post('m=zw_shangcheng&k=wode&x=liuyan',{c: 'baocun',liuyan: _this.text,tu: JSON.stringify(_this.tupian)},
                function(s) {
					$z.toast(s.shu,'',2000);
					if(s.shi==1){
						setTimeout(function(){
							$z.go();
						},2000);
					}
				}
            );
        }  
    }
};
</script>

<style>
.tousujianyi {
    width: 100%;
    box-sizing: border-box;
    padding: 40upx 30upx 0upx 30upx;
}
textarea {
    width: 100%;
    border: 1upx solid #f3f3f3;
    display: block;
    box-sizing: border-box;
    min-height: 300upx;
    border-radius: 6upx;
    padding: 20upx;
    box-sizing: border-box;
}
.button {
    width: 95%;
    padding: 20upx;
    color: #ffffff;
    background: #000000;
    border-radius: 6upx;
    text-align: center;
    font-size: 34upx;
    margin: 10upx auto;
}
.zhaopian {
    width: 100%;
    display: flex;
    box-sizing: border-box;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    padding: 20upx 2upx;
}
.tupian {
    width: 18vw;
    height: 18vw;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.tupian image {
    width: 95%;
}
.tianjiakuang {
    width: 18vw;
    height: 18vw;
    color: #e2e2e2;
    background-color: #f3f3f3;
    font-size: 90upx;
    line-height: 90upx;
    display: flex;
    align-items: center;
    justify-content: center;
}
.shuoming {
    margin-left: 50upx;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}
</style>
