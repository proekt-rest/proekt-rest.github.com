    
 $(document).ready(function(){
$("#content").load("./sources/main-site.html");
 $("#main-site").addClass("current") ;
	  $("#main-site").click(function(){
	   $('li').removeClass("current");
	   $("#content").load("./sources/main-site.html");
	   $("#main-site").addClass("current") ;  
	   });
	   
	  $("#bron_id").click(function(){
	   $('li').removeClass("current");
	 $("#content").load("./sources/bron.html") ; 
 $("#bron_id").addClass("current") ;  	 
	   });
	   
	    $("#zakaz_id").click(function(){
		 $('li').removeClass("current");
	   $("#content").load("./sources/zakaz.html");  
 $("#zakaz_id").addClass("current") ;	   
	   });
	    $("#your_id").click(function(){
		 $('li').removeClass("current");
	   $("#content").load("./sources/your.html"); 
	    $("#your_id").addClass("current") ;
	   });
	    $("#menu_id").click(function(){
		 $('li').removeClass("current");
	   $("#content").load("./sources/menu.html");  
	    $("#menu_id").addClass("current") ;
	   });
	    $("#galer_id").click(function(){
		 $('li').removeClass("current");
	   $("#content").load("./sources/galer.html");  
	    $("#galer_id").addClass("current") ;
	   });
	});