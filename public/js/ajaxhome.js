$(document).ready(function(){
	var t = $("meta[name='tok']").attr('content');
	var pathname = document.location.pathname;
	$.ajax({
		url:"/ajaxhome",
		method:"post",
		data:{_token:t, path:pathname}
	}).done(function(response){
		if (response.getout) {
			document.location.href="/login";
		}else{
			$("#bodyContent").prepend(response);
		}
	});
});