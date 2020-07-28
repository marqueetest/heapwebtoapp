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
							<h3 class="panel-title pull-left">Saved Reports [<?php echo ucwords( $client["first_name"]." ".$client["last_name"] ) ?>]</h3>
							<a href="<?php echo base_url() ?>report/reportStep1/<?php echo $client['id'] ?>" class="btn btn-primary pull-right"><i class="fa fa-plus-square"></i> Add Report </a>
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

					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Date Created</th>
								<th>Last Updated</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if( !empty( $reports ) ) {
								foreach( $reports as $report ) {
									?>
									<tr>
										<td><?php echo $report["id"] ?></td>
										<td><?php echo $report["report_created_date"] ?></td>
										<td>
											<?php echo $report["report_updated_date"]; ?>
											<?php echo $report["last_term_updated"] != "" ? "(Term ".$report["last_term_updated"].")" : "" ?>
												
										</td>
										<td>
											<div class="row">
												<div class="col-md-6">
													<a href="<?php echo base_url() ?>view-report/<?php echo $client['id']; ?>/<?php echo $report['id']; ?>" class="view-report" title="View Report">
														<i class="fa fa-eye"></i>
													</a>

													<a href="<?php echo base_url() ?>report/delete/<?php echo $client['id'] ?>/<?php echo $report["id"] ?>" class="delete-record" title="Delete Report" onclick="return confirm('Are you sure you want to delete this report?')">
														<i class="fa fa-trash"></i>
													</a>
												</div>

												<div class="col-md-6">
													<?php if( $report["id"] >= 633 ): ?>
			                                            <select name="edit" class="form-control" onChange="MM_jumpMenu('parent',this,0)">
			                                            	<option value="">Edit/Update Term #</option>
			                                            	
		                                            		<?php for($x = $report["current_term"]; $x <= $report["mtg_term_loop"]; $x++): ?>
		                                            			<?php $update_link = base_url()."report/reportStep1/".$client["id"]."/".$report['id']."/".$x; ?>
		                                            			<option value="<?php echo $update_link; ?>">Term <?php echo $x; ?></option>
		                                            		<?php endfor; ?>
			                                            </select>
		                                        	<?php endif; ?> 
	                                        	</div>
                                        	</div>

										</td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td colspan="4" align="center">There are no reports created for this client!</td>
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
<script type="text/javascript">
    function confirmDelete(name)
    {
        if(confirm("Are you sure you want to delete " + name + "?")) return true;
        else return false;
    }
</script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>