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

      $(".btnquit").click(function(){
         var fav = $(this).attr("id");
         var tok = $("meta[name='tok']").attr('content');
         $.ajax({
            url:"/quitfavorite",
            method:"post",
            data:{
               favorite: fav,
               _token: tok 
            }
         }).done(function(res){console.log(res);});

         var id = "#tr"+$(this).attr("id");
         $(id).hide(500);
      });
});