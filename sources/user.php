<?php
include ('Zend/Gdata/ClientLogin.php');
include ('Zend_Gdata_Fusion.php');
header('Content-Type: text/html; charset=UTF-8');
function translitIt($str) 
{
    $tr = array(
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
        "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
    );
    return strtr($str,$tr);
}
$conn=mysql_connect("localhost","root","root");// устанавливаем 
              // соединение




$database = "restaurant_user";
$table_name = "user_info";
$table_name2 = "user_order";
mysql_select_db($database); // выбираем базу данных

$list_f = mysql_list_fields($database,$table_name); 
$list_f2 = mysql_list_fields($database,$table_name2); 

$n1 = mysql_num_fields($list_f);
$n2 = mysql_num_fields($list_f2);
for($j=0;$j<$n1; $j++){
    $names[] = mysql_field_name ($list_f,$j);
}
for($j=0;$j<$n2; $j++){
    $names2[] = mysql_field_name ($list_f2,$j);
}
$sql_tmp = "SELECT id FROM $table_name"; 

$q = mysql_query($sql_tmp); 
     
$n = mysql_num_rows($q); 

 for($i=0;$i<$n; $i++){
 
 foreach($names as $val){
 $value_tmp= mysql_result($q,$n-1,$val);
 $id [] =  $value_tmp;
 
 
 }
}
$sql2 = "INSERT INTO $table_name2 SET ";
$id_id = $id[0]+1;

$sql_tmp1 = "SELECT email FROM $table_name"; 

$q1 = mysql_query($sql_tmp1); 
     
$nn = mysql_num_rows($q1); 
$isTrue = 0;
 for($i=0;$i<$nn; $i++){
 
 foreach($names as $val){
 $value_tmp1= mysql_result($q1,$i,$val);

 if ($_REQUEST[$names[5]]==$value_tmp1)
 { 
 
 $isTrue = 1;
 

 } 

 } 
 
  } 
 



  if($isTrue==0)
  {
 
   $sql = "INSERT INTO $table_name SET "; 
   $sql = $sql.$names[0]." = $id_id, ";
   $value = translitIt($_REQUEST[$names[1]]);
   
 
   $sql = $sql.$names[1]."  = '$value',  ";
   $value = translitIt($_REQUEST[$names[2]]);
   $sql = $sql.$names[2]."  = '$value',  ";
   $value = translitIt($_REQUEST[$names[3]]);
   $sql = $sql.$names[3]."  = '$value',  ";
   $value = $_REQUEST[$names[4]];
   $sql = $sql.$names[4]." = $value, ";
   $value = $_REQUEST[$names[5]];
   $sql = $sql.$names[5]." = '$value' , ";
   $sql = $sql.$names[6]." = "."''";
    $result = mysql_query($sql,$conn)or die("Невозможно установить 
        соединение: ". mysql_error());
   $sql2 =$sql2.$names2[0]." = $id_id, ";
   
$value1 = $_REQUEST[$names2[1]];

$sql2 =$sql2.$names2[1]." = $value1, ";
$value1 = translitIt($_REQUEST[$names2[2]]);
$sql2 = $sql2.$names2[2]."  = '$value1',  ";

$value1 = $_REQUEST['select_table'];
$sql2 = $sql2.$names2[3]."  = '$value1',  ";
$value1 = $_REQUEST[$names2[4]];
$sql2 = $sql2.$names2[4]." = '$value1', ";
$value1 = $_REQUEST[$names2[5]];
$sql2 = $sql2.$names2[5]." = '$value1', ";
$value1 = $_REQUEST[$names2[6]];
$sql2 = $sql2.$names2[6]." = '$value1', ";
$value1 = $_REQUEST['number_pers'];
$sql2 = $sql2.$names2[7]." = $value1, ";
$value1 = $_REQUEST['zal'];
if($value1=='yes'){
$sql2 = $sql2.$names2[8]." = 1, ";
}
else $sql2 = $sql2.$names2[8]." = 0, ";
$value_1 = "";

foreach($_REQUEST['checkbox'] as $box) {
	$value_1=$value_1.$box.', ';	
}
foreach($_REQUEST['checkbox_1'] as $box) {
	$value_1=$value_1.$box.', ';	
}
foreach($_REQUEST['checkbox_2'] as $box) {
	$value_1=$value_1.$box.', ';	
}
$value_1=substr_replace($value_1,"",-2);
$value_1 = translitIt($value_1);

$sql2 = $sql2.$names2[9]." = '$value_1' ";
$result1 = mysql_query($sql2,$conn)or die("Невозможно установить 
        соединение c 2: ". mysql_error());
		 echo "Здравствуйте, ".$_REQUEST['first_name']."!<br>";
if ($result&&$result1){ echo " Бронирование успешно выполнено. <br>"; 
echo "Ждем Вас ".$_REQUEST['date']." в кафе \"Япоша\", расположенное по адресу: ".$_REQUEST['address_rest']." в ".$_REQUEST['time_from'];
}
    else echo " Произошла какая-то ошибка :( <br>"; 
   
	
}
else {$sql_sql= "SELECT id FROM $table_name WHERE email = '".$_REQUEST[$names[5]]."'"; 

$qq= mysql_query($sql_sql); 
     
 $value = mysql_result($qq,0);
 $sql2 =$sql2.$names2[0]." = $value, ";
 

$value1 = $_REQUEST[$names2[1]];
$sql2 =$sql2.$names2[1]." = $value1, ";
$value1 = translitIt($_REQUEST[$names2[2]]);
$sql2 = $sql2.$names2[2]."  = '$value1',  ";
$value1 = $_REQUEST['select_table'];
$sql2 = $sql2.$names2[3]."  = '$value1',  ";
$value1 = $_REQUEST[$names2[4]];
$sql2 = $sql2.$names2[4]." = '$value1', ";
$value1 = $_REQUEST[$names2[5]];
$sql2 = $sql2.$names2[5]." = '$value1', ";
$value1 = $_REQUEST[$names2[6]];
$sql2 = $sql2.$names2[6]." = '$value1', ";
$value1 = $_REQUEST['number_pers'];
$sql2 = $sql2.$names2[7]." = $value1, ";
$value1 = $_REQUEST['zal'];
if($value1=='yes'){
$sql2 = $sql2.$names2[8]." = 1, ";
}
else $sql2 = $sql2.$names2[8]." = 0, ";
$value_1 = "";

foreach($_REQUEST['checkbox'] as $box) {
	$value_1=$value_1.$box.', ';	
}
foreach($_REQUEST['checkbox_1'] as $box) {
	$value_1=$value_1.$box.', ';	
}
foreach($_REQUEST['checkbox_2'] as $box) {
	$value_1=$value_1.$box.', ';	
}
$value_1=substr_replace($value_1,"",-2);
$value_1 = translitIt($value_1);

$sql2 = $sql2.$names2[9]." = '$value_1' ";

       
$result1 = mysql_query($sql2,$conn)or die("Невозможно установить 
        соединение c 2: ". mysql_error());; // отправляем запрос 
// выводим сообщение успешно ли выполнен запрос
echo "Здравствуйте, ".$_REQUEST['first_name']."!<br>";
if ($result1){ echo " Бронирование успешно выполнено. <br>"; 
echo "Ждем Вас ".$_REQUEST['date']." в кафе \"Япоша\", расположенное по адресу: ".$_REQUEST['address_rest']." в ".$_REQUEST['time_from']."<br>";
}
    else echo " Произошла какая-то ошибка :( <br>"; 
	}
$client = Zend_Gdata_ClientLogin::getHttpClient('olesja.a92@gmail.com', '25807110', 'fusiontables');
//создание экземпляра класса
$base = new Zend_Gdata_Fusion($client);


$n = $_REQUEST['id_rest'];
$tab = $_REQUEST['select_table'];
$dat = $_REQUEST['date'];
$time_1 = $_REQUEST['time_from'];
$time_2 = $_REQUEST['time_to'];
$sql = "SELECT ROWID FROM 1K5n5nrdiUUMGE5SDBtDcuFgJfKkGLG-rFSrOhgg WHERE id_rest =".$n." AND table_id = '".$tab."' AND status = 0;";
$rowdata =  $base->query($sql)->get_array();
//вставка строк - согласно API необходимо перечислить все столбцы таблицы
$newRowId = $base->insertRow('1K5n5nrdiUUMGE5SDBtDcuFgJfKkGLG-rFSrOhgg',array(
    'id_rest' =>$n ,
    'table_id' => $tab,
    'date' => $dat,
	'time_from' => $time_1,
	'time_to' => $time_2,
	'status' => 1,
) );
$base->updateRow(
    '1K5n5nrdiUUMGE5SDBtDcuFgJfKkGLG-rFSrOhgg', //ID таблицы
    array('status' => 1), //ассоциативный массив значений
    $rowdata[1][0] //ROWID полученный в запросе на выборку
);
 if ($newRowId){
 echo "<br>Ваш столик: ".$_REQUEST['select_table'];
 }
?>