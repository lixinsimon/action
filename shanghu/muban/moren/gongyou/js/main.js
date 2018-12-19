
$(function(){	
	$('.menu .nav').on('click', 'li:not(.nav-parent) > a', function(){
	    var $this = $(this);
	    $('.menu .nav .active').removeClass('active');
	    $this.closest('li').addClass('active');
	    $this.closest('.nav-parent').addClass('active');
	    $('.weizhi').html($this.parent().parent().parent().find('span').eq(0).text());	    
	    $('.weizhi1').html($this.html());	    
	});	
	
	
	

	
	
});
