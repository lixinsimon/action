<template>
	<view>
		<view class="nav">
			<view class="nav-bar" @click="qiehuan(100)">
				<view class="nav-bar-item " :class="{active:(zhuangtai==100)}">全部</view>
			</view>
			<view class="nav-bar" @click="qiehuan(0)">
				<view class="nav-bar-item" :class="{active:(zhuangtai==0)}">待付款</view>
			</view>
			<view class="nav-bar" @click="qiehuan(10)">
				<view class="nav-bar-item" :class="{active:(zhuangtai==10)}">待发货</view>
			</view>
			<view class="nav-bar" @click="qiehuan(20)">
				<view class="nav-bar-item" :class="{active:(zhuangtai==20)}">已发货</view>
			</view>
			<view class="nav-bar" @click="qiehuan(30)">
				<view class="nav-bar-item" :class="{active:(zhuangtai==30)}">完成</view>
			</view>
		</view>
		<!-- -->
		<view style="margin-top: 75upx;">
			<view class="item "  style="display: block;" v-for="(s,i) in dingdan[zhuangtai]" v-if="dingdan[zhuangtai]">
				<navigator class="tou" :url="'dingdan_xiangqing?id='+s.id">
					<view class="dingdanhao">{{s.dingdanhao}}</view>
					<view class="dingdanzhaungtai">{{s.zhuangtai_wenzi}}</view>
				</navigator>
				<view class="wei" >
					<navigator class="xiangqing" v-for="(d,k) in s.dingdan_shangpin"  :url="'dingdan_xiangqing?id='+s.id">
						<view class="xq_tu">
							<image :src="d.tu"></image>
						</view>
						<view class="xq_neirong">
							<view class="xq_title">{{d.ming}}</view>						
							<view class="xq_jiage">
								<view class="xianjia">¥{{d.jiage}}</view>
								<view class="yuanjia">¥{{d.yuanjia}}</view>
								<view class="shuliang">X{{d.shuliang}}</view>
							</view>
						</view>
					</navigator>
					<view class="jiesuan">
						<navigator class="zongji" :url="'dingdan_xiangqing?id='+s.id">
							<view class="zj_shuliang">共计{{s.zongshu}}件 </view>
							<view class="zj_jin_e">总额：<text>¥{{s.zongjia}} </text></view>
							<view class="zj_yunfei">(含运费{{s.yunfei}})</view>
						</navigator>
						<view class="jiesuan_button">					
							<view class="button_view" v-if="s.zhuangtai==6" >
								<view class="button">退款中</view>	
							</view>		
							
							<view  class="button_view" v-else-if="s.zhuangtai==5 || s.zhuangtai==40">
								<!-- <navigator class="button" url="index" >再次购买</navigator> -->
							</view>		
											
											
							<view class="button_view" v-else-if="s.zhuangtai==7">
								<view class="button">已退款</view>
							</view>
							
							<view class="button_view" v-else-if="s.zhuangtai==10" >
								<!-- <view class="button button_background" @click="Cao('tixing',s.id,'提醒发货')">提醒发货</view> -->
								<view class="button" @click="Cao('tuikuan',s.id,'退款')">退款</view>
							</view>
							
							<view class="button_view" v-else-if="s.zhuangtai==15 || s.zhuangtai==25">
								<view class="button">退换货中</view>
								
							</view>
							
							
							<view class="button_view" v-else-if="s.zhuangtai==20">
								<view class="button button_background" @click="Cao('shouhuo',s.id)">确认收货</view>
								<!-- <navigator class="button" url="kuaidixiangqing">查看物流</navigator>							 -->
								<view class="button" @click="Cao('tuikuan',s.id,'退款')">退款</view>
							</view>
							
							<view class="button_view" v-else-if="s.zhuangtai==30">
								<navigator  class="button button_background" url="index" >再次购买</navigator>
								<!-- <navigator class="button" url="kuaidixiangqing">查看物流</navigator>		 -->
								<view class="button"  v-if="s.leixing!=2  && s.ketuihuo"  @click="Cao('tuihuo',s.id,'退换货')">退换货</view>
							</view>
							
							
							<view class="button_view" v-else>
								<navigator class="button button_background" :url="'zhifu?dingdanid='+s.id" >付款</navigator>						
								<view class="button" @click="Cao('quxiao',s.id,'取消订单')">取消订单</view>
							</view>
					
						</view>
					</view>
				</view>
			</view>
		</view>
		
	</view>
</template>

<script>
import $z from '@/zhiwi';
export default {
    data: {
        shu: {},
        dingdan: {},
        flag: 1,
        ye: {},
        jitiao: 4,
        zhuangtai: 100
    },
    onLoad: function(e) {
        if (e.zhuangtai) {
            this.zhuangtai = e.zhuangtai;
        }
    },
    onShow: function() {
        this.CSH();
    },
    onReachBottom: function() {
        this.jiazhai();
    },
    onPullDownRefresh: function() {
        this.CSH();
        setTimeout(function() {
            uni.stopPullDownRefresh();
        }, 1000);
    },
    methods: {
        CSH: function() {
            var that = this;

            if (!that.ye[that.zhuangtai]) {
                that.ye[that.zhuangtai] = 1;
            }
            $z.post(
                'm=zw_shangcheng&k=dingdan&x=dingdan',
                { zhuangtai: that.zhuangtai, ye: 1, jitiao: that.jitiao * that.ye[that.zhuangtai] },
                function(shu) {
                    if (shu.shi == 1) {
                        that.shu = shu.shu;
                        that.dingdan[that.zhuangtai] = shu.shu.dingdan;
                    } else {
                        that.dingdan[that.zhuangtai].shift();
                    }
                }
            );
        },
        qiehuan: function(e) {
            this.zhuangtai = e;
            this.CSH();
        },
        Cao: function(a, b, c) {
            var that = this;
            $z.post('m=zw_shangcheng&k=dingdan&x=dingdan', { c: a, dingdanid: b }, function(s) {
                $z.toast(s.shu);
                if (s.shi == 1) {
                    that.CSH();
                }
            });
        },
        jiazhai: function() {
            var that = this;
            $z.post(
                'm=zw_shangcheng&k=dingdan&x=dingdan',
                { zhuangtai: that.zhuangtai, ye: that.ye[that.zhuangtai] + 1, jitiao: that.jitiao },
                function(shu) {
                    if (shu.shi == 1) {
                        for (let i in shu.shu.dingdan) {
                            that.$set(
                                that.dingdan[that.zhuangtai],
                                that.dingdan[that.zhuangtai].length,
                                shu.shu.dingdan[i]
                            );
                        }
                        that.ye[that.zhuangtai]++;
                    } else {
                        $z.toast(shu.shu);
                    }
                }
            );
        }
    }
};
</script>

<style>
page {
    background: #f7f7f7;
}
.button_view {
    width: 100%;
    display: flex;
    flex-direction: row-reverse;
}
.button {
    padding: 5upx;
    width: 140upx;
    border: 1px solid #1c2536;
    border-radius: 25px;
    text-align: center;
    margin-left: 10upx;
    margin-bottom: 10upx;
}
.button_background {
    background: #1c2536;
    color: white;
}
.nav {
    z-index: 1000;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 70upx;
    border-bottom: 0.1upx solid #f3f3f3;
    display: flex;
    align-items: center;
    padding: 0 30upx;
    color: #999999;
    background: white;
    box-sizing: border-box;
}
.nav-bar {
    width: 25%;
    display: flex;
    justify-content: center;
}
.nav-bar-item {
    width: 90upx;
    height: 70upx;
    line-height: 70upx;
    text-align: center;
}
.active {
    border-bottom: 5upx solid #000000;
    color: #000000;
}
.item {
    width: 100%;
    box-sizing: border-box;
    background: white;
    margin-bottom: 10upx;
}
.tou {
    width: 100%;
    height: 80upx;
    display: flex;
    padding: 0 30upx;
    border-bottom: 0.1upx solid #f3f3f3;
    align-items: center;
    box-sizing: border-box;
}
.dingdanhao {
    width: 50%;
    color: #999999;
    font-size: 24upx;
}
.dingdanzhaungtai {
    width: 50%;
    text-align: right;
    font-size: 24upx;
}
.wei {
    box-sizing: border-box;
    width: 100%;
}
.xiangqing {
    width: 100%;
    box-sizing: border-box;
    display: flex;
    height: 200upx;
    align-items: center;
    border-bottom: 0.1upx solid #f3f3f3;
    padding: 0 30upx;
}
.xq_tu {
    width: 30%;
    height: 150upx;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}
.xq_neirong {
    width: 80%;
    height: 200upx;
}
.xq_neirong > view {
    height: 60upx;
    line-height: 60upx;
    margin-top: 30upx;
}
.xq_tu > image {
    width: 150upx;
    height: 150upx;
}
/* 	.xq_guige{
		font-size: 20upx;
		color: #999999;
	} */
.xq_title {
    margin-top: 25upx;
}
.xq_jiage {
    width: 100%;
    display: flex;
}
.xianjia {
    width: 25%;
    color: #f3312f;
}
.yuanjia {
    width: 15%;
    font-size: 20upx;
    text-decoration: line-through;
    color: #999999;
}
.shuliang {
    width: 60%;
    text-align: right;
}
.jiesuan {
    width: 100%;
    box-sizing: border-box;
    padding: 0 30upx;
}
.zongji {
    display: flex;
    width: 100%;
    height: 80upx;
    align-items: center;
    justify-content: flex-end;
}
.zongji > view {
    margin-left: 10upx;
    color: #999999;
    font-size: 25upx;
}
.zj_jin_e > text {
    color: #f3312f;
    font-size: 30upx;
}
</style>
