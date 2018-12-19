<template>
	<view class="page">
		<view class="denglu_nav">
			<view class="denglu_item" @click="qiehuan(1)">
				<view class="yhm_denglu " data-index="0"  :class="{active:flag}">用户名登录</view>
			</view>
			<view class="denglu_item"  @click="qiehuan(2)" >
				<view class="yzm_denglu " data-index="1" :class="{active:!flag}">手机登录</view>
			</view>	
		</view>
		<view class="container" >
			<view class="item" data-index="0" v-if="flag" >
					<view class="item_name">
						<text>用户名：</text>
						<input type="phone" v-model="shu.zhanghao" placeholder="请输入用户名/手机号码" class="user-name"/>
					</view>
					<view class="item_mima">
						<text>密  码：</text>
						<input type="password" v-model="shu.mima" placeholder="请输入6位以上字母数字" class="mima"/>
					</view>
					<view style="width: 100%; padding: 0 30upx; box-sizing: border-box;margin-top: 30upx;">
						<view class="denglu" @click="tijiao">登录</view>
					</view>
					<view class="item_wei">
						<navigator class="zhuce" url="zhuce" hover-class="none">注册</navigator>
						<navigator class="wangjimima" url="" hover-class="none">忘记密码</navigator>
					</view>
				</view>
			<view class="item" date-index="1" v-if="!flag">
				<view class="item_phone">
					<text>+86</text>
					<input type="phone" v-model="shu.shouji" placeholder="请输入手机号码" class="phone"/>
				</view>
				<view class="item_yzm">
					<input type="text" v-model="shu.yanzheng" placeholder="请输入验证码" class="yzm"/>
					<text class="hqyzm" v-if="tag" @click="yanzhengma">获取验证码</text>
					<view class="hqyzm" v-else style="background-color: #f3f3f3;width: 155upx;">{{jishi}}s</view>
				</view>
				<view style="width: 100%; padding: 0 30upx; box-sizing: border-box;margin-top: 30upx;">
					<view class="denglu" @click="shoujidenglu">登录</view>
				</view>
			</view>
			<!-- <view class="disanfan">
				  <button open-type="getUserInfo" lang="zh_CN" bindgetuserinfo="onGotUserInfo" class="weixin" ><icon class="iconfont icon-weixin3"/></button>
			</view> -->
		</view>
	</view>
</template>

<script>
import $z from '@/zhiwi';
export default {
    data: {
        shu: {},
        jishi: 60,
        flag: 1,
        tag: 1
    },
    methods: {
        tijiao: function() {
            var that = this;
            $z.post('k=denglu', { zhanghao: that.shu.zhanghao, mima: that.shu.mima }, function(
                shu
            ) {
                if (shu.shi == 1) {
                    $z.Cun('kouling', shu.shu.kouling);
                    $z.Cun('hyid', shu.shu.id);
                    $z.toast('登录成功');
                    setTimeout(function() {
                        $z.go();
                    }, 500);
                } else {
                    $z.toast(shu.shu);
                }
            });
        },
        shoujidenglu: function() {
            var that = this;
            $z.post(
                'k=denglu&c=shoujidenglu',
                { shouji: that.shu.shouji, yanzheng: that.shu.yanzheng },
                function(shu) {
                    if (shu.shi == 1) {
                        $z.Cun('kouling', shu.shu.kouling);
                        $z.Cun('hyid', shu.shu.id);
                        $z.toast('登录成功');
                        setTimeout(function() {
                            $z.go();
                        }, 500);
                    } else {
                        $z.toast(shu.shu);
                    }
                }
            );
        },
        qiehuan: function(e) {
            if (e == 1) {
                this.flag = 1;
            } else if (e == 2) {
                this.flag = 0;
            }
        },

        yanzhengma: function() {
            var _this = this;
            _this.jishi = 60;
            _this.tag = 0;
            var stop = setInterval(function() {
                if (_this.jishi <= 0) {
                    clearInterval(stop);
                    _this.tag = 1;
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
                    _this.tag = 1;
                }
            });
        }
    }
};
</script>
<style>
.disanfan {
    width: 60%;
    margin: 0 auto;
    margin-top: 30%;
}
.disanfan button {
    background: #1aad19;
    width: 50upx;
    height: 50upx;
    padding: 0upx;
    line-height: 0upx;
}
.icon-weixin3 {
    margin-top: -5rpx;
    color: #fff;
    font-size: 45upx;
}

.page {
    width: 100%;
    box-sizing: border-box;
}
.denglu_nav {
    display: flex;
    width: 100%;
    padding: 0 30upx;
    box-sizing: border-box;
    border-top: 0.1upx solid #f3f3f3;
}
.denglu_item {
    width: 50%;
    text-align: center;
}
.yhm_denglu,
.yzm_denglu {
    width: 200upx;
    height: 100upx;
    line-height: 100upx;
    text-align: center;
    box-sizing: border-box;
    margin-left: 50upx;
}
.active {
    color: #1b2436;
    border-bottom: 5upx solid #1b2436;
}
.container {
    width: 100%;
    box-sizing: border-box;
}
.item {
    width: 100%;
    box-sizing: border-box;
		display: flex;
		flex-direction: column;
		padding: 30upx;
}
.item > view {
    width: 100%;
    height: 100upx;
    line-height: 100upx;
    border-top: 0.1upx solid #f3f3f3;
    box-sizing: border-box;
		display: flex;
		align-items: center;
}

.item_phone > text {
		width: 20%;
    color: #1b2436;
}
input {
		flex-grow: 1;
    display: inline-block;
    vertical-align: middle;
}
.phone {
    margin-left: 20upx;
}
.item_yzm {
    width: 100%;
    display: flex;
    border-bottom: 0.1upx solid #f3f3f3;
}
.yzm {
    width: 70%;
    height: 100upx;
    line-height: 100upx;
}
.hqyzm {
    display: inline-block;
    width: 30%;
    height: 70upx;
    line-height: 70upx;
    text-align: center;
    margin-right: 0upx;
    background-color: #1b2436;
    border-radius: 10upx;
    margin-top: 15upx;
    color: #ffffff;
}
.denglu {
    width: 100%;
    height: 80upx;
    color: #ffffff;
    background-color: #1c2536;
    text-align: center;
    line-height: 80upx;
    border-radius: 10upx;
    font-size: 33upx;
}
.item_wei {
    width: 100%;
    box-sizing: border-box;
    padding: 0 30upx;
    display: flex;
    height: 50upx;
}
.item_wei > navigator {
    height: 50upx;
    width: 50%;
    text-decoration: underline;
    font-size: 23upx;
}
.zhuce {
    text-align: left;
}
.wangjimima {
    text-align: right;
    color: #999999;
}
</style>
