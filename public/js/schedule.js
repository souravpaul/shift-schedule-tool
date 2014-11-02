Element.prototype.hasClass = function(className) {
    return this.className && new RegExp("(^|\\s)" + className + "(\\s|$)").test(this.className);
};

$(document).ready(function(){
	$('.fc-push-button').click(function(){
		/*$(this).parent().find('.fc-button').removeClass('fc-state-active');
		$(this).addClass('fc-state-active');
		return false;*/
	});
	
	$('.dropdown-menu a').click(function(){
		var obj = JSON.parse($(this).attr('data-member'));
		$(this).parent().parent().parent().find('.data-select').text(obj.FIRST_NAME+' '+obj.LAST_NAME);
		$(this).parent().parent().parent().parent().parent().parent().find('.shift_input').val(obj.MEM_ID);
		$(this).parent().parent().parent().find('a[data-toggle="dropdown"]').click();
		return false;
	});
	
	$('.dropdown a[data-toggle="dropdown"]').click(function(){
		var item=$(this).parent().parent();
		if(!$(item).find('.dropdown-menu').hasClass('show')) {
			$(item).find('.dropdown-menu').addClass('show');
			$(item).find('.dropdown-menu').removeClass('hide');
			$(item).find('i.icon-arrow').addClass('open');
			$(item).find('i.icon-arrow').removeClass('close');
		}
		else {
			$(item).find('.dropdown-menu').removeClass('show');
			$(item).find('i.icon-arrow').removeClass('open');
			$(item).find('i.icon-arrow').addClass('close');
			$(item).find('.dropdown-menu').addClass('hide');
		}
		return false;
	});
});
