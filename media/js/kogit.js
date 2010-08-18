$(document).ready(function(){
	
	// syntax highlight
	$("pre ol li").hover(function(){
		$(this).css({ background: '#ffffcc' });
	}, function(){
		$(this).css({ background: '' });
	});
	
});