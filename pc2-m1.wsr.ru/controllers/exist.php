<?php
require '../connect.php';
$sql = "SELECT * FROM `users` WHERE `login` = ? AND `password` = ?";
$stmt = $connect ->prepare($sql);
$stmt->bind_param("ss", $_POST['elements']['login'],md5($_POST['elements']['password']));
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo $stmt->num_rows;
    
}
else{
    echo 'none';
}