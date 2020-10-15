<?php
		include "includes/header.php";
		?>
		<table class="table table-striped">
		<tr>
		<th class="not">Table</th>
		<th class="not">Entries</th>
		</tr>
		
				<tr>
					<td><a href="orders.php">Orders</a></td>
					<td><?=counting("orders", "id")?></td>
				</tr>
				
				<tr>
					<td><a href="producttb.php">Producttb</a></td>
					<td><?=counting("producttb", "id")?></td>
				</tr>
				
				<tr>
					<td><a href="users.php">Users</a></td>
					<td><?=counting("users", "id")?></td>
				</tr>
				</table>
			<?php include "includes/footer.php";?>
			