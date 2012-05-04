
$(document).ready(function(){
		var temp;
		const curr = "2px -1.5px 1px rgba(0, 0, 0, 0.5)",		// текущая, под курсором
			  lay = "1px -1px rgba(0, 0, 0, 0.5), 0px -3px 1px rgba(0, 0, 0, 0.5) inset",			// лежащая
			  upper = "3px -3px 1px rgba(0, 0, 0, 0.5)";	// выбранная, "верхняя"
		const color_up = "#f5f7cd",
			  color_back = "#daddb3"; 
			  
	  $("#sushi_li").hover(function(){
	   temp = $(this).css("box-shadow");
	   $(this).css({"cursor":"pointer","box-shadow":curr});
	   },function(){
	   $(this).css("box-shadow",temp);
	   });
	   $("#anti_li").hover(function(){
	   temp = $(this).css("box-shadow");
	   $(this).css({"cursor":"pointer","box-shadow":curr});
	   },function(){
	   $(this).css("box-shadow",temp);
	   });
	   $("#napitki_li").hover(function(){
	   temp = $(this).css("box-shadow");
	   $(this).css({"cursor":"pointer","box-shadow":curr});
	   },function(){
	   $(this).css("box-shadow",temp);
	   });
	  
	  $("#sushi_li").click(function(){
	  $('#all_menu').removeClass("cover");
	   $('.menu_navi li').css("box-shadow",lay);
	   $(this).css("box-shadow",upper);
	   temp = $(this).css("box-shadow");
	   $('.menu_navi li').css("background",color_back);
	   $(this).css("background",color_up);
	   $("#all_menu").load("sources/sushi.html"); 
	   $("#all_menu").css("box-shadow",upper);
	   });
	   
	   $("#anti_li").click(function(){
	   $('#all_menu').removeClass("cover");
	   $('.menu_navi li').css("box-shadow",lay);
	   $(this).css("box-shadow",upper);
	   temp = $(this).css("box-shadow");
	   $('.menu_navi li').css("background",color_back);
	   $(this).css("background",color_up);
	   $("#all_menu").load("sources/antisushi.html");
	   $("#all_menu").css("box-shadow",upper);
	   });
	   
	   $("#napitki_li").click(function(){
	   $('#all_menu').removeClass("cover");
	   $('.menu_navi li').css("box-shadow",lay);
	   $(this).css("box-shadow",upper);
	   temp = $(this).css("box-shadow");
	   $('.menu_navi li').css("background",color_back);
	   $(this).css("background",color_up);
	   $("#all_menu").load("sources/napitki.html");
	   $("#all_menu").css("box-shadow",upper);
	   });
	   
	   });
