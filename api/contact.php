<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$sql = "INSERT INTO user (first_name, last_name, email, subject, message) VALUES ('".$firstName."', '".$lastName."', '".$email."', '".$subject."', '".$message."') ";
mysqli_query($link, $sql);

$headers="From:" . $email;

mail($admin_email, $subject, $message, $headers);

echo json_encode(array('status' => 'success', 'message' => 'Email has been sent successfully'));

mysqli_close($link);
?>