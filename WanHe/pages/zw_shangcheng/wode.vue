<template>
	  <view>
		  <view class="toubu"></view>
			<view class="huangguan">
			<navigator url="wode_shezhi"  class="iconfont icon-shezhi" ></navigator>	
			<navigator class="iconfont icon-xiaoxi1" url="xiaoxi"></navigator>
				<view>
					<page-head :title="title"></page-head>
					<view class="uni-padding-wrap uni-common-mt">
						
						<view class="uni-list">
							<view class="uni-cell">
								<view class="uni-input">{{result}}</view>
							</view>
							<!-- class="iconfont icon-saoma" -->
						</view>
						<view class="uni-btn-v" >
							<button type="primary" @tap="scanCode" class="iconfont icon-saoma" id="saoma"></button>
						</view>
					</view>
				</view>
			
		</view> 
		<view class="gerenxinxi">
			<view class="user-phto">
				<image :src="shu.touxiang" class="user-tu"></image>
			</view>
			<view class="user-msg">
				<view class="user-id">
					ID:
					<text>{{shu.id}}</text>
					<view class="huiyuan">
						{{shu.dengjiming}}   
					</view>
				</view> 	
			</view>
			 <navigator url="wode_jifen" class="jifen">
					<view class="yu_e_shu">
						{{shu.jifen}}
					</view>
					<view class="wode_yu_e">
						<text style="float: left;">可用和券</text><text class="iconfont icon-jiantou2" style="font-size: 30upx;float: right; line-height: 44upx;"></text>
					</view>					
			 </navigator>
		</view>	
	
			<view class="jiange">
				
			</view>
		<view class="wode_body">
			<view class="fenlei">
				<navigator url="jiesuanbao" class="fenlei_zi">
					<view class="iconfont icon-yue1"></view>
					<view class="">结算宝</view>
				</navigator>
				<navigator url="jiaoyi" class="fenlei_zi">
					<view class="iconfont icon-duihuan"></view>
					<view>兑换市场</view>
				</navigator>
				<navigator @click="tishi" class="fenlei_zi" style="border-right: 0;">  <!-- url="../zw_shangcheng/lianmengshangjia" -->
					<view class="iconfont icon-renwu-zengjia"></view>
					<view>联盟商家</view>
				</navigator>
				<navigator class="fenlei_zi" @click="zhezhao">
					<view class="iconfont icon-fenxiang3"></view>
					<view>分享海报</view>
				</navigator>
				<navigator class="fenlei_zi" url="jiaoyi_chushou">
					<view class="iconfont icon-chushou"></view>
					<view>出售和券</view>
				</navigator>
				<navigator class="fenlei_zi" url="jiaoyi_qiugou">
					<view class="iconfont icon-goumai"></view>
					<view>求购和券</view>
				</navigator>
				<navigator class="fenlei_zi" url="jiaoyi_jilu">
					<view class="iconfont icon-yejibaobiaojiaoyijilu"></view>
					<view>交易记录</view>
				</navigator>
				<navigator class="fenlei_zi" url="dianpu">
					<view class="iconfont icon-dianpu"></view>
					<view>我的店铺</view>
				</navigator>
				<navigator class="fenlei_zi" url="dingdan" style="border-right: 0;">
					<view class="iconfont icon-dingdan1"></view>
					<view>我的订单</view>
				</navigator>
				<navigator class="fenlei_zi" url="shouhuodizhi">
					<view class="iconfont icon-dizhi3"></view>
					<view>收货地址</view>
				</navigator>
				<navigator class="fenlei_zi" url="wode_tousu">
					<view class="iconfont icon-guanyuwomen"></view>
					<view>投诉建议</view>
				</navigator>
				<navigator class="fenlei_zi" url="wode_tuandui">
					<view class="iconfont icon-yonghuguanli"></view>
					<view>我的团队</view>
				</navigator>
				
			</view>
			
		</view>
		
		<view class="haibaotuiguang_bg" v-if="xiaoshi">
			<image mode="widthFix" class="haibao" :src="haibao" @click="quxiao"></image>
			<icon class="guanbi iconfont icon-close" @click="quxiao"></icon>
			<view class="baocuntupian" @click="xiazai">保存图片</view>
			<icon class="xiazai iconfont icon-icon--" @click="xiazai"></icon>
		</view>	
		
		
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		data:{
			shu:{},
			xiaoshi:false,
			haibao:"",
		},
		onUnload:function(){
			this.result = '';
		},
		onShow:function(){
			$z.DengLu();
			this.CSH();
		},
		methods:{
			call:function(){
				wx.makePhoneCall({
					phoneNumber:'18812345612'
				})
			},
			CSH:function(){
				var that=this;
				$z.post('m=zw_shangcheng&k=wode',function(shu){	
				
					if(shu.shi==1){
						that.shu=shu.shu; 
					}
				})
			},
			zhezhao:function(){
			    var that=this;
				$z.post('m=zw_shangcheng&k=fenxiao&x=tuiguang',{c:'xiazhai'},function(s){
					$z.L(s)
					if(s.shi==1){
						that.haibao=s.shu;
						that.xiaoshi=true;
					}else{						
						$z.toast(shu.shu);						
					}
					
				})
				
				
			},
			quxiao:function(){
				this.xiaoshi=false
			},
			xiazai:function(){
				uni.saveImageToPhotosAlbum({
					filePath: this.haibao,
					success: function () {
						console.log('save success');
						uni.showToast({
							title: '保存成功', 
							duration: 2000
						});
					},
					fail:function(){
						console.log('保存失败') 
						uni.showToast({
							title: '保存失败',
							icon:'none',
							duration: 2000
						});
					}
				});
			},

    	scanCode: function () {
    		var that = this
    		uni.scanCode({
    			success: function (res) {
    				that.result = res.result
    			},
    			fail: function (res) {}
    		});
				
    	},
			
			tishi:function(){
				$z.toast('即将上线');
			}
    }
		}

</script>

<style>
	.jiange{
		width: 88%;
		margin: 0 auto;
		background: #DCDCDC;
		height: 20upx;
	}
	.fenlei{
		width: 96%;
		display: flex;
		flex-wrap: wrap;
		justify-content: flex-start;
		margin:20upx auto ;
	}
	
	.fenlei_zi{
		width: 240upx;
		height: 200upx;
		text-align: center;
		box-sizing: border-box;
		border-right: 1upx solid #fcfcfc;
		border-bottom: 1upx solid #fcfcfc;
	}
	.fenlei_zi .iconfont{
		font-size: 50upx;
		margin: 36upx;
	}
	
	.haibaotuiguang_bg{width: 100vw;height: 100vh;position: fixed;top: 0;left: 0;right: 100vw;bottom: 100vh;overflow: hidden;background: black;
						display: flex;align-items: center;justify-content:center;overflow-y: scroll;}
	.haibao{width: 100vw;;display: block;}
	.guanbi{position: fixed;top: 5vw;right: 5vw;font-size: 48upx;color: white;}
	.baocuntupian{position: fixed;top: 90vh;width: 150upx;margin: 0 auto;font-size: 30upx;color: white;text-align: center;background: rgb(0,0,0,0.5);border: 1upx solid white ;}
	.xiazai{position: fixed;top: 90vh;right: 5vw;font-size: 48upx;color: white;}
	.toubu{
			width: 100%;
			height: 50upx;
			background: #ce1e17;
		}
		.icon-xiaoxi1{
			
		}
	.jifen{
		position: relative;
		top: 150upx;
		right: 450upx;
		height: 100upx;
	}
	
	
	
	.icon-xiaoxi1{
		position: absolute;
		width: 50upx;
		height: 50upx;
		right: 33upx;
		top:67upx;
		color: #FFFFFF;
		font-size: 44upx;
	}
	.you{
		font-size: 40upx;
		color: #b8c8d6;
	}
	.gerenxinxi{
		height:250upx;
		padding-top:20upx;		
		display:flex;
		flex-wrap:wrap;
		margin-top:20upx;
		border-radius:20upx 20upx 0 0;
		background: url(http://zshidai.zhiwi.cn/gongyong/shangchuan/images/12/2018_11/P52mUAeRU3AEm3S7WfA27Bm7AnC33W.png)no-repeat center;	
		width: 88%;
		margin: 0 auto;
		position: absolute;
		top: 150upx;
		left: 6%;
}
	.dizhi{
		width: 50%;
		height: 150upx;
		float: left;
		text-align:center;	
		
	}
	.dizhi image{
		width: 80upx;
		height: 80upx;
		margin: 20upx;
	}
	.fengxiang{
		height: 80upx;
		width: 90%;
		margin: 0 auto;
		line-height: 80upx;
		border-bottom: 1upx solid #EEEEEE;
		text-align: center;
	}
	.quxiao{
			height: 80upx;
			width: 90%;
			margin: 0 auto;
			line-height: 80upx;
			text-align: center;
			margin-top: 80upx;
			border-bottom: 1upx solid #EEEEEE;
	}
	.zhezhao{
		width: 100%;
		height: 70vh;
		background: #000000;
		opacity: 0.5;
		position: fixed;
		top: 0;
		left: 0;
	}
	.fenxiang{
		background: white;
		width: 100%;
		height: 30vh;
		position: fixed;
		bottom: 0;
		left: 0;
	}
	.icon-shezhi{
		position: absolute;
		width: 50upx;
		height: 50upx;
		right: 105upx;
		top:67upx;
		color: #FFFFFF;
		font-size: 44upx;
	}
	#saoma{
		width:55upx;
		line-height:41upx;
		font-size:60upx;
		margin-left:42upx;
    padding: 0;
		background-color: #1a2436;
	}
	button::after{
	border: none;
	}
	.huangguan{
		width: 100%;
		height: 350upx;
		background-color: #1c2536;
		padding-top: 20upx;
		display: flex;
		flex-wrap: wrap;
	}
	 .user-phto{
		width: 150upx;
		height: 150upx;
		border-radius: 50%;
		padding: 10upx;
	}
	.user-tu{
		width: 100upx;
		height: 100upx;
		margin: 25upx;
		border-radius: 50%;
	}
	.user-msg{
		width: 300upx;
		height: 150upx;
		display: inline-block;
		color: #000;
	}
	.user-id{
		margin-top: 60upx;
	}
	.huiyuan{
		margin-top: 10upx;
	}
	.xunzhang{
		margin-top:30upx;
		width: 100upx;
		height: 120upx;
	}
	.xunzhang_tu{
		width: 50upx;
		height: 50upx;
		margin-left:70upx;

	}
	.xunzhang_geshu{
		color: #FFFFFF;
		text-align: right;
	}
	.wo_de{
		width: 100%;
		height: 200upx;
		display: flex;
		flex-wrap: wrap;
		margin-bottom: 10upx;
	}
	.wo_de>navigator{
		flex: 1;
		align-items: center;
		justify-content: center;
		
	}
	.wode_icon{
		text-align:center;
	}
	.wode_icon>image{
		width: 60upx;
		height: 60upx;
		margin-top: 30upx;
	}
	.wode_yu_e,.yu_e_shu{
		text-align: center;
		margin: 10upx 0upx;
		
	}
	.yu_e_shu{
		font-weight: bold;
	}
	.kongbai{
		width: 100%;
		height: 20upx;
		background-color: #EEEEEE;
	}
	.wode_body{
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		float: left;
		margin-bottom: 100upx;
	}
	.wode_body_xinxi{
		box-sizing: border-box;
		border-bottom: 6upx solid #f6f6f6;
        border-right: 2upx solid #EEEEEE;
		width: 100%;
		height: 80upx;
	}
	.wode_body_xinxi_tu>image{
		width: 36upx;
		height: 36upx;
		margin-top: 17upx;
		float: left;
		margin-left: 20upx;
	}
	.wode_body_xinxi_tu{
		text-align: center;
		width: 100%;
	}
	.wode_body_xinxi_zi{
		text-align: center;
		line-height: 70upx;
		float: left;
		margin-left: 32upx;
	}
</style>


