<?php

$conn = mysql_connect("localhost","root","");
mysql_select_db("student2");

if(!$conn)
{
 die("cant connect".mysql_connect_error());
}

?>
