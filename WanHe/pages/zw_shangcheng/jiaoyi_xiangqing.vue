<template>
	<view style="height: 100vh;">
		<view class="tou"> 
			<view class="left">
				<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/dKTzzDGJZ3hTOHd42gt4H3n31LHd63.png" mode=""></image>
			</view> 
			<view class="center">
				<view class="jiage">
					<view style="margin-right: 30upx;">¥{{shu.jiage}}</view>
					<view>{{shu.shuliang}}和券</view>
				</view> 
				<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/mZx5N7h1ZPS66wsPwxLpNLD1hgdlGT.png" style="width: 100%;height: 10upx;"></image>
				<view style="text-align: center; height: 50upx;line-height:50upx;color:#CE1E17;">{{shu.zhuangtai_wenzi}}</view>
			</view>
			<view class="right">
				<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/HspsLfEZlsLSdRJpTwEVGzNCCpGEnn.png" ></image>
			</view>				
		</view>		
		<view class="shoukuan" v-if="shu.leixing==1 && shu.zhuangtai==0">
			<view class="shoukuan_biaoti">
				<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/WcNCgFS8SCHm5GB6nN9HhnNNX69s5C.png" style="width: 35upx;height: 35upx;vertical-align: middle;"></image>
				收款账号
			</view>
			<view class="shoukuan_shurukuang">
				<input type="text" v-model:value="shoukuan" placeholder="请输入银行卡信息或支付宝账号"/>
			</view>
		</view>
		<view class="body">
			<view class="body_shurukuang">
				<view class="item">  
					<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/Wh5uP8nPeH2Dk5dkd12ZkaR8nP6h20.png" mode=""></image>
					卖方账号：{{shu.chushou.zhanghao}}</view>
				<view class="item">
					<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/yTmtVBVBDb1QbN4S7mOssb4n7T6B6e.png" mode=""></image>
					卖方收款：{{((shu.shoukuan == null) ? '' : shu.shoukuan)}}</view>
				<view class="item">昵称：{{shu.chushou.nicheng}}</view>		  
			</view>
			<view class="body_shurukuang">
				<view class="item">
					<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/Wh5uP8nPeH2Dk5dkd12ZkaR8nP6h20.png" mode=""></image>
					买方账号：{{shu.mairu.zhanghao}}</view>
				<view class="item">
					<image src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/yTmtVBVBDb1QbN4S7mOssb4n7T6B6e.png" mode=""></image>
					买方昵称：{{shu.mairu.nicheng}}</view>
			</view>
		</view>	 
		 
		<view style="position: fixed;bottom: 30upx;left: 20upx;" v-if="shu.leixing==1">
			<view v-if="shu.maimai==1">
				<view class="anniu_tijiao" @click="cao(10)" v-if="shu.zhuangtai==0">卖他和券</view>			
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==5">已取消</view>			
				<view class="anniu_tijiao" @click="cao(20)" v-else-if="shu.zhuangtai==10">确认支付</view>
				<view class="anniu_tijiao " style="background: #999;" v-else-if="shu.zhuangtai==20">耐心等待对方确认收款</view>
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==30">交易成功</view>			
			</view>
			<view v-else>				
				<view class="anniu_tijiao" @click="cao(5)" v-if="shu.zhuangtai==0">取消挂卖</view>	
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==5">已取消</view>	
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==10">等待买方付款</view>				
				<view class="anniu_tijiao" @click="cao(30)" v-else-if="shu.zhuangtai==20">确认收款</view>
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==30">交易成功</view>	
			</view>
			  
		</view>
		<view style="position: fixed;bottom: 30upx;left: 20upx;" v-else>
			<view v-if="shu.maimai==1">				
				<view class="anniu_tijiao" @click="cao(10)" v-if="shu.zhuangtai==0">我要认购</view>	
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==5">已取消</view>		
					<view class="anniu_tijiao" @click="cao(20)" v-else-if="shu.zhuangtai==10">确认支付</view>
				<view class="anniu_tijiao " style="background: #999;" v-else-if="shu.zhuangtai==20">耐心等待对方确认收款</view>
				
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==30">交易成功</view>
			</view>
			<view v-else>
				<view class="anniu_tijiao" @click="cao(5)" v-if="shu.zhuangtai==0">取消挂卖</view>			
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==10">等待买方付款</view>
				<view class="anniu_tijiao" @click="cao(30)" v-else-if="shu.zhuangtai==20">确认收款</view>
				<view class="anniu_tijiao" style="background: #999;" v-else-if="shu.zhuangtai==30">交易成功</view>
			</view>
		</view>
	</view>
</template>

<script>
import $z from '@/zhiwi';
export default {
    data: {
        shu: [],
        shoukuan:'',
    },
    onLoad: function(e) {
        this.id = e.id;
    },
    onShow: function() {
        this.CSH();
    },
    methods: {
        CSH: function() {
            var that = this;
            $z.post('m=zw_shangcheng&k=jiaoyi&c=xiangqing', { id: that.id }, function(s) {
                if (s.shi) {
                    that.shu = s.shu;
                }
            });
        },
        cao: function(e) {
            var that = this;
            $z.post(
                'm=zw_shangcheng&k=jiaoyi&c=zhuangtai',
                { id: that.id, zhuangtai: e, shoukuan: that.shoukuan },
                function(s) {
                    $z.toast(s.shu);
                    if (s.shi) {
                        that.CSH();
                    }
                }
            );
        }
    }
};
</script>

<style>
page {
    background-color: #f0f0f0;
}
.left {
    width: 20%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150upx;
}
.center {
    width: 60%;
    height: 150upx;
}
.jiage {
    display: flex;
    align-items: center;
    justify-content: center;
		
}
.right {
    width: 20%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150upx;
}
.tou {
    width: 100vw;
    height: 300upx;
    padding: 40upx;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333333;
    font-size: 32upx;
}
.item {
    height: 80upx;
    width: 100%;
    line-height: 80upx;
    border-bottom: 1upx solid #f0f0f0;
    margin-top: 10upx;
}
.item image {
    width: 35upx;
    height: 35upx;
    vertical-align: middle;
		margin: 0 10upx;
}
.tou image {
    width: 150upx;
    height: 150upx;
    border-radius: 50%;
}
.shoukuan {
    display: flex;
    justify-content: center;
    align-items: center;
    /* width: 100%; */
    height: 100upx;
    background-color: #ffffff;
    border-radius: 10upx; 
    color: #ce1e17;
    margin: 30upx 20upx;
    box-sizing: border-box;
}
.shoukuan_biaoti {
    width: 30%;
    text-align: center;
}
.shoukuan_shurukuang {
    /* width: 70%; */
    /* height: 146upx; */
    margin: 0 auto;
    display: flex;
    justify-content: center;
    border: 1upx solid #f0f0f0;
    border-radius: 5upx;
    align-items: center;
    /* padding: 53upx 21upx; */
    box-sizing: border-box;
}
.shoukuan_shurukuang > image {
    width: 50upx;
    height: 39upx;
}
.shoukuan_shurukuang > input {
    flex-grow: 1;
    margin-left: 5upx;
}
.body {
    font-size: 30rpx;
    color: #333333;
    box-sizing: border-box;
    background-color: #ffffff;
    border-radius: 10rpx;
    margin: 20rpx 20rpx;
    box-sizing: border-box;
}
.body_biaoti {
    /* margin-bottom: 30upx; */
}
.body_shurukuang {
    width: 100%;
    /* height: 146upx; */
    margin: 0 auto;
    /* display: flex;
    justify-content: center; */
    border-radius: 5upx;
    align-items: center;
    padding: 20upx 20upx;
    box-sizing: border-box;
}
.body_shurukuang > image {
    width: 50upx;
    height: 39upx;
}
.body_shurukuang > input {
    flex-grow: 1;
    margin-left: 53upx;
}

.anniu_tijiao {
    width: 710upx;
    margin: 0 auto;
    background: #1c2536;
    color: white;
    font-size: 30upx;
    padding: 27upx;
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
    border-radius: 10upx;
}

.tishi {
    width: 100vw;
    display: flex;
    justify-content: center;
    font-size: 20upx;
    color: #cccccc;
    padding: 19upx;
    box-sizing: border-box;
}
.xuzhi {
    color: #cc2e22;
}
</style>
