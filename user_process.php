<?php 
session_start();
require 'connect.php';
$customer_id = $_SESSION['customer_id'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$password = $_POST['password'];
$sql = "update customers
set
name = '$name',
gender = '$gender',
dob = '$dob',
password = '$password'
where
id = '$customer_id'";
$_SESSION['customer_name'] = $name;
$result = mysqli_query($connect,$sql);
$sql = "select * from customers where id = '$customer_id'";
$result = mysqli_query($connect,$sql);
$info = mysqli_fetch_array($result);
echo json_encode($info);
exit();
?>