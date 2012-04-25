jQuery(document).ready(function(){

var tmp = jQuery("#hidden").val();
var tmp1 = jQuery("#id_hid").val();

jQuery('input[name=rest_n]').val(tmp);
jQuery('input[name=id_rest]').val(tmp1);
jQuery(function(){
  jQuery.datepicker.setDefaults(jQuery.datepicker.regional['ru']);
jQuery('input[name=datepicker]').datepicker();
jQuery('input[name=datepicker]').datepicker('option', 'dateFormat', 'dd.mm.yy');

});

});

function load_div(){

if (jQuery("#menu_select option:selected").val() == "antis")
{
jQuery("#load div").css("visibility","hidden");
jQuery("#load #menu_1").css("visibility","visible");

}
if (jQuery("#menu_select  option:selected").val() == "sush")
{

jQuery("#load div").css("visibility","hidden");
jQuery("#load #menu_2").css("visibility","visible");
}
if (jQuery("#menu_select  option:selected").val()== "nap")
{

jQuery("#load div").css("visibility","hidden");
jQuery("#load #menu_3").css("visibility","visible");
}
}
function stat_tab(){alert(" ")}