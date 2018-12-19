import Vue from 'vue'
const $z = {};
//设置域名
$z.yuming='wanhe.zhiwi.cn';	 
$z.url='https://'+$z.yuming+'/app/index.php?d=12';
//#ifdef MP-WEIXIN
$z.shangchuan='https://'+$z.yuming+'/app/index.php?d=12';
//#endif	
//#ifdef APP-PLUS	
$z.shangchuan='http://'+$z.yuming+'/app/index.php?d=12';
	//#endif	

//post请求
 $z.post=function(url,shu,fun){
	  url = $z.url+'&'+url;
		if(typeof(shu)=='function'){
			fun=shu;
			shu={};
		}
		var weizhi=$z.Qu('weizhi');
	
		uni.request({
			url:url, //仅为示例，并非真实接口地址。
			data:shu,
			method:'POST',
			header: {
				'content-type': 'application/x-www-form-urlencoded',	
				//#ifdef MP-WEIXIN
					'app': 'xiaochengxu',
				//#endif	
				//#ifdef APP-PLUS	
				'app': 'app',
				//#endif	
				'kouling':$z.Qu('kouling'),
				'jingdu':weizhi.jingdu, 
				'weidu':weizhi.weidu
			}, 
			success: function (shu) {
				if(shu.data.shi==-1){						
					//#ifdef APP-PLUS	
				
					//#endif	
				 uni.navigateTo({url: '/pages/denglu/denglu'});

				}else{
					fun(shu.data); 
				}
				
			}
		}); 
		
}

$z.toast=function(shu,shi,shijian){
	var s={};	
	if(typeof(shu)=='object'){
		s=shu;
	}else{
		s['title']=''+shu;		
	}
	if(shi==1){
		s['icon']='success';
	}else if(shi==2){
		s['icon']='loading';
	}else{
		s['icon']='none';
	}	
	uni.showToast(s);
}

$z.Cun=function(key,data){	
	return uni.setStorageSync(key,data);
}
$z.Qu=function(key){	
	return uni.getStorageSync(key);
}
$z.Shan=function(key){	
	return uni.removeStorageSync(key);
}
$z.L=function(shu){
	if(typeof(shu)=='object'){
		shu=JSON.stringify(shu);
	}
	console.log(shu);
}

$z.DengLu=function(fun){	
	var that=this;		
	var kouling=$z.Qu('kouling'); 	
	if(kouling){
		return  kouling;
	}
	uni.getProvider({
		service: 'oauth',
		success: function (res) {	
			if (res.provider[0]) {
				uni.login({
					provider: res.provider[0],
					lang:'zh_CN',
					success: function (loginRes) {
						console.log(loginRes);
						if(loginRes.code){
							uni.getUserInfo({
								provider:res.provider[0],
								success: function (info) {									
										$z.post('k=denglu&c=xiaochengxu', {									
											tid:$z.Qu('tid'),
											code: loginRes.code,
											encryptedData: info.encryptedData,
											iv: info.iv,
											signature: info.signature
										}, function (shu) {										
											if (shu.shi == 1) {													
											  $z.Cun('kouling', shu.shu.kouling);
												$z.Cun('id', shu.shu.id);
												return shu.shu.kouling
											} else {
												$z.toast(shu.shu, 0);
											};
										});
								},
								fail:function(info){								
									uni.navigateTo({url: '/pages/denglu/index?code='+loginRes.code});
								}
							});
						}else{						
					  	 $z.toast('登录失败');
						}
						 
					}
				});
			}
		}
	});	
	return ;
}

 $z.dakai=function (url,fangshi){    
      var suo=wx.getStorageSync('suo');
      if (suo == url) {
          return false;
      }
      wx.setStorageSync('suo', url);
      if (fangshi==1){
		     uni.redirectTo({url: url});       
      } else if(fangshi == 2){
          uni.switchTab({url: url});
      }else{
          uni.navigateTo({url: url});
      }      
      setTimeout(function () {
         wx.removeStorageSync('suo');
      }, 500);   
		return false;
  }
 $z.go=function(shu){
   if(!shu){
		 shu=1;
	 }	
	 uni.navigateBack({
			delta: shu
	 });
 }
 
$z.weizhi=function(d){
	  var w=$z.Qu('weizhi');
	  if(!d && w){
			return w;
		}	
		uni.chooseLocation({
			success: function (res) {
				var shu={jingdu:res.longitude,weidu:res.latitude,ming:res.name,dizhi:res.address};		
				$z.Cun('weizhi',shu);
				return shu;
					
			}
	});
} 

$z.BiaoTi=function(BiaoTi,zitiyanse,beijingyanse){
		if(BiaoTi){
				uni.setNavigationBarTitle({
					title: BiaoTi
				});				
		};			
		
		if(zitiyanse && beijingyanse){			
			uni.setNavigationBarColor({
					frontColor: zitiyanse,
					backgroundColor: beijingyanse,
					animation: {
							duration: 400,
							timingFunc: 'easeIn'
					}
			})
		}
}

$z.ShangTu=function(fun,shangliang,laiyuan){	 
	   var sourceType;
		if(!shangliang){shangliang==1}
		if(laiyuan){
		   sourceType=['camera'];
		}else{
			 sourceType=['album','camera'];
		}
	  uni.chooseImage({
	  	count: shangliang,
	  	sizeType: ['original', 'compressed'],
	  	sourceType: sourceType,
	  	success: function (res) {
	  		var tempFilePaths = res.tempFilePaths;			
	  		for(var i in tempFilePaths){	
					uni.showLoading();
	  			uni.uploadFile({
	  				url: $z.shangchuan+'&k=gongyou&x=wenjian&c=upload&leixing=image',
	  				filePath: tempFilePaths[i],
	  				method:'POST',
	  				header: {
	  					'content-type': 'multipart/form-data',	
	  					//#ifdef MP-WEIXIN
	  					'app': 'xiaochengxu',
	  					//#endif	
	  					//#ifdef APP-PLUS	
	  					'app': 'app',
	  					//#endif	
	  					'kouling':$z.Qu('kouling'),									
	  				},
	  				name: 'file',			 				
	  				success: function(uploadFileRes) {
								uni.hideLoading();						
							 fun(JSON.parse(uploadFileRes.data));
	  				}	
					
	  			});
	  				
	  		}
	  	}
	  });
}
$z.ShanChuShuZu=function(shu,i){
		var d=[];
		for(var k in shu){
			if(k!=i){
				d[k]=shu[k];
			}						
		}	
	return d;
}
export default $z
