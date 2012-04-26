<?php
$conn=mysql_connect("localhost","root","root");// устанавливаем 
              // соединение
$database = "restaurant_user";
$table_name = "user_info";
mysql_select_db($database); // выбираем базу данных
$list_f = mysql_list_fields($database,$table_name); 
              // получаем список полей в таблице
$n = mysql_num_fields($list_f); // число строк в результате 
              // предыдущего запроса 
// составим один запрос сразу для всех полей таблицы
$sql = "INSERT INTO $table_name SET "; // начинаем создавать 
    // запрос, перебираем все поля таблицы

    $name_f = mysql_field_name ($list_f,1); // вычисляем имя поля

$sql+=$name_f;



// перед тем как записывать что-то в базу, 
// можно посмотреть, какой запрос получился
echo $sql; 

?>