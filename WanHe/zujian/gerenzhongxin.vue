<template>
<div id="wode1" style="width: 100%;float: left;display: block;">
    <div class="baibeijing">
        <img src="@/images/jianbian_02_01.jpg" width="100%" height="230px" onclick="return false">
        <a > <i class="icon-setting she" style="position: absolute;"></i></a>
        <div class="huangguan">
            <img :src="list.touxiang" style="width:80px;height:80px;border-radius:50%;border:4px solid #00960e;margin: 0 auto;">
            <div style="color: #fff;font-size: .3rem;line-height: .5rem;">{{list.nicheng?list.nicheng:list.id}}</div>
            <div class="huiyuan">
                <img src="@/images/huangguan_06.png">
                <h5>{{list.dengjiming}}</h5>
            </div>
        </div>
    </div>
    <div class="yue">
        <h2 class="">我的余额</h2>
        <h3 class="">￥{{list.yu_e}}</h3>
    </div>

    <div class="m-grids-5 dai">
        <a  class="grids-item">
	        <img src="@/images/wode-icon_03.png">
	        <div class="grids-txt">待付款</div>
	        <span v-if="list.daifu>0">{{list.daifu}}</span>
	    </a>
        <a  class="grids-item">
	       	<img src="@/images/wode-icon_10.png">
	        <div class="grids-txt">待发货</div>
	        <span v-if="list.daifa>0">{{list.daifa}}</span>
	    </a>
        <a  class="grids-item">
	       <img src="@/images/wode-icon_12.png">
	        <div class="grids-txt">待收货</div>
	        <span v-if="list.daishou>0">{{list.daishou}}</span>
	    </a>
        <a  class="grids-item">
	       <img src="@/images/wode-icon_05.png">
	        <div class="grids-txt">已完成</div>
	        <span v-if="list.yiwancheng>0">{{list.yiwancheng}}</span>
	    </a>
        <a  class="grids-item">
	        <img src="@/images/wode-icon_07.png">
	        <div class="grids-txt">退换货</div>
	        <span v-if="list.tuihuo>0">{{list.tuihuo}}</span>
	    </a>
    </div>
    <div class="m-cell">
        <a class="cell-item"  v-if='list.hexiao'>
            <div class="cell-left"><i class="cell-icon tb-hexiaochuli"></i>核销员</div>
            <div class="cell-right cell-arrow">我核销的记录</div>
        </a>
        <a class="cell-item" >
            <div class="cell-left"><i class="cell-icon tb-ai-wallet"></i>我的钱包</div>
            <div class="cell-right cell-arrow">{{list.yu_e}}元</div>
        </a>
        <a v-if="!list.shang_hu" class="cell-item" >
            <div class="cell-left"><i class="icon-shield" style="font-size: 0.42rem !important;margin-right: .1rem;"></i>申请商户</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a v-if="!list.shang_hu" class="cell-item" >
            <div class="cell-left"><i class="icon-shield" style="font-size: 0.42rem !important;margin-right: .1rem;"></i>商户管理</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a v-if="!list.dai_li" class="cell-item" >
            <div class="cell-left"><i class="icon-verifycode" style="font-size: 0.42rem !important;margin-right: .1rem;"></i>申请代理</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a v-if="!list.dai_li" class="cell-item" >
            <div class="cell-left"><i class="icon-verifycode" style="font-size: 0.42rem !important;margin-right: .1rem;"></i>代理管理</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a class="cell-item" >
            <div class="cell-left"><i class="tubiao icon-150 not_not" style="font-size: 0.42rem !important;margin-right: .1rem;color: #f15046;"></i>快速充值</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a class="cell-item" >
            <div class="cell-left"><i class="icon-type icon-order" style="font-size: 0.42rem !important;margin-right: .1rem;"></i>我的砍价</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a class="cell-item" >
            <div class="cell-left"><i class="cell-icon tb-youhuiquan"></i>优惠券</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a class="cell-item" >
            <div class="cell-left"><i class="cell-icon tb-jifen"></i>我的积分</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a class="cell-item" >
            <div class="cell-left"><i class="cell-icon tb-dizhi"></i>收货地址</div>
            <div class="cell-right cell-arrow"></div>
        </a>
        <a class="cell-item" > 
            <div class="cell-left"><i class="cell-icon icon-footmark"></i>签到</div>
            <div class="cell-right cell-arrow"></div>
        </a>
    </div>
</div>
</template>

<script>
	export default {
	  name: 'gerenzhongxin',
	  data () {
	    return {
	      
	    }
	  },
	   props: ['list'],
//	   beforeCreate:function(){
//	   	 console.log(this.list)
//	   }
	}
</script>

<style>
	 #wode1 {
        display: none;
    }

    .tb-hexiaochuli:before {
        color: #EACF02;
    }

    .cell-left .tb-ai-wallet:before {
        color: #d87049;
    }

    .tb-youhuiquan:before {
        color: #ABC327;
    }

    .tb-jifen:before {
        color: #DFB5B7;
    }

    .tb-shoucang:before {
        color: #7F1874;
    }

    .tb-dizhi:before {
        color: #DB9019;
    }

    .cell-left .tb-tixian1:before {
        color: #943e3e;
    }

    .tb-kefu1:before {
        color: #FF6E97;
    }

    .icon-footmark:before {
        color: black !important;
    }

    html {
        background: #f5f5f7;
    }

    .tou_bei {
        width: 100%;
        height: 222px;
        background: rgb(117, 190, 13);
    }
    .dai span{
    	position: absolute;
	    top: 4px;
	    right: 4px;
	    width: 20px;
	    height: 20px;
	    background: red;
	    border-radius: 50%;
	    color: #fff;
	    font-size: 12px;
	    text-align: center;
	    line-height: 20px;
    }
</style>