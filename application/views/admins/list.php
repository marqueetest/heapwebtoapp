<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Admins</h3>
					<p class="panel-subtitle"></p>
				</div>
				<div class="panel-body">

					<div class="row">
						<a href="register-admin" class="btn btn-default pull-right"><i class="fa fa-plus-square"></i> Register </a>
					</div>

					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Contact#</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if( !empty( $admins ) ) {
								foreach( $admins as $admin ) {
									?>
									<tr>
										<td><?php echo $admin["first_name"]." ".$admin["last_name"] ?></td>
										<td><?php echo $admin["email"] ?></td>
										<td><?php echo $admin["contact"] ?></td>
										<td>
											<a href="<?php echo base_url() ?>user/edit/<?php echo $admin['id'] ?>" class="edit-record">
												<i class="fa fa-pencil"></i>
											</a>
											<a href="<?php echo base_url() ?>user/delete/<?php echo $admin['id'] ?>" class="delete-record">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td>There are no admins added into the system yet!</td>
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
		