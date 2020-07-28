<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Classes</h3>
					<p class="panel-subtitle">Registered Classes</p>
				</div>
				<div class="panel-body">

					<div class="row">
						<a href="register-class" class="btn btn-default pull-right"><i class="fa fa-plus-square"></i> Register </a>
					</div>

					<table class="table table-striped">
						<thead>
							<tr>
								<th>Title</th>
								<th>Description</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if( !empty( $grades ) ) {
								foreach( $grades as $grade ) {
									?>
									<tr>
										<td><?php echo $grade["title"] ?></td>
										<td><?php echo $grade["description"] ?></td>
										<td>
											<a href="<?php echo base_url() ?>grade/edit/<?php echo $grade['id'] ?>" class="edit-record">
												<i class="fa fa-pencil"></i>
											</a>
											<a href="<?php echo base_url() ?>grade/delete/<?php echo $grade['id'] ?>" class="delete-record" onclick="return confirm('Are you sure you want to delete this class?')">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td>There are no classes registered into the system yet!</td>
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
		