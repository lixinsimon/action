<template>
	<view>
		<view class="toubu"></view>
		<view class="view-sousuo">
			<view class="sousuokuang">
				<input type="text" value="" placeholder="搜索商品" class="input"/>
			</view>
			<icon class="iconfont icon-sousuo1" id="sousuo"></icon>	
		</view>
		<view class="leiming">
			<view  v-for="(l,i) in fenlei"  :class="{bian:(fenleiindex==i)}" @click="xianfenlei(i)" >{{l.ming}}</view>
		</view>
		
		<view class="shangpin" >
			<view class="bankuai"  v-if="fenlei[fenleiindex]">
				<navigator class="geti" v-for="l in fenlei[fenleiindex].haizi" @click="lianjie" :url="'./liebiao?id='+l.id">
					<image :src="l.tu"></image>
					<view>{{l.ming}} </view>
				</navigator>
			</view>
		</view>
	</view>
</template>
<script>
import $z from '@/zhiwi';
export default {
    data: {
        fenlei: [],
        fenleiindex: 0
    },
    onLoad: function() {
        $z.DengLu();
        this.CSH();
    },
    methods: {
        xianfenlei(e) {
            this.fenleiindex = e;
        },
        CSH: function() {
            var that = this;
            $z.post('m=zw_shangcheng&k=liebiao&x=fenlei', function(shu) {
                if (shu.shi == 1) {
                    that.fenlei = shu.shu;
                }
            });
        }
    }
};
</script>

<style>
.bian {
    background: #fff !important;
    color: red !important;
}
.toubu {
    width: 100%;
    height: 50upx;
    background: #ce1e17;
}
.view-sousuo {
    position: relative;
    width: 100%;
    background: #eee;
    height:120rpx;
}
/* #sousuo {
    position: absolute;
    left: 31%;
    top: 34upx;
    display: inline-block;
    font-size: 34upx;
    color: #a69a78;
} */
.input {
    margin-top: 11upx;
    width: 85%;
    margin-left: 29rpx;
}
.sou-box {
    padding: 10upx 0upx 10upx 0upx;
    width: 100%;
    line-height: 70px;
    background-color: #ffd460;
    text-align: center;
    color: #fff;
    font-size: 38px;
}

.icon-sousuo1 {
    width: 50rpx;
    height: 50rpx;
    color: #ffffff;
    margin-right: 40rpx;
    font-size: 34rpx;
    position: absolute;
    right: 6%;
    top: 38rpx;
    display: inline-block;
    font-size: 34rpx;
    color: #a69a78;
}
.sousuokuang {
    position: absolute;
    top: 21%;
    left: 11%;
    display: inline-block;
    background-color: #fff;
    width: 79%;
    text-align: center;
    height: 70upx;
    border-radius: 20upx;
}
.leiming {
    width: 160upx;
    height: 100vh;
    text-align: center;
    float: left;
    overflow-x: hidden;
    overflow-y: scroll;
    background: #f5f5f5;
}
.bankuai {
    min-height: 100vh;
    width: 100%;
}
.bankuai .geti {
    text-align: center;
    float: left;
    width: 33.3%;
    height: 250upx;
}
.leiming view {
    width: 160upx;
    /* background: #EEEEEE; */
    line-height: 100upx;
    height: 100upx;
}
.shangpin {
    width: 590upx;
    background: white;
    height: 100vh;
    float: left;
    overflow: hidden;
    overflow-x: hidden;
    overflow-y: scroll;
}
.geti image {
    height: 160upx;
    width: 160upx;
}
</style>
