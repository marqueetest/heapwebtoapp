<!-- MAIN -->
<div class="main">
	<!-- MAIN CONTENT -->
	<div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Forewords</h3>
					<p class="panel-subtitle"></p>
				</div>
				<div class="panel-body">

					<table class="table table-striped">
						<thead>
							<tr>
								<th>Book ID</th>
								<th>Book Title</th>
								<th>Foreword Added</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if( !empty( $forewords ) ) {
								foreach( $forewords as $foreword ) {
									?>
									<tr>
										<td><?php echo $foreword["book_id"] ?></td>
										<td><?php echo $foreword["book_name"] ?></td>
										<td><?php echo $foreword["foreword2"] ?></td>
										<td>
											<a href="<?php echo base_url() ?>update-foreword/<?php echo $foreword['id'] ?>" class="edit-record">
												<i class="fa fa-pencil"></i>
											</a>
										</td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td colspan="4" align="center">No data found!</td>
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
		