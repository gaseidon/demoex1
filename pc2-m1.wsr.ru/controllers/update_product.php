<?php
	include "check_admin.php";
	include "../connect.php";


	if($_FILES["image"]["error"])
		$path = $_POST["path"];
	else {
		$path = "images/upload/1_". time() ."_". $_FILES["image"]["name"];
		$imageFileType = strtolower(pathinfo($path, PATHINFO_EXTENSION));
		if($_FILES["image"]["size"] < 5242880 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")){
		move_uploaded_file($_FILES["image"]["tmp_name"], "../".$path);
		}
		else{
			return header("Location:../admin?message=Неверный формат файла или размер больше 5 мб");
		}
	}

	$connect->query(sprintf("UPDATE `products` SET `name`='%s', `price`='%s', `country`='%s', `year`='%s', `model`='%s', `category`='%s', `count_products`='%s', `path`='%s' WHERE `product_id`='%s'", $_POST["name"], $_POST["price"], $_POST["country"], $_POST["year"], $_POST["model"], $_POST["category"], $_POST["count_products"], $path, $_POST["id"]));

	return header("Location:../product.php?id=".$_POST["id"]."&message=Товар изменён");
