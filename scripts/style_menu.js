$(document).ready(function(){
	  $("#sushi").click(function(){
	   $('li').removeClass("current_menu");
	   $("#all_menu").load("sources/sushi.html");
	   $("#sushi").addClass("current_menu") ;  
	   });
	   $("#anti").click(function(){
	   $('li').removeClass("current_menu");
	   $("#all_menu").load("sources/antisushi.html");
	   $("#anti").addClass("current_menu") ;  
	   });
	   $("#napitki").click(function(){
	   $('li').removeClass("current_menu");
	   $("#all_menu").load("sources/napitki.html");
	   $("#napitki").addClass("current_menu") ;  
	   });
	   
	   });