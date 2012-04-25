function stat_tab(){

date = $.trim($('input[name=datepicker]').val());
time1 = $.trim($('input[name=time_from]').val());
time2 = $.trim($('input[name=time_to]').val());

if (date&&time1&&time2)
{

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
else alert("Выберите, пожалуйста, дату и время для проверки статуса столика!") 

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
	
        if(date==$('input[name=datepicker]').val())
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
				  isok = 1;}
                      
                      }
               if(dd[0]==time_from_h[0]||(dd[0]>time_from_h[0])&&(dd[0]<time_to_h[0])) 
               {
            
                   
                  if(dd[1]>time_from_h[1])
                  {alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
				   
				   $("#status_div").css('background-color','red');
				   isok = 1;}
                      
                      if(dd[1]<time_to_h[1])
                         {alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
						 isok = 1;
						  $("#status_div").css('background-color','red');}
               }
             
        
                      if((dd[0]<time_from_h[0])&&((dd_t[0]<time_to_h[0])||(dd_t[0]>time_to_h[0])||(dd_t[0]==time_to_h[0])))
					  {
                      if(dd_t[0]>time_from_h[0]){alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
					 isok = 1;
					  $("#status_div").css('background-color','red');}
                      if((dd_t[0]==time_from_h[0])&&(dd_t[1]>time_from_h[1])){alert("Столик занят с: "+time_from+" до "+time_to+". Пожалуйста, выберите другое время!")
					    isok = 1;
						$("#status_div").css('background-color','red');}
                      }
					else if(isok==0)
					{$("#status_div").css('background-color','green')
					alert("Столик свободен!")}
    
                      }  
					 
					  }
					   if(isok2==0) {$("#status_div").css('background-color','green');
					 alert("Столик свободен!")}
    
    }
  else   {$("#status_div").css('background-color','green');
  alert("Столик свободен!")}
  }