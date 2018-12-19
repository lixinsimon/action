<template>
	<view>
		<view class="gouwu_tou">
			<image src="../../../static/tu/完成.png" mode="" style="width: 30upx; height: 30upx;"></image>
			<view class="bianji">编辑</view>
		</view>
		
		<view class="gouwu_liebiao">
			<view class="liebiao_checkbox">
				<input type="checkbox" value="" class="checkbox" />
			</view>
			<view class="liebiao_tu">
				<image src="../../../static/tu/待发货.png" mode=""></image>
			</view>
			<view class="liebiao_xiangqing">
				<view class="xiangqing_title">翻滚吧散热二哥而给我</view>
				<view class="xiangqing_kucun">库存：<text>89</text>件</view>
				<view class="xiangqing_jiage"><text>¥ 138.00</text>
					<view class="jia_jian">
						<text class="shu_jian daxiao">-</text>
						<input type="number" value="1"  class="shuliang"/>
						<text class="shu_jia daxiao">+</text>
					</view>
				</view>
			</view>
		</view>
		<view class="gouwu_wei">
			<input type="checkbox" value="" class="checkbox_all" id="all" />
			<label class="quanxuan" for="all">全选</label>
			<view class="zongji">总价:¥<text class="zongjia_shu">138</text></view>
			<navigator  class="shanchu">删除</navigator>
		</view>
	</view>
</template>

<script>
	import $z from '@/zhiwi';
	export default {
		
	}
</script>

<style>
.gouwu_tou{
		width: 100%;
		height: 80upx;
		text-align: right;
		line-height: 80upx;
		border-bottom: 1upx solid #f3f3f3;
	}
.bianji{
		display: inline-block;
		color: #000000;
		width: 100upx;
		text-align: center;
	}
.gouwu_liebiao{
		width: 100%;
		height: 200upx;
		display:flex;
		flex-direction: row;
		padding: 20upx 30upx;
	}
.gouwu_liebiao>view{display: inline-block;}
.liebiao_checkbox{ 
	position: relative;
	width: 60upx;
}
.checkbox{
	margin-top: 55upx;
}
.checkbox_all{
	margin-left: 30upx;
}
.liebiao_tu>image{
	margin-left: 10upx;
	width: 170upx;
	height: 170upx;
}
.liebiao_xiangqing{
	width: 100%;
	height: 200upx;
}
.xiangqing_title{
	width: 100%;
	height: 75upx;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}
	.xiangqing_kucun{
		width: 200upx;
		height: 55upx;}
	.xiangqing_jiage{
		width: 100%;
		height: 70upx;
	}
	.xiangqing_jiage>text{
		color: red;
		font-size: 35upx;
	}
	.jia_jian{
		float: right;
		margin-right: 40upx;
		width: 160upx;
		height: 50upx;
		}
	.shuliang{
		display: inline-block;
		width: 50upx;
		height: 55upx;
		text-align: center;
		box-sizing: border-box;
		border-top:1upx solid #EEEEEE ;
		border-bottom:1upx solid #EEEEEE ;
		vertical-align:top;
	}
	.daxiao{
		width: 55upx;
		height: 55upx;
		background-color: #EEEEEE;
		font-size: 40upx;
		text-align: center;
		display: inline-block;
	}
	
	.gouwu_wei{
		position: fixed;
		bottom: 0upx;
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: center;
		width: 100%;
		height: 100upx;
	}
	.quanxuan{
		width: 25%;
		height: 100upx;
		line-height: 100upx;
		text-align: center;
	}
	.zongji{
		width: 50%;
		color: #f3312f;
		font-size: 35upx;
		text-align: center;
		height: 100upx;
		line-height: 100upx;
	}
	.shanchu{
		width: 25%;
		background-color: #000000;
		color:#FFFFFF;
		text-align: center;
		margin: 0 auto;
		height: 100upx;
		line-height: 100upx;
	}

</style>
