<?php
				include "includes/header.php";
				?>

				<a class="btn btn-primary" href="edit-orders.php?act=add"> <i class="glyphicon glyphicon-plus-sign"></i> Add New Orders</a>

				<h1>Orders</h1>
				<p>This table includes <?php echo counting("orders", "id");?> orders.</p>

				<table id="sorted" class="table table-striped table-bordered">
				<thead>
				<tr>
							<th>User id</th>
			<th>Product name</th>
			<th>Product price</th>
			<th>Product quantity</th>

				<th class="not">Edit</th>
				<th class="not">Delete</th>
				</tr>
				</thead>

				<?php
				$orders = getAll("orders");
				if($orders) foreach ($orders as $orderss):
					?>
					<tr>
		<td><?php echo $orderss['user_id']?></td>
		<td><?php echo $orderss['product_name']?></td>
		<td><?php echo $orderss['product_price']?></td>
		<td><?php echo $orderss['product_quantity']?></td>


						<td><a href="edit-orders.php?act=edit&id=<?php echo $orderss['id']?>"><i class="glyphicon glyphicon-edit"></i></a></td>
						<td><a href="save.php?act=delete&id=<?php echo $orderss['id']?>&cat=orders" onclick="return navConfirm(this.href);"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>
					<?php endforeach; ?>
					</table>
					<?php include "includes/footer.php";?>
				