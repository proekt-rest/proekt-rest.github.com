$(document).ready(function(){
$("#list").load("./sources/sushi.html");
 $("#sushi").addClass("current") ;
	  $("#sushi").click(function(){
	   $('li').removeClass("current");
	   $("#list").load("./sources/sushi.html");
	   $("#sushi").addClass("current") ;  
	   });
	   $("#anti").click(function(){
	   $('li').removeClass("current");
	   $("#list").load("./sources/anti.html");
	   $("#anti").addClass("current") ;  
	   });
	   $("#napitki").click(function(){
	   $('li').removeClass("current");
	   $("#list").load("./sources/napitki.html");
	   $("#napitki").addClass("current") ;  
	   });
	   
	   });