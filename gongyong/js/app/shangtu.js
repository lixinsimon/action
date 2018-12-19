(function(window) {
	var shangtu = {};	
	/**
	 * val : image 值;
	 * callback: 回调函数
	 * base64options: base64(json($options))
	 * options: {tabs: {'browser': 'active', 'upload': '', 'remote': ''}
	 **/
	shangtu.image = function(val, callback, base64options, options) {
		var opts = {
			type :'image',
			direct : false,
			multiple : false,
			path : val,
			dest_dir : '',
			global : false,
			thumb : false,
			width : 0
		};

		opts = $.extend({}, opts, options);
		opts.type = 'image';

		require(['jquery', 'fileUploader'], function($, fileUploader){
			fileUploader.show(function(images){
				if(images){
					if($.isFunction(callback)){
						callback(images);
					}
				}
			}, opts);
		});
	}; // end of image	
	if (typeof define === "function" && define.amd) {
		define(['bootstrap'], function(){			
			return shangtu;
		});
	} else {	
		window.shangtu = shangtu;
	}
})(window);