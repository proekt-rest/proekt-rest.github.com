/*
 * 	JA Modal 1.01 - jQuery plugin
 *	written by Alexey Tayanchin	
 *	http://redspirit.ru/busy/ja-modal-jquery-plugin.html
 *
 *	Copyright (c) 2011 Alexey Tayanchin (http://redspirit.ru)
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */

var this_ja_modal;
var is_modal_show = false;

jQuery.fn.show_jamodal = function(w,h,content){

	var thismod = jQuery(this);
	var msiewid=0, msiehe=0, msieph=0;
	
	$(window).scroll(function(){
		if(is_modal_show && $.browser.msie){
			thismod.css({'margin-left': -Math.round(thismod.width()/2)+document.body.scrollLeft+'px', 'margin-top': -Math.round(thismod.height()/2)+document.body.scrollTop+'px'});
		}
	});
	
	thismod.addClass("jamodal");
	thismod.css({'left':'50%', 'top':'50%', 'z-index':9999, 'padding':0, 'outline':0});
	if($.browser.msie) {thismod.css('position','absolute'); msiehe=document.body.scrollTop; msiewid=document.body.scrollLeft; msieph=document.compatMode != 'CSS1Compat' ? document.body.scrollHeight : document.documentElement.scrollHeight; } else { thismod.css('position','fixed'); msieph=document.documentElement.clientHeight; }
	if(typeof w!='undefined') thismod.width(w);
	if(typeof h!='undefined') thismod.height(h);
	thismod.css('margin-left',-Math.round(thismod.width()/2)+msiewid+'px');
	thismod.css('margin-top',-Math.round(thismod.height()/2)+msiehe+'px');
	if(typeof content!='undefined') {
		thismod.html(content);
		jQuery('.jamodal-close').bind('click',close_jamodal);
	}
	thismod.css('display','block');
	is_modal_show = true;

	thismod.after('<div class="jamodal-block"></div>');
	jQuery('.jamodal-block').css({'position':'fixed', 'z-index':9998,'margin':0,'padding':0, 'left':0, 'top':0,'width':'100%','height':msieph+'px','background-color':'#CCCCCC', 'opacity':'0.5'});
	
	jQuery('.jamodal-close').click(close_jamodal);

	this_ja_modal = this;
	return this;
};

function close_jamodal(){
	jQuery('.jamodal-block').detach();
	jQuery(this_ja_modal).css('display','none');
	is_modal_show = false;
	return this_ja_modal;
}
