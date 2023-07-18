<?php
$servername="localhost";
$username="root";
$password="";
$database="newforum";
$conn= mysqli_connect($servername, $username,$password,$database);
if(!$conn){
    echo "connecton was unsuccessful";
}
?>