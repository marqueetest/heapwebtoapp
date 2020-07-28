<style type="text/css">
	.fa-times {
		color: red;
	}
	.fa-check {
		color: green;
	}
</style>
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

					<?php
					if( $this->session->flashdata("error") ) {
						?>
						<div class="alert alert-danger">
							<?php echo $this->session->flashdata("error") ?>
						</div>
						<?php
					}

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
								<th>Email</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Status</th>
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
										<td><?php echo $client["username"] ?></td>
										<td><?php echo $client["first"]." ".$client["last"] ?></td>
										<td><?php echo $client["phone"] ?></td>
										<td align="center">
											<?php
											if( $client["disabled"] == 1) {
												$status = 0;
												$class = "fa fa-times";
											} else {
												$status = 1;
												$class = "fa fa-check";
											}
											?>
											<a href="<?php echo base_url() ?>client/rkClientChangeStatus/<?php echo $client['userid'] ?>/<?php echo $status?>">
												<i class="<?php echo $class ?>"></i>
											</a>
										</td>
										<td><?php echo $client["created_date"] ?></td>
										<td>
											<div class="btn-group pull-right">
                                               <button class="btn btn-primary" type="button">Actions</button>
                                               <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button"><span class="caret"></span></button>
                                               	<ul role="menu" class="dropdown-menu">
                                                  
													<li><a href="<?php echo base_url() ?>retirement-kit-update-client/<?php echo $client["userid"] ?>" class="edit-record">
														<i class="fa fa-pencil"></i> Edit Client
													</a></li>
													<li><a href="<?php echo base_url() ?>client/rkDeleteClient/<?php echo $client['userid'] ?>" class="delete-record" onclick="return confirm('Are you sure you want to delete this client?')">
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
									<td colspan="6" align="center">There are no clients added for this advisor!</td>
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
		