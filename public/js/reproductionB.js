window.onload = carga;

function carga(){
	for (var i = 0; i < document.getElementsByTagName("audio").length; i++) {
		var au = document.getElementsByTagName("audio")[i];
		au.addEventListener("timeupdate", function(){

			$("input[type='range'][name='"+this.id+"']").attr("min",0);
			$("input[type='range'][name='"+this.id+"']").attr("max",this.duration);
			$("input[type='range'][name='"+this.id+"']").val(this.currentTime);

			if (this.currentTime == this.duration) {
				$("span[name='"+this.id+"']").attr("class", "glyphicon glyphicon-play play");
			}
		});
		
		$("input[type='range'][name='"+au.id+"']").change(function(){
			var idde = "#"+this.name;
			$(this).attr("min", 0);
			$(this).attr("max", $(idde).prop("duration"));
			$(idde).prop("currentTime",this.value);
		});
	}
}