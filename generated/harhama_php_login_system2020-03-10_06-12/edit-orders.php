<?php
				include "includes/header.php";
				$data=[];

				$act = $_GET['act'];
				if($act == "edit"){
					$id = $_GET['id'];
					$orders = getById("orders", $id);
				}
				?>

				<form method="post" action="save.php" enctype='multipart/form-data'>
					<fieldset>
						<legend class="hidden-first">Add New Orders</legend>
						<input name="cat" type="hidden" value="orders">
						<input name="id" type="hidden" value="<?=$id?>">
						<input name="act" type="hidden" value="<?=$act?>">
				
							<label>Product name</label>
							<input class="form-control" type="text" name="product_name" value="<?=$orders['product_name']?>" /><br>
							
							<label>Product price</label>
							<input class="form-control" type="text" name="product_price" value="<?=$orders['product_price']?>" /><br>
							
							<label>Product quantity</label>
							<input class="form-control" type="text" name="product_quantity" value="<?=$orders['product_quantity']?>" /><br>
							<br>
					<input type="submit" value=" Save " class="btn btn-success">
					</form>
					<?php include "includes/footer.php";?>
				