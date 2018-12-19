


/* @商城
 * QQ:1599076351
 */
(function(window) {
	var z = {};
	var jiazai={}	
	    jiazai.mei=true;
	z.post = function(url, data, fun, type) {
		if($.isFunction(data)) {
			fun = data;
			data = {};
		}
		$z.dendai();
		if(!type) {
			type = 'json';
		}
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: type,
			success: function(msg) {
				$z.gb_dendai();
				fun(msg);
			}
		});
	}
	z.toast=function(text,shijian){	
		if(!shijian){			
			shijian=1000;
		}
		if(!text){
			text='正在执行..';
		}
		var dialog = window.YDUI.dialog;
	    dialog.toast(text, 'none', shijian);
	};
	z.go=function(val){
		if(!val){
			val=-1;
		}
		window.history.go(val);
	}
	z.dakai=function(href,xin){
		if(xin){
			window.open(href);
		}else{
			window.location.href=href;
		}	
	}
	z.log=function(v){
		console.log(v);
	}
	z.jiazai=function(e,func,init){		
		if(typeof(e)=='function'){
			init = func;
			func = e;
		}
		   z.jiazai_chushihua=func;
		  if(init){		      	
		  	 func();
		  }		
		  var yanshi=true;
		  $(window).scroll(function() {		  	
		      if ($(this).scrollTop() + $(window).height() + 20 >= $(document).height() && $(this).scrollTop() > 20 && jiazai.mei && yanshi) { 
		         	yanshi=false;
		            func();
		            setTimeout(function(){
		            	yanshi=true;
		            },500);
		      }  
		  }); 
	}
	z.form_val=function(shu){
		  if(!shu){
				  return false;
			}
      var input=$(shu).find('input');
			var s={};
		  for(i in input){
			    var val=	$(shu).find('input').eq(i).val();
				  var name=	$(shu).find('input').eq(i).attr('name');
				   s[name]=val;
			}
		  var select=$(shu).find('select');
			for(i in input){
 				 var val=	$(shu).find('select').eq(i).val();
 				 var name=	$(shu).find('select').eq(i).attr('name');
 					s[name]=val;
 		 }
		 return s;
	}
	z.jiazai_mei=function(v){
		jiazai.mei=v;
	}	
	var dengdai_zhi;
	var d_div;
	/*等待*/
	z.dendai=function() {
		dengdai_zhi=true;
		setTimeout(function(){
			if(dengdai_zhi && !d_div){		
				var rootElement = document.body;
				var newElement1 = document.createElement("div");
				var newElement = document.createElement("div");
				newElement1.id="dengdai1"
				newElement.id = "dengdai";
			
				var dia1 = document.createElement("div");
				var dia2 = document.createElement("div");
				var dia3 = document.createElement("div");
				dia1.classList.add("yuan0", "yuan1");
				dia2.classList.add("yuan0", "yuan2");
				dia3.classList.add("yuan0", "yuan3");
			
				newElement.appendChild(dia1);
				newElement.appendChild(dia2);
				newElement.appendChild(dia3);
				
				newElement1.appendChild(newElement);
				rootElement.appendChild(newElement1);	
				d_div=true;
			}
			
		},500);
		
	}
	
	z.gb_dendai=function() {
		 dengdai_zhi=false;
		 if(d_div){	 			   
	    	var yichu = document.getElementById("dengdai1");
		    document.body.removeChild(yichu);
		    d_div=false;			
		}		
	}	
	z.FenXiang=function(shu,fun){
		if(!shu){
			shu={};
		}
		wx.ready(function () {
	    	wx.checkJsApi({
	            jsApiList: [
	                'getLocation',
	                'onMenuShareTimeline',
	                'onMenuShareAppMessage'
	            ],
	            success: function (res) {
	               // alert(JSON.stringify(res));
	            }
	        });
	        if(!shu.tubiao){
	        	shu.tubiao=$('img:first').attr('src');
	        }	      
	        wx.onMenuShareAppMessage({
	          title: shu.ming,
	          desc: shu.miaoshu,
	          link: shu.url,
	          imgUrl: shu.tubiao,
	          type: shu.type, // 分享类型,music、video或link，不填默认为link  
              dataUrl: shu.dataUrl, // 如果type是music或video，则要提供数据链接，默认为空  
	          trigger: function (res) {
	              fun(res);
	          },
	          success: function (res) {          	
	              fun(res);
	          },
	          cancel: function (res) {
	              fun(res);
	          },
	          fail: function (res) {
	              fun(res);
	          }
	        });

       		wx.onMenuShareTimeline({
	          title: shu.ming,
	          link: shu.url,
	          imgUrl: shu.tubiao,
	          trigger: function (res) {
	              fun(res);
	          },
	          success: function (res) {
	              fun(res);
	          },
	          cancel: function (res) {
	              fun(res);
	          },
	          fail: function (res) {
	             fun(res);
	          }
	        });        
        
         });
	}
	
	z.getQueryString=function (name) { 
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
        var r = window.location.search.substr(1).match(reg); 
        if (r != null) return unescape(r[2]); 
        return null; 
    } 
    z.ShangWenJian=function(){    	
        var ShangChuan = WebUploader.create({
				fileNumLimit: 1,//上传数量限制
			    fileSizeLimit: 80000000,//限制上传所有文件大小
			    fileSingleSizeLimit: 80000000,//限制上传单个文件大小
				server:'./index.php?k=gongyou&x=wenjian&c=upload&leixing=wenjian&d='+z.getQueryString('d'),
				pick:'.ShangWenJian',
				resize:false,
				auto:true,
				chunked: true,	
				formData: {guid: WebUploader.Base.guid()},
				accept:{
					title: "Wenjian",
					extensions: 'xls,rar,doc,pdf',
					mineTypes: '*'
				}
			});	
			 var T;  
		    $('.ShangWenJian').click(function(){
		    	 T=this;		    	
		    	 ShangChuan.reset();
		    })
			ShangChuan.on("error", function (type) {
				   var msg='';
			     if(type=='Q_TYPE_DENIED'){
			     	 msg='上传文件类型错误';
			     }else if (type == "Q_EXCEED_SIZE_LIMIT") {
			       	msg='文件大小不能超过2M';           
	        }else {
	        		msg="上传出错！请检查后重新上传！错误代码"+type;
	           
	        }
	    
		     $(T).parent().before('<div style="color: red;position: absolute;left: 0px;top: -18px;z-index: 999;">'+msg+'</div>');
		     setTimeout(function(){
		     	   $(T).parent().prev().remove();
		     },2000);
			});
	
	
	    ShangChuan.on('uploadStart', function(file){    	
				 var div='<div id="jindu'+file.source.ruid+'" style="background: red;position: absolute;left: 0px;top: 0px;z-index: 999;width: 0%;height: 2px;"></div>';
				 $('#rt_'+file.source.ruid).parent().before(div);	
			});
			ShangChuan.onUploadProgress= function(file, percentage){
				 $('#jindu'+file.source.ruid).css('width',percentage*100+'%');		
		
			};
			ShangChuan.on('uploadSuccess', function(file, resp){	
				 $('#rt_'+file.source.ruid).parent().parent().prevAll('.img_url').attr('src',resp.url).val(resp.url);	
				// $('#rt_'+file.source.ruid).parent().prevAll('.audio-player-play').show();
			});
		  ShangChuan.on('uploadComplete',function(file){
		  	  $('#jindu'+file.source.ruid).remove();		
		  })
    	
    }
    z.ShangShiPin=function(){    	
        var ShangChuan = WebUploader.create({
				fileNumLimit: 1,//上传数量限制
			    fileSizeLimit: 80000000,//限制上传所有文件大小
			    fileSingleSizeLimit: 80000000,//限制上传单个文件大小
				server:'./index.php?k=gongyou&x=wenjian&c=upload&leixing=audio&d='+z.getQueryString('d'),
				pick:'.ShangShiPin',
				resize:false,
				auto:true,
				chunked: true,	
				formData: {guid: WebUploader.Base.guid()},
				accept:{
					title: "Audios",
					extensions: 'mp3,wma,wav,amr,flv,avi,rmvb,mp4,mpg,mpeg',
					mineTypes: 'audio/*'
				}
			});	
			 var T;  
		    $('.ShangShiPin').click(function(){
		    	 T=this;		    	
		    	 ShangChuan.reset();
		    })
			ShangChuan.on("error", function (type) {
				   var msg='';
			     if(type=='Q_TYPE_DENIED'){
			     	 msg='上传文件类型错误';
			     }else if (type == "Q_EXCEED_SIZE_LIMIT") {
			       	msg='文件大小不能超过2M';           
	        }else {
	        		msg="上传出错！请检查后重新上传！错误代码"+type;
	           
	        }
	    
		     $(T).parent().before('<div style="color: red;position: absolute;left: 0px;top: -18px;z-index: 999;">'+msg+'</div>');
		     setTimeout(function(){
		     	   $(T).parent().prev().remove();
		     },2000);
			});
	
	
	    ShangChuan.on('uploadStart', function(file){    	
				 var div='<div id="jindu'+file.source.ruid+'" style="background: red;position: absolute;left: 0px;top: 0px;z-index: 999;width: 0%;height: 2px;"></div>';
				 $('#rt_'+file.source.ruid).parent().before(div);	
			});
			ShangChuan.onUploadProgress= function(file, percentage){
				 $('#jindu'+file.source.ruid).css('width',percentage*100+'%');		
		
			};
			ShangChuan.on('uploadSuccess', function(file, resp){	
				 $('#rt_'+file.source.ruid).parent().parent().prevAll('.img_url').attr('src',resp.url).val(resp.url);	
				// $('#rt_'+file.source.ruid).parent().prevAll('.audio-player-play').show();
			});
		  ShangChuan.on('uploadComplete',function(file){
		  	  $('#jindu'+file.source.ruid).remove();		
		  })
    	
    }
    z.ShangTu=function(){    	
            var Tu = WebUploader.create({
				fileNumLimit: 5,//上传数量限制
			    fileSizeLimit: 80000000,//限制上传所有文件大小
			    fileSingleSizeLimit: 80000000,//限制上传单个文件大小
				server:'./index.php?k=gongyou&x=wenjian&c=upload&leixing=image&d='+z.getQueryString('d'),
				pick:'.ShangTu',
				resize:false,
				auto:true,
				chunked: false,	
				formData: {guid: WebUploader.Base.guid()},
				accept: {
		            title: 'Images',
		            extensions: 'gif,jpg,jpeg,bmp,png',
		            mimeTypes: 'image/*'
		        }
			});	
			var ST;	
		    $('.ShangTu').click(function(){
		    	 ST=this;		    
		    	 Tu.reset();
		    })
			Tu.on("error", function (type) {
				var msg='';
			     if(type=='Q_TYPE_DENIED'){
			     	 msg='上传文件类型错误';
			     }else if (type == "Q_EXCEED_SIZE_LIMIT") {
			       	msg='文件大小不能超过2M';           
		        }else {
		        		msg="上传出错！请检查后重新上传！错误代码"+type;
		           
		        }
	    
			     $(ST).before('<div style="color: red;position: absolute;left: 0px;top: -18px;z-index: 999;">'+msg+'</div>');
			     setTimeout(function(){
			     	   $(ST).prev().remove();
			     },2000);
			});
	
	
	        Tu.on('uploadStart', function(file){    	
				 var div='<div id="jindu'+file.source.ruid+'" style="background: red;position: absolute;left: 0px;top: 0px;z-index: 999;width: 0%;height: 2px;"></div>';
				 $('#rt_'+file.source.ruid).parent().before(div);	
			});
			Tu.onUploadProgress= function(file, percentage){
				 $('#jindu'+file.source.ruid).css('width',percentage*100+'%');		
		
			};
			Tu.on('uploadSuccess', function(file, resp){	
				 $(ST).parent().parent().find('.img_url').attr('src',resp.url).val(resp.url);	
			});
		  Tu.on('uploadComplete',function(file){
		  	  $('#jindu'+file.source.ruid).remove();		
		  })
    	
    }
    z.ShanChuTu=function(e){
    	$(e).parents('.shangtu_zujian').find(".st_img").val("").attr("src","../gongyong/images/nopic.jpg");
    }
	window.$z = z;
	
	
})(window);

