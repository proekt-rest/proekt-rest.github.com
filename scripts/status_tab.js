function stat_tab(){

date = $.trim($('input[name=date]').val());
time1 = $.trim($('input[name=time_from]').val());
time2 = $.trim($('input[name=time_to]').val());
var time_f=$('input[name=time_from]').val();
var time_t=$('input[name=time_to]').val();
var t_pattern = /[1-2][0-9]\:[0-5][0-9]/;
 var prov3=t_pattern.test(time_f);
  var prov4=t_pattern.test(time_t);
 
 if (date&&time1&&time2&&prov3&&prov4)
{
$("#time_div").css('color','green');
time_div.innerHTML = "Верно!";
 google.load('visualization', '1', 
{
  callback:function(){
  var queryText = 'SELECT status, date, time_from, time_to  FROM 1K5n5nrdiUUMGE5SDBtDcuFgJfKkGLG-rFSrOhgg WHERE id_rest='+$('input[name=id_rest]').val()+' AND table_id =\''+$("#select_table  option:selected").val()+'\'';
  
  var reqUri = 'http://www.google.com/fusiontables/gvizdata?tq='  + encodeURIComponent(queryText);
  var query = new google.visualization.Query(reqUri);
  query.send(displayData);
    }
});


}
if(prov3==false||prov4==false)
{
        $("#time_div").css('color','red');
        time_div.innerHTML = "Время введено неверно или поле пустое (используйте знак разделения \":\")";
}

else if (!date||!time1||!time2)
{
if(prov3==true&&prov4==true)
{
$("#time_div").css('color','green');
time_div.innerHTML = "Верно!";
}
alert("Выберите, пожалуйста, дату и время для проверки статуса столика!") 

}

}
function displayData(response) {
 
 numRows = response.getDataTable().getNumberOfRows();
  numCols = response.getDataTable().getNumberOfColumns();
  
 
 
     status_t = response.getDataTable().getValue(0, 0) ;
    if (status_t==1)
    {
        
        var isok = 0, isok2=0;
        for(i = 0; i < numRows; i++) {
           
     date = response.getDataTable().getValue(i, 1);
	
        if(date==$('input[name=date]').val())
        {
              isok2=1;
               time_to = response.getDataTable().getValue(i, 3);
            time_from = response.getDataTable().getValue(i, 2);
 
                d = $('input[name=time_from]').val();
            d_t=$('input[name=time_to]').val();
            var dd = d.split(':'); 
           var dd_t= d_t.split(':');  
            var time_from_h = time_from.split(':');
            var time_to_h = time_to.split(':');
            if (dd[0]==time_to_h[0])
            { if(dd[1]<time_to_h[1])
                  {alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!");
				  $("#status_div").css('background-color','red');
				  isok = 1;
				   table_div.innerHTML = "Занято!";}
                      
                      }
               if(dd[0]==time_from_h[0]||(dd[0]>time_from_h[0])&&(dd[0]<time_to_h[0])) 
               {
            
                  
                  if((dd[1]>time_from_h[1])||(dd[1]==time_from_h[1]))
                  {alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
				   
				   $("#status_div").css('background-color','red');
				   isok = 1;
				    table_div.innerHTML = "Занято!";}
                      
                      if(dd[1]<time_to_h[1])
                         {alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
						 isok = 1;
						  $("#status_div").css('background-color','red');
						   table_div.innerHTML = "Занято!";}
               }
             
        
                      if((dd[0]<time_from_h[0])&&((dd_t[0]<time_to_h[0])||(dd_t[0]>time_to_h[0])||(dd_t[0]==time_to_h[0])))
					  {
                      if(dd_t[0]>time_from_h[0]){alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
					 isok = 1;
					  $("#status_div").css('background-color','red');
					   table_div.innerHTML = "Занято!";}
                      if((dd_t[0]==time_from_h[0])&&(dd_t[1]>time_from_h[1])){alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
					    isok = 1;
						$("#status_div").css('background-color','red');
						 table_div.innerHTML = "Занято!";}
                      }
					else if(isok==0)
					{$("#status_div").css('background-color','green')
					alert("Столик свободен!")
					$("#table_div").css('color','green');
 table_div.innerHTML = "Выбранный столик свободен!";}
    
                      }  
					 
					  }
					   if(isok2==0) {$("#status_div").css('background-color','green');
					 alert("Столик свободен!")
					 $("#table_div").css('color','green');
 table_div.innerHTML = "Выбранный столик свободен!";}
    
    }
  else   {$("#status_div").css('background-color','green');
  alert("Столик свободен!")
  $("#table_div").css('color','green');
 table_div.innerHTML = "Выбранный столик свободен!";}
  }