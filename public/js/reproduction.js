$(document).ready(function(){
	$(".play").click(function(){
		var id = $(this).attr("name");
		var rangee = $("input[type='range'][name = '"+id+"']");

		if (!document.getElementById(id).paused) {
			document.getElementById(id).pause();
			$(this).attr("class", "glyphicon glyphicon-play play");
			rangee.attr("disabled", false);
		} else {
			document.getElementById(id).play();
			$(this).attr("class", "glyphicon glyphicon-pause play");
			rangee.attr("disabled", true);
		}
	});

   	$(".btnadd").click(function(){
    	var song = $(this).attr("id");
      	var user = $("#iduser").val();
      	var tok = $("meta[name='tok']").attr('content');
      	$.ajax({
      		url:"/addfavorite",
      		method:"post",
      		data:{
      			user: user,
      			song: song,
      			_token: tok 
      		}
      	});

      	$(this).slideUp(500, function(){
      		var cucu = $("<span style='font-size: 16px; margin-top: 8px;' class='glyphicon glyphicon-star'></span>").hide();
      		$(this).parent().append(cucu);
      		cucu.slideDown(500);
      	});
   	});
});