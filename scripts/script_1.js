
jQuery(document).ready(function(){
var rest, id_rest;

jQuery("#but").click(function(){

if (rest==undefined){
alert("Пожалуйста, выберите ресторан!")
}
else
{jQuery("#content").load("sources/form.html");
jQuery("#hidden").val(rest);
jQuery("#id_hid").val(id_rest);

}

 
});
jQuery("#table_b tr").click(function(){

 jQuery("#table_b tr").removeClass("chosen");
 
 jQuery(this).addClass("chosen");
 rest = this.getElementsByTagName('td')[1].innerHTML;
 id_rest = this.getElementsByTagName('td')[0].innerHTML;
 jQuery("#id_hid").val(id_rest);
});

});
 



