<?php

$localhost="localhost";
$username="root";
$db_name="notetaking";
$password="";

$connect= new mysqli($localhost,$username,$password,$db_name);
if($connect->error){
    die( "An error occurred while connecting".$connect->error);
}


?>
