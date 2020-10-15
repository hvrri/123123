<?php
		include("includes/connect.php");

		$cat = $_POST['cat'];
		$cat_get = $_GET['cat'];
		$act = $_POST['act'];
		$act_get = $_GET['act'];
		$id = $_POST['id'];
		$id_get = $_GET['id'];

		
				if($cat == "orders" || $cat_get == "orders"){
					$user_id = mysqli_real_escape_string($link,$_POST["user_id"]);
$product_name = mysqli_real_escape_string($link,$_POST["product_name"]);
$product_price = mysqli_real_escape_string($link,$_POST["product_price"]);
$product_quantity = mysqli_real_escape_string($link,$_POST["product_quantity"]);


				if($act == "add"){
					mysqli_query($link, "INSERT INTO `orders` (  `user_id` , `product_name` , `product_price` , `product_quantity` ) VALUES ( '".$user_id."' , '".$product_name."' , '".$product_price."' , '".$product_quantity."' ) ");
				}elseif ($act == "edit"){
					mysqli_query($link, "UPDATE `orders` SET  `user_id` =  '".$user_id."' , `product_name` =  '".$product_name."' , `product_price` =  '".$product_price."' , `product_quantity` =  '".$product_quantity."'  WHERE `id` = '".$id."' "); 	
					}elseif ($act_get == "delete"){
						mysqli_query($link, "DELETE FROM `orders` WHERE id = '".$id_get."' ");
					}
					header("location:"."orders.php");
				}
				
				if($cat == "producttb" || $cat_get == "producttb"){
					$product_name = mysqli_real_escape_string($link,$_POST["product_name"]);
$product_price = mysqli_real_escape_string($link,$_POST["product_price"]);
$product_image = mysqli_real_escape_string($link,$_POST["product_image"]);


				if($act == "add"){
					mysqli_query($link, "INSERT INTO `producttb` (  `product_name` , `product_price` , `product_image` ) VALUES ( '".$product_name."' , '".$product_price."' , '".$product_image."' ) ");
				}elseif ($act == "edit"){
					mysqli_query($link, "UPDATE `producttb` SET  `product_name` =  '".$product_name."' , `product_price` =  '".$product_price."' , `product_image` =  '".$product_image."'  WHERE `id` = '".$id."' "); 	
					}elseif ($act_get == "delete"){
						mysqli_query($link, "DELETE FROM `producttb` WHERE id = '".$id_get."' ");
					}
					header("location:"."producttb.php");
				}
				
				if($cat == "users" || $cat_get == "users"){
					$username = mysqli_real_escape_string($link,$_POST["username"]);
$password = mysqli_real_escape_string($link,$_POST["password"]);
$email = mysqli_real_escape_string($link,$_POST["email"]);
$join_date = mysqli_real_escape_string($link,$_POST["join_date"]);
$product_name = mysqli_real_escape_string($link,$_POST["product_name"]);
$product_price = mysqli_real_escape_string($link,$_POST["product_price"]);
$product_image = mysqli_real_escape_string($link,$_POST["product_image"]);
$user_type = mysqli_real_escape_string($link,$_POST["user_type"]);


				if($act == "add"){
					mysqli_query($link, "INSERT INTO `users` (  `username` , `password` , `email` , `join_date` , `product_name` , `product_price` , `product_image` , `user_type` ) VALUES ( '".$username."' , '".md5($password)."', '".$email."' , '".$join_date."' , '".$product_name."' , '".$product_price."' , '".$product_image."' , '".$user_type."' ) ");
				}elseif ($act == "edit"){
					mysqli_query($link, "UPDATE `users` SET  `username` =  '".$username."' , `email` =  '".$email."' , `join_date` =  '".$join_date."' , `product_name` =  '".$product_name."' , `product_price` =  '".$product_price."' , `product_image` =  '".$product_image."' , `user_type` =  '".$user_type."'  WHERE `id` = '".$id."' "); 	
					}elseif ($act_get == "delete"){
						mysqli_query($link, "DELETE FROM `users` WHERE id = '".$id_get."' ");
					}
					header("location:"."users.php");
				}
				?>