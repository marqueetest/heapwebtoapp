<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Courses</h3>
					<p class="panel-subtitle">Enrolled Courses</p>
				</div>
				<div class="panel-body">

					<div class="row">
						<a href="register-course" class="btn btn-default pull-right"><i class="fa fa-plus-square"></i> Register </a>
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
							if( !empty( $courses ) ) {
								foreach( $courses as $course ) {
									?>
									<tr>
										<td><?php echo $course["first_name"]." ".$course["last_name"] ?></td>
										<td><?php echo $course["email"] ?></td>
										<td><?php echo $course["contact"] ?></td>
										<td></td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td>There are no courses added into the system yet!</td>
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
		