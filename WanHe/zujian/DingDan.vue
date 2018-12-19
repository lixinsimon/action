<template>
	<view stytle="width:100vw">
		<view v-for="l in shu" class="item item-quanbu" data-index="0" style="display: block;">
			<view class="tou">
				<view class="dingdanhao">{{l.bianhao}}</view>
				<view class="dingdanzhaungtai">{{l.zhuangtai}}</view>
			</view>
			<view class="wei">
				<navigator url="">
					<view class="xiangqing">
						<view class="xq_tu">
							<image :src="l.tu" mode="widthFix" ></image>
						</view>
						<view class="xq_neirong">
							<view class="xq_title">{{l.biaoti}}</view>
							<view class="xq_guige">{{l.guige}}</view>
							<view class="xq_jiage">
								<view class="xianjia">{{l.jiage}}</view>
								<view class="yuanjia">{{l.yuanjia}}</view>
								<view class="shuliang">x{{l.shuliang}}</view>
							</view>
						</view>
					</view>
				</navigator>	
				<view class="jiesuan">
					<view class="zongji">
						<view class="zj_shuliang">共计{{l.shuliang}}件 </view>
						<view class="zj_jin_e">应付总额：{{l.jin_e}}<text>¥35.00 </text></view>
						<view class="zj_yunfei">(含运费{{l.yunfei}})</view>
					</view>
					<view class="jiesuan_button">
						<navigator url="" v-if="flag==(l.flag==1)" >取消订单</navigator>
						<navigator url="" v-if="flag==(l.flag==1)" >立即付款</navigator>
						<navigator url="" v-if="flag==(l.flag==2)" >确认收货</navigator>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data:{
			props:['shu'];
		}
	}
</script>

<style>
	.items{
		width: 100%;
		box-sizing: border-box;
	}
	.item{}
	.tou{
		width: 100%;
		height: 80upx;
		display: flex;
		padding: 0 30upx;
		border-bottom: 0.1upx solid #f3f3f3;
		align-items: center;
		box-sizing: border-box;
	}
	.dingdanhao{
		width: 50%;
		color: #999999;
		font-size: 24upx;
	}
	.dingdanzhaungtai{
		width: 50%;
		text-align: right;
		font-size: 24upx;
	}
	.wei{box-sizing: border-box;width: 100%;}
	.xiangqing{
		width: 100%;
		box-sizing: border-box;
		display: flex;
		height: 200upx;
		align-items: center;
		border-bottom: 0.1upx solid #f3f3f3;
		padding: 0 30upx;
	}
	.xq_tu{
		width: 30%;
		height: 150upx;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.xq_neirong{
		width: 80%;
		height: 200upx;
	}
	.xq_neirong>view{
		height: 60upx;
		line-height: 60upx;
	}
	.xq_tu>image{
		width: 150upx;
		height: 150upx;
	}
	.xq_guige{
		font-size: 20upx;
		color: #999999;
	}
	.xq_jiage{
		width: 100%;
		display: flex;
	}
	.xianjia{
		width: 25%;
		color: #f3312f;
	}
	.yuanjia{
		width: 15%;
		font-size: 20upx;
		text-decoration: line-through;
		color: #999999;
	}
	.shuliang{
		width: 60%;
		text-align: right;
	}
	.jiesuan{
		width: 100%;
		box-sizing: border-box;
		padding: 0 30upx;
	}
	.zongji{
		display: flex;
		width: 100%;
		height: 80upx;
		align-items: center;
		justify-content: flex-end;
	}
	.zongji>view{
		margin-left: 10upx;
		color: #999999;
		font-size: 25upx;
	}
	.zj_jin_e>text{
		color: #f3312f;
		font-size: 30upx;
	}
</style>
