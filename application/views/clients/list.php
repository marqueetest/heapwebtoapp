<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Clients</h3>
					<p class="panel-subtitle"></p>
				</div>
				<div class="panel-body">

					<div class="row">
						<a href="register-client" class="btn btn-default pull-right"><i class="fa fa-plus-square"></i> Add Clietns </a>
					</div>

					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<!--<th>Username</th>
								<th>Password</th>-->
								<th>Phone</th>
								<th>City</th>
								<th>Zip</th>
								<th>State</th>
								<th>Coupon</th>
								<th>App Access</th>
								<th>Created Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if( !empty( $clients ) ) {
								foreach( $clients as $client ) {
									?>
									<tr>
										<td><?php echo $client["first_name"]." ".$client["last_name"] ?></td>
										<td><?php echo $client["email_address"] ?></td>
										<!--<td><?php //echo $client["username"] ?></td>
										<td><?php //echo $client["password"] ?></td>-->
										<td><?php echo $client["phone"] ?></td>
										<td><?php echo $client["city"] ?></td>
										<td><?php echo $client["zipcode"] ?></td>
										<td><?php echo $client["state"] ?></td>
										<td><?php echo $client["coupon"] ?></td>
										<td><?php echo $client["api_access"] ?></td>
										<td><?php echo $client["created_date"] ?></td>
										<td>
											<a href="<?php echo base_url() ?>client/edit/<?php echo $client['id'] ?>" class="edit-record">
												<i class="fa fa-pencil"></i>
											</a>
											<a href="<?php echo base_url() ?>client/delete/<?php echo $client['id'] ?>" class="delete-record">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td>There are no clients added for this advisor!</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- END OVERVIEW -->

		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->

