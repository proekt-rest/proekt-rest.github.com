$(document).ready(function(){
$("#list").load("./sources/sushi.html");
 $("#sushi").addClass("current_menu") ;
	  $("#sushi").click(function(){
	   $('li').removeClass("current_menu");
	   $("#list").load("./sources/sushi.html");
	   $("#sushi").addClass("current_menu") ;  
	   });
	   $("#anti").click(function(){
	   $('li').removeClass("current_menu");
	   $("#list").load("./sources/anti.html");
	   $("#anti").addClass("current_menu") ;  
	   });
	   $("#napitki").click(function(){
	   $('li').removeClass("current_menu");
	   $("#list").load("./sources/napitki.html");
	   $("#napitki").addClass("current_menu") ;  
	   });
	   
	   });