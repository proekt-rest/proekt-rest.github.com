    
 $(document).ready(function(){
$("#content").load("./sources/main-site.html");
 $("#main-site").addClass("current") ;
	  $("#main-site").click(function(){
	   $('li').removeClass("current");
	   $("#content").load("./sources/main-site.html");
	   $("#main-site").addClass("current") ;  
	   });
	   
	  $("#bron_img").click(function(){
	   $('li').removeClass("current");
	 $("#content").load("./sources/bron.html") ; 
 $("#bron_img").addClass("current") ;  	 
	   });
	   
	    $("#zakaz_img").click(function(){
		 $('li').removeClass("current");
	   $("#content").load("./sources/zakaz.html");  
 $("#zakaz_img").addClass("current") ;	   
	   });
	    $("#your_img").click(function(){
		 $('li').removeClass("current");
	   $("#content").load("./sources/your.html"); 
	    $("#your_img").addClass("current") ;
	   });
	    $("#galer_img").click(function(){
		 $('li').removeClass("current");
	   $("#content").load("./sources/galer.html");  
	    $("#galer_img").addClass("current") ;
	   });
	});