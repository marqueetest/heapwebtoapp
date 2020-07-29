<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
		<div class="container-fluid">
			<!-- OVERVIEW -->
			<div class="panel panel-headline">
				<div class="panel-heading">
					<h3 class="panel-title">Dashboard</h3>
					<p class="panel-subtitle"></p>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<div class="metric">
								<a href="<?php echo base_url(). "report/reportStep1/".$this->session->userdata("client_id") ?>">
									<span class="icon"><i class="fa fa-user"></i></span>
									<p>
										<span class="number">Create Report</span>
										<!-- <span class="title">Heaplan Clients</span> -->
									</p>
								</a>
							</div>
						</div>
						<div class="col-md-4">
							<div class="metric">
							<a href="<?php echo base_url(). "report/listReports/".$this->session->userdata("client_id") ?>">
									<span class="icon"><i class="fa fa-user"></i></span>
									<p>
										<span class="number">View Report</span>
										<!-- <span class="title">Retirement Kit Clients</span> -->
									</p>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END OVERVIEW -->
		</div>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->

