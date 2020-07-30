<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">

					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title pull-left">Clients</h3>
							<a href="register-client" class="btn btn-primary pull-right"><i class="fa fa-plus-square"></i> Add Client</a>
						</div>
					</div>

				</div>
				<div class="panel-body">

					<?php
					if( $this->session->flashdata("success") ) {
						?>
						<div class="alert alert-success">
							<?php echo $this->session->flashdata("success") ?>
						</div>
						<?php
					}
					?>

					<table class="table table-striped responsive" id="table-listing">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Username</th>
								<th>Password</th>
								<th>Phone</th>
								<th>City</th>
								<th>Zip</th>
								<th>State</th>
								<!--<th class="col-md-1">Coupon</th>
								<th>App Access</th>-->
								<th>Created Date</th>
								<th data-priority="1" class="noExport" style="text-align: right;">Actions</th>
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
										<td><?php echo $client["username"] ?></td>
										<td><?php echo $client["plain_password"] ?></td>
										<td><?php echo $client["phone"] ?></td>
										<td><?php echo $client["city"] ?></td>
										<td><?php echo $client["zipcode"] ?></td>
										<td><?php echo $client["state"] ?></td>
										<!--<td class="col-md-1"><?php //echo $client["coupon"] ?></td>
										<td><?php //echo $client["api_access"] ?></td>-->
										<td><?php echo $client["created_date"] ?></td>
										<td>

											<div class="btn-group pull-right">
                                               <button class="btn btn-primary" type="button">Actions</button>
                                               <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button"><span class="caret"></span></button>
                                               	<ul role="menu" class="dropdown-menu">

                                               		<li><a href="<?php echo base_url() ?>report/reportStep1/<?php echo $client['id'] ?>" class="create-report">
														<i class="fa fa-plus"></i> Create Report
													</a></li>
													<li><a href="<?php echo base_url() ?>list-reports/<?php echo $client["id"] ?>" class="list-report">
														<i class="fa fa-eye"></i> View Reports
													</a></li>
													<li><a href="<?php echo base_url() ?>heap-update-client/<?php echo $client["id"] ?>" class="edit-record">
														<i class="fa fa-pencil"></i> Edit Client
													</a></li>
													<li><a href="<?php echo base_url() ?>client/delete/<?php echo $client['id'] ?>" class="delete-record" onclick="return confirm('Are you sure you want to delete this client?')">
														<i class="fa fa-trash"></i> Delete Client
													</a></li>

                                               	</ul>
                                            </div>

										</td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td colspan="7" align="center">There are no clients added for this advisor!</td>
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

