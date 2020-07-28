<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Teachers</h3>
					<p class="panel-subtitle">Enrolled Teachers</p>
				</div>
				<div class="panel-body">

					<div class="row">
						<a href="register-teacher" class="btn btn-default pull-right"><i class="fa fa-plus-square"></i> Register </a>
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
							if( !empty( $teachers ) ) {
								foreach( $teachers as $teacher ) {
									?>
									<tr>
										<td><?php echo $teacher["first_name"]." ".$teacher["last_name"] ?></td>
										<td><?php echo $teacher["email"] ?></td>
										<td><?php echo $teacher["contact"] ?></td>
										<td></td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td>There are no teachers added into the system yet!</td>
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
		