<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Students</h3>
					<p class="panel-subtitle">Enrolled Students</p>
				</div>
				<div class="panel-body">

					<div class="row">
						<a href="register-student" class="btn btn-default pull-right"><i class="fa fa-plus-square"></i> Register </a>
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
							if( !empty( $students ) ) {
								foreach( $students as $student ) {
									?>
									<tr>
										<td><?php echo $student["first_name"]." ".$student["last_name"] ?></td>
										<td><?php echo $student["email"] ?></td>
										<td><?php echo $student["contact"] ?></td>
										<td></td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td>There are no students added into the system yet!</td>
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
		