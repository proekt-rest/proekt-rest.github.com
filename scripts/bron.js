
google.load('visualization', '1', 
{
    callback:function(){

        var queryText = 'SELECT id,full_name FROM 1_vZ9Pfuodu1Abt7t6wBNBr8IXX7_rKq8frXM864';

        var reqUri = 'http://www.google.com/fusiontables/gvizdata?tq='  + encodeURIComponent(queryText);

        var query = new google.visualization.Query(reqUri);

        query.send(displayData);
    }
});

function displayData(response) {
 
  numRows = response.getDataTable().getNumberOfRows();
  numCols = response.getDataTable().getNumberOfColumns();
  
  
  var tr = table_b.getElementsByTagName('tr');
 text="";
for(i = 0; i < numRows; i++) {

    for(j = 0; j < numCols; j++) {
      text +="<td>" + response.getDataTable().getValue(i, j) + "</td> ";
    }
	tr[i].innerHTML = text;
	text="";
  }
 

  }
 

