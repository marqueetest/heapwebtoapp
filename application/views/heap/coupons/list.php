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
							<h3 class="panel-title pull-left">Coupons</h3>
							<a href="add-coupon" class="btn btn-primary pull-right"><i class="fa fa-plus-square"></i> Add Coupon </a>
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

					<table class="table table-striped" id="table-listing">
						<thead>
							<tr>
								<th>Coupon Code</th>
								<th>Is Active?</th>
								<th>Use Limit</th>
								<th>Total Used</th>
								<th>Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if( !empty( $coupons ) ) {
								foreach( $coupons as $coupon ) {
									?>
									<tr>
										<td><?php echo $coupon["coupon_code"] ?></td>
										<td><?php echo $coupon["is_active"] ?></td>
										<td><?php echo $coupon["used_limit"] ?></td>
										<td><?php echo $coupon["total_use"] ?></td>
										<td><?php echo $coupon["create_date"] ?></td>
										<td>

											<div class="btn-group pull-right">
                                               	<button class="btn btn-primary" type="button">Actions</button>
                                               	<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button"><span class="caret"></span></button>
                                               	<ul role="menu" class="dropdown-menu">

                                               		<li><a href="<?php echo base_url() ?>update-coupon/<?php echo $coupon['id'] ?>" class="edit-record">
														<i class="fa fa-pencil"></i> Edit
													</a></li>
													<li><a href="<?php echo base_url() ?>coupon/delete/<?php echo $coupon['id'] ?>" class="delete-record" onclick="return confirm('Are you sure you want to delete this coupon?')">
														<i class="fa fa-trash"></i> Delete
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
									<td colspan="6" align="center">There are no coupons added for this advisor!</td>
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
		