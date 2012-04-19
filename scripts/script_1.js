
$(document).ready(function(){
$("#table_b tr").click(function(){
 $("#table_b tr").removeClass("chosen");
 $(this).addClass("chosen");
});
$("#but").click(function(){

$("#content").load("sources/form.html");
});
 

$(function(){
  $.datepicker.setDefaults($.datepicker.regional['ru']);
$('input[name=datepicker]').datepicker();
$('input[name=datepicker]').datepicker('option', 'dateFormat', 'dd.mm.yy');

});

});


