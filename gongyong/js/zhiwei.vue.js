
/* @商城
 * QQ:1599076351
 */
(function(window) {
	var z = {};
	z.post = function(url, data, fun, type) {
		if(z.isFunction(data)) {
			fun = data;
			data = {};
		}		
		if(!type) {
			type = 'json';
		}
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: type,
			success: function(msg) {			
				fun(msg);
			}
		});

	}
	 z.isFunction=function(val) {
        return typeof val === 'function';
    }

    z.isObject=function (obj) {
	    return obj !== null && typeof obj === 'object';
	 }	
	z.toString=function(obj){
		if(z.isObject(obj)){
			return JSON.stringify(obj);
		}
		return false;
	}
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
	window.$z = z;	
})(window);


