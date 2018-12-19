<template>
	<view>
	<view class="huangguan">
			<text>可用和券: </text>
			<text style="color: #FF0000;">{{shu.jifen}}</text>
	</view>
	<view class="shangpin">
		<navigator v-for="l in shangpin" :url="'./xiangqing?id='+l.id" class="shangpin_">
			<image :src="l.tu" mode="widthFix" class="shangpin_tu_"></image>
			<text class="biaoti">{{l.ming}}</text>
			<view class="jiege">
				     <text class="hejuan">和券:{{l.jiage}}</text>
					<text class="yuanjia">¥{{l.yuanjia}}</text>
					
					<!-- <image src="http://banma.heodo.com/gongyong/images/li.png" class="liquan_"></image> -->
			</view>
			<view style="display: inline-block;" class="duihaun">
				<text class="huan">立即兑换</text>
			</view>
		</navigator>			
	</view>
			
	</view>
</template>

<script>
import $z from '@/zhiwi'	
export default {
	data:{
		shu:{},
		shangpin:[],
		ye:1,
		jitiao:6
	},
	onShow:function(){
		this.CSH()
	},
	onReachBottom:function(){
		this.jiazai();
	},
	methods: {
		CSH:function() {
			var that=this;
			$z.post('m=zw_shangcheng&x=hequan',function(s){
				if(s.shi){
					that.shu=s.shu;
				}
			});
			$z.post('m=zw_shangcheng&x=hequan',{c:'shangpin',ye:1,jitiao:that.ye*that.jitiao},function(s){
				if(s.shi){
					that.shangpin=s.shu;
				}
			});
		},
		jiazai:function(){
			var that=this;			
			$z.post('m=zw_shangcheng&x=hequan',{c:'shangpin',ye:that.ye+1,jitiao:that.jitiao},function(s){
				if(s.shi){					
					that.shangpin.push(s.shu);
					that.ye++;
				}else{ 
					$z.toast(s.shu);
				}
			});
		}
	},
	
	
}
</script>

<style>
	.huangguan{
		width: 100%;
		height: 80upx;
		margin-bottom: 20upx;
		text-align: center;
		line-height: 80upx;
		font-weight: 600;
		font-size: 36upx;
	}
	.duihaun{
		width: 33%;
		background: #000;
		margin-left: 27%;
		color: #fff;
		margin-top: 10upx;
		padding: 5upx;
			}
	.hejuan{
		float: left;
	}
	.jiege{
		width: 95%;
		margin: 0 auto;
	}
	.user-phto{
		width: 150upx;
		height: 150upx;
		padding: 0upx 20upx;
		display: inline-block;
		border-radius: 50%;
	}
	.user-tu{
		width: 150upx;
		height: 150upx;
	}
	.user-msg{
		width: 300upx;
		height: 150upx;
		display: inline-block;
		color: #fff;
	}
	.user-id{
		margin-top: 30upx;
	}
	.huiyuan{
		width:113upx;
		text-align:center;
		line-height:30upx;
		font-size:28upx;
	}
	.shangpin{
		display: flex;
		flex-direction:row;
		width: 100%;
		flex-wrap: wrap;
	}
	.shangpin_{
		width: 46%;
		min-height: 400upx;
		margin:5upx 0upx 1upx 20upx ;
		background: #EEEEEE;
		margin-bottom: 10upx;
	}
	.shangpin_tu_{
		width: 345upx;
		height: 400upx;
	}
	.biaoti{
		width: 335upx;
		height: 40upx;
		margin-left: 10upx;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		}
	.yuanjia{
		text-decoration: line-through;
		color: #CCCCCC;
		float: right;
}
	.jifen{
		position: relative;
		top: 105upx;
		right: 299upx;
		height: 38upx;
		color: black;
	}
	.wode_yu_e{
		float: left;
	}
	.yu_e_shu{
		float: right;
	}
</style>
