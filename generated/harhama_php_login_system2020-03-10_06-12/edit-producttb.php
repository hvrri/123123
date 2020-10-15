<?php
				include "includes/header.php";
				$data=[];

				$act = $_GET['act'];
				if($act == "edit"){
					$id = $_GET['id'];
					$producttb = getById("producttb", $id);
				}
				?>

				<form method="post" action="save.php" enctype='multipart/form-data'>
					<fieldset>
						<legend class="hidden-first">Add New Producttb</legend>
						<input name="cat" type="hidden" value="producttb">
						<input name="id" type="hidden" value="<?=$id?>">
						<input name="act" type="hidden" value="<?=$act?>">
				
							<label>Product name</label>
							<input class="form-control" type="text" name="product_name" value="<?=$producttb['product_name']?>" /><br>
							
							<label>Product price</label>
							<input class="form-control" type="text" name="product_price" value="<?=$producttb['product_price']?>" /><br>
							
							<label>Product image</label>
							<input class="form-control" type="text" name="product_image" value="<?=$producttb['product_image']?>" /><br>
							<br>
					<input type="submit" value=" Save " class="btn btn-success">
					</form>
					<?php include "includes/footer.php";?>
				