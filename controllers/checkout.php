<?php
	include "check.php";
	include "../connect.php";
	$data=$_POST["password"];
	$sql = sprintf("SELECT * FROM `users` WHERE `user_id`='%s'", $_SESSION["user_id"]);
	if($connect->query($sql)->fetch_assoc()["password"] != md5($data))
		echo "Ошибка пароля";
	else{
	$sql = sprintf("SELECT SUM(`count_orders`) FROM `orders` WHERE `user_id`='%s' AND `number` IS NULL", $_SESSION["user_id"]);
	$count = $connect->query($sql)->fetch_array()[0];

	// $connect->query(sprintf("INSERT INTO `orders`(`product_id`, `user_id`, `number`, `count_orders`, `status`) VALUES('0', '%s', '%s', '%s', 'Новый')", $_SESSION["user_id"], rand(1000000000, 2000000000), $count));
	$sql = "INSERT INTO `orders`(`product_id`, `user_id`, `number`, `count_orders`, `status`) VALUES('0', ?, ?, ?, 'Новый')";
	$stmt = $connect ->prepare($sql);
	$stmt->bind_param("iii", $_SESSION["user_id"],rand(1000000000, 2000000000),$count);
	$stmt->execute();
	$stmt->store_result();

	$connect->query(sprintf("DELETE FROM `orders` WHERE `user_id`='%s' AND `number` IS NULL", $_SESSION["user_id"]));
	// echo "Заказ оформлен";
	$sql = "SELECT * FROM `orders` ORDER BY `created_at` DESC LIMIT 1";
	$result=$connect->query($sql);
	$stack=[];
	while($row = $result->fetch_assoc()){
		array_push($stack,json_encode($row));
	}
	print_r(json_encode($stack));
}