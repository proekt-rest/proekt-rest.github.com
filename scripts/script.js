    
 jQuery(document).ready(function(){
jQuery("#content").load("sources/main-site.html");
 jQuery("#main-site_li").addClass("current") ;
	  jQuery("#main-site_li").click(function(){
	   jQuery('li').removeClass("current");
	   jQuery("#content").load("sources/main-site.html");
	   jQuery("#main-site_li").addClass("current") ;  
	   });
	   
	  jQuery("#bron_li").click(function(){
	   jQuery('li').removeClass("current");
	 jQuery("#content").load("sources/bron.html") ; 
 jQuery("#bron_li").addClass("current") ;  	 
	   });
	   
	   jQuery("#zakaz_li").click(function(){
		 jQuery('li').removeClass("current");
	   jQuery("#content").load("sources/zakaz.html");  
 jQuery("#zakaz_li").addClass("current") ;	   
	   });
	    
	    jQuery("#menu_li").click(function(){
		 jQuery('li').removeClass("current");
	   jQuery("#content").load("sources/menu.html");  
	    jQuery("#menu_li").addClass("current") ;
	   });
	    jQuery("#galer_li").click(function(){
		 jQuery('li').removeClass("current");
	   jQuery("#content").load("sources/galer.html");  
	    jQuery("#galer_li").addClass("current") ;
	   });
	});