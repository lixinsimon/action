<template>
	<view>
		<form action="">
			<view class="item">
				<view class="quhao">+86</view>
				<input type="phone" v-model="shu.shouji" class="phone" placeholder="请输入手机号码"/>
			</view>
			<view class="item">
				<input type="text" v-model="shu.yanzhengma" class="yanzhengma" placeholder="请输入验证码"/>
				<view class="huoqu" v-if="flag" @click="yanzhengma">获取验证码</view>
				<view class="huoqu" v-else style="background-color: #dcdcdc;width: 155upx;">{{jishi}}s</view>
			</view>
			<view class="item">
				<input type="password" v-model="shu.mima" class="denglumima" placeholder="请设置登录密码(六位以上字母数字)"/>
			</view>
			<view class="item">
				<input type="password" v-model="shu.querenmima" class="querenmima" placeholder="再次确认密码"/>
			</view>
			<view class="item">
				<input type="text" v-model="shu.tuijian" class="querenmima" :value="tuijian" placeholder="推荐码"/>
			</view>
			<view style="width: 100%;padding: 0upx 30upx;box-sizing: border-box;">
				<view v-if="!xieyi_flag" class="lijizhuce" style="opacity: 0.2;">立即注册</view>
				<view v-else @click="tijiao" class="lijizhuce">立即注册</view>
			</view>
			
			<view class="zhucexieyi"> 
				<view class="anniu_xieyi" @click="xieyi_gouxuan(!xieyi_flag)">
					<image v-if="!xieyi_flag" src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/bvredP70xNEEe8DvgJsdVnrXVa11p1.png" mode=""></image>
					<image v-else src="https://wanhe.zhiwi.cn/gongyong/shangchuan/images/12/2018_12/aqXA1tNMvpo349mQJHqAm13J0vZogg.png" mode=""></image>
				</view>
				
				<navigator url="zhucexieyi" style="display: inline-block; color: #1B2436;border-bottom: 1upx solid #1B2436;">注册协议</navigator>
				<text style="color: #999999;font-size: 20upx;">(勾选即同意注册协议)</text>
			</view>
		</form>
	</view>
</template>

<script>
import $z from '@/zhiwi';
export default {
    data: {
        shu: {},
        flag: 1,
        jishi: 60,
        tuijian: '',
        xieyi_flag: 0
    },
    onShow: function() {
        var that = this;
        $z.post('k=denglu&x=zhuce&c=tuijianma', function(shu) {
            that.tuijian = shu.shu;
        });
    },
    methods: {
        tijiao: function() {
            var that = this;
            if (that.shu.mima != that.shu.querenmima) {
                $z.toast('密码不一致');
                return;
            }

            $z.post('k=denglu&x=zhuce',
				{
                    shouji: that.shu.shouji,
                    yanzheng: that.shu.yanzhengma,
                    mima: that.shu.mima,
                    t: that.tuijian
                },
                function(shu) {
                    $z.L(shu);
                    if (shu.shi == 1) {
                        $z.Cun('kouling', shu.shu.kouling);
                        $z.Cun('hyid', shu.shu.id);
                        $z.toast('注册成功');
                        setTimeout(function() {
                            uni.switchTab({
                                url: '/pages/zw_shangcheng/index'
                            });
                        }, 500);
                    } else {
                        $z.toast(shu.shu);
                    }
                }
            );
        },

        yanzhengma: function() {
            var _this = this;
            _this.jishi = 60;
            _this.flag = 0;
            var stop = setInterval(function() {
                if (_this.jishi <= 0) {
                    clearInterval(stop);
                    _this.flag = 1;
                }
                _this.jishi--;
            }, 1000);

            $z.post('k=denglu&x=zhuce', { c: 'yanzhengma', shouji: this.shu.shouji }, function(
                shu
            ) {
                $z.toast(shu.shu);
                if (shu.shi == 1) {
                } else {
                    clearInterval(stop);
                    _this.flag = 1;
                }
            });
        },
        xieyi_gouxuan: function(e) {
            this.xieyi_flag = e;
        }
    }
};
</script>

<style>
.item {
    width: 100%;
    box-sizing: border-box;
    height: 100upx;
    padding: 0upx 30upx;
    border-top: 1upx solid #f3f3f3;
    border-bottom: 1upx solid #f3f3f3;
    line-height: 100upx;
}
.quhao {
    display: inline-block;
    height: 100upx;
    line-height: 100upx;
}
.phone {
    display: inline-block;
    margin-left: 25upx;
    vertical-align: middle;
}
.yanzhengma {
    vertical-align: middle;
    display: inline-block;
}
.huoqu {
    display: inline-block;
    height: 70upx;
    width: 155upx;
    float: right;
    text-align: center;
    line-height: 70upx;
    border-radius: 10upx;
    background-color: #1b2436;
    clear: both;
    margin-top: 11upx;
    color: #f3f3f3;
}
.denglumima,
.querenmima {
    width: 100%;
    height: 100upx;
}
.lijizhuce {
    display: block;
    width: 100%;
    height: 90upx;
    font-size: 35upx;
    box-sizing: border-box;
    border-radius: 10upx;
    color: #ffffff;
    text-align: center;
    line-height: 90upx;
    background-color: #1b2436;
    margin-top: 40upx;
}

.zhucexieyi {
    width: 100%;
    padding: 30upx;
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
}
.anniu_xieyi {
    width: 40upx;
    height: 40upx;
    margin-right: 20upx;
}
.anniu_xieyi > image {
    width: 100%;
    height: 100%;
}
.zhucexieyi > text {
}
</style>
