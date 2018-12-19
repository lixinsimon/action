<template>
	<view>
		<form action="">
			<view class="page">
				<input type="text" value="" placeholder="请输入新密码" class="xinmima"/>
				<input type="text" value="" placeholder="再次确认密码" class="qurenxinmima"/>
				<navigator url="" class="quren">确认</navigator>
			</view>
			
		</form>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			};
		}
	}
</script>

<style>
	.page{
		width: 100%;
		box-sizing: border-box;
		padding: 0upx 30upx;
		border-top: #f3f3f3;
		border-bottom: #f3f3f3;
	}
	input{
		display: inline-block;
		width: 100%;
		height: 120upx;
	}
	.qurenxinmima{
		border-top: #f3f3f3;
	}
	.quren{
		border-radius: 10upx;
		color: #FFFFFF;
		background-color: #000000;
		font-size: 35upx;
		text-align: center;
		width: 100%;
		padding: 0upx 30upx;
		box-sizing: border-box;
		display: inline-block;
		height: 100upx;
		line-height: 100upx;
	}
</style>
