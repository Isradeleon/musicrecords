$(document).ready(function(){
	$(".btnremove").click(function(){
		var t=$('meta[name="tok"]').attr('content');
		var albumid=$(this).attr('id');
		$.ajax({
			url:'/deletealbum',
			method:'post',
			data:{
				_token:t,
				album:albumid
			}
		});
		var id = "#tr"+$(this).attr("id");
        $(id).hide(500);
	});
})