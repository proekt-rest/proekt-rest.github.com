<?php
$conn=mysql_connect("localhost","root","root");// ������������� 
              // ����������
$database = "restaurant_user";
$table_name = "user_info";
mysql_select_db($database); // �������� ���� ������
$list_f = mysql_list_fields($database,$table_name); 
              // �������� ������ ����� � �������
$n = mysql_num_fields($list_f); // ����� ����� � ���������� 
              // ����������� ������� 
// �������� ���� ������ ����� ��� ���� ����� �������
$sql = "INSERT INTO $table_name SET "; // �������� ��������� 
    // ������, ���������� ��� ���� �������

    $name_f = mysql_field_name ($list_f,1); // ��������� ��� ����

$sql+=$name_f;



// ����� ��� ��� ���������� ���-�� � ����, 
// ����� ����������, ����� ������ ���������
echo $sql; 

?>