jQuery(document).ready(function(){

var tmp = jQuery("#hidden").val();
var tmp1 = jQuery("#id_hid").val();

jQuery('input[name=address_rest]').val(tmp);
jQuery('input[name=rest_n]').val(tmp);
jQuery('input[name=id_rest]').val(tmp1);
jQuery(function(){

  jQuery.datepicker.setDefaults(jQuery.datepicker.regional['ru']);
jQuery('input[name=date]').datepicker();
jQuery('input[name=date]').datepicker('option', 'dateFormat', 'dd.mm.yy');
jQuery('input[name=date]').datepicker('option', 'minDate', '0');
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
function getHexRGBColor(color)
{
  color = color.replace(/\s/g,"");
  var aRGB = color.match(/^rgb\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)jQuery/i);
  if(aRGB)
  {
    color = '';
    for (var i=1;  i<=3; i++) color += Math.round((aRGB[i][aRGB[i].length-1]=="%"?2.55:1)*parseInt(aRGB[i])).toString(16).replace(/^(.)jQuery/,'0jQuery1');
  }
  else color = color.replace(/^#?([\da-f])([\da-f])([\da-f])jQuery/i, 'jQuery1jQuery1jQuery2jQuery2jQuery3jQuery3');
  return color;
}

function submit_but(){


var adr=user_form.email.value;
var f_n=user_form.first_name.value;
var l_n=user_form.last_name.value;
var time_f=user_form.time_from.value;
var time_t=user_form.time_to.value;
var numb = user_form.number_pers.value;
var ph= user_form.phone.value;
  var adr_pattern=/[0-9a-z_]+@[0-9a-z_]+\.[a-z]{2,5}/i ;
 var f_pattern=/[а-яa-z]+/i;
 var l_pattern=/[[а-яa-z]+/i;
 var t_pattern = /[1-2][0-9]\:[0-5][0-9]/;
 var n_pattern = /[0-9]+/;
 var ph_pattern = /[0-9]{1,10}/;
 var prov = true;
 var prov5 = true;
 prov=adr_pattern.test(adr);
  var prov1=f_pattern.test(f_n);
  var prov2=l_pattern.test(l_n);
  var prov3=t_pattern.test(time_f);
    var prov4=t_pattern.test(time_t);
	 var prov6=n_pattern.test(numb);
    var prov7=ph_pattern.test(ph);
 if(prov==true)
 {
 
 jQuery("#email_div").css('color','green');
 email_div.innerHTML = "Верно!";
 }
      else {	
	   jQuery("#email_div").css('color','red');
	  email_div.innerHTML = "Некорректный e-mail адрес (Пример адреса: user@gmail.com)";}
  
  if (prov1==true){
  
  jQuery("#first_div").css('color','green');
 first_div.innerHTML = "Верно!";
  }
  else{    jQuery("#first_div").css('color','red');
       first_div.innerHTML = "Некорректное имя или поле пустое";
  }
  
  if (prov2==true){
  
  jQuery("#last_div").css('color','green');
 last_div.innerHTML = "Верно!";
  
  } 
  else{ jQuery("#last_div").css('color','red');
        last_div.innerHTML = "Некорректная фамилия или поле пустое";
  }
  if (prov6==true){
  
  jQuery("#number_div").css('color','green');
 number_div.innerHTML = "Верно!";
  
  } 
  else{ jQuery("#number_div").css('color','red');
        number_div.innerHTML = "Некорректная информация";
  }
  if (prov7==true){
  
  jQuery("#phone_div").css('color','green');
 phone_div.innerHTML = "Верно!";
  
  } 
  else{ jQuery("#phone_div").css('color','red');
        phone_div.innerHTML = "Некорректная информация, введите номер мобильного без 8 (пример: 9811234567)";
  }
  if (prov3==true&&prov4==true) {
  
  jQuery("#time_div").css('color','green');
 time_div.innerHTML = "Верно!";
  
  
  }
  else{ jQuery("#time_div").css('color','red');
        time_div.innerHTML = "Время введено неверно или поле пустое (используйте знак разделения \":\")";
  }
  var RBG = jQuery("#status_div").css('background-color');
  var tmp = getHexRGBColor(RBG);
 if (tmp=='ff0000')
 {
 prov5 = false;
 jQuery("#table_div").css('color','red');
  table_div.innerHTML = "Столик занят, либо не выбран!";
 }
 else
 {
 jQuery("#table_div").css('color','green');
 table_div.innerHTML = "Выбранный столик свободен!";
 }
 if(prov&&prov1&&prov2&&prov3&&prov4&&prov5&&prov6&&prov7)
 {
  jQuery("#content").load("sources/wait.html");
 jQuery("#content").load("sources/user.php",jQuery("#user_form_id").serialize());
     
 }
}