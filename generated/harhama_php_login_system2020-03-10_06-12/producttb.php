<?php
				include "includes/header.php";
				?>

				<a class="btn btn-primary" href="edit-producttb.php?act=add"> <i class="glyphicon glyphicon-plus-sign"></i> Add New Producttb</a>

				<h1>Producttb</h1>
				<p>This table includes <?php echo counting("producttb", "id");?> producttb.</p>

				<table id="sorted" class="table table-striped table-bordered">
				<thead>
				<tr>
							<th>Id</th>
			<th>Product name</th>
			<th>Product price</th>
			<th>Product image</th>

				<th class="not">Edit</th>
				<th class="not">Delete</th>
				</tr>
				</thead>

				<?php
				$producttb = getAll("producttb");
				if($producttb) foreach ($producttb as $producttbs):
					?>
					<tr>
		<td><?php echo $producttbs['id']?></td>
		<td><?php echo $producttbs['product_name']?></td>
		<td><?php echo $producttbs['product_price']?></td>
		<td><?php echo $producttbs['product_image']?></td>


						<td><a href="edit-producttb.php?act=edit&id=<?php echo $producttbs['id']?>"><i class="glyphicon glyphicon-edit"></i></a></td>
						<td><a href="save.php?act=delete&id=<?php echo $producttbs['id']?>&cat=producttb" onclick="return navConfirm(this.href);"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>
					<?php endforeach; ?>
					</table>
					<?php include "includes/footer.php";?>
				