    	<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; <?php echo date('Y') ?> Heaplan. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-multiselect.min.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="<?php echo base_url() ?>assets/scripts/common.js"></script>

	<script src="<?php echo base_url() ?>assets/tinymce/tinymce.min.js"></script>

	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

	<script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
	<script type="text/javascript">
		var file_name =  Math.round(+new Date()/1000);
		file_name = 'download-'+file_name;
		console.log(file_name);
		$(document).ready(function() {
	    	$('#table-listing').DataTable({
	    		/*"bFilter"    : true,
				"bSort"      : true,
				"ordering"   : false,
                "bLengthChange": false,
				"pageLength" :25,
				"pagingType": "simple",*/
				bLengthChange: false,
				ordering: false,
				dom: 'Blfrtip',
				/*buttons: [
		            'csv', 'excel', 'pdf', 'print'
		        ],*/
				buttons: [
		           	{
					   	extend:'csv',
					   	text:'CSV <i class="fa fa-download"></i>',
					   	filename : file_name,
					   	exportOptions: {
							columns: "thead th:not(.noExport)"
						}
					},
				   	{
					  	extend:'excel',
					   	text:'Excel <i class="icon-download-alt"></i>',
					   	filename: file_name,
					   	exportOptions: {
							columns: "thead th:not(.noExport)"
						}
					},
				    {
					   	extend:'pdf',
					   	text:'PDF <i class="icon-download-alt"></i>',
					   	orientation: 'landscape',
                       	pageSize: 'LEGAL',
					   	footer: true,
					   	filename : file_name,
					   	exportOptions: {
							columns: "thead th:not(.noExport)"
						}
				    },
				    {
						extend:'print',
						text:'Print <i class="icon-print"></i>',
						filename: file_name,
						exportOptions: {
							columns: "thead th:not(.noExport)"
						}
				    }
				],
			    /*language: {
					lengthMenu: "<span class='left_port'>Display</span><span>_MENU_</span><span class='right_port'>records per page</span>",
					zeroRecords: "Now record found",
					info: "Showing page <span style='color:#ff6c60;font-weight:bold;'>_PAGE_</span> of total <span style='color:#ff6c60;font-weight:bold;'>_PAGES_ </span> pages",
					infoEmpty: "Now record found",
					infoFiltered: "(filtered from _MAX_ total records)",
					oPaginate: {
						"sNext": '<i class="icon-chevron-right"></i>',
						"sPrevious": '<i class="icon-chevron-left"></i>'
					}
                },*/
				/*responsive: {
					details: {
						//display: $.fn.DataTable.Responsive.display.childRowImmediate
						display: $.fn.DataTable.Responsive.display.modal( {
							header: function ( row ) {
								var data = row.data();
								return 'Details for '+data[0]+' '+data[1];
							}
						}),
						renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
							tableClass: 'table'
						})
					}
                },
                columnDefs: [ {
		            className: 'control',
		            orderable: false,
		            targets:   -1
		        } ]*/
	    	});
		});
	</script>

	<?php
	if( isset($books_permission) ) {
		?>
		<script>
	    $(document).ready(function(e) {
			var book_permission = "<?php echo $books_permission; ?>";
			var formtext = document.getElementById("formtext");

			formtext.onselect=function(){
			  if(book_permission==1){
				  var session = sessionStorage.getItem("selected_book");
				  if(session=="true"){
					formtext.select();  
				  }else{
				    alert("Please choose atleast one book");
				  }
			  }else{
				  formtext.select();
			  }
			}

		 	$('#custom_book_select').multiselect({
	     		buttonWidth: '500px',
	     		buttonText: function (options) {
	         		if (options.length == 0) {
	             		return 'Choose books';
	         		} else {
	             		var selected = 0;
	             		options.each(function () {
	                 		selected += 1;
	             		});
	             		return selected +  ' books Selected';
	         		}
	     		},onChange: function(element, checked) {
			 		sessionStorage.setItem("selected_book","true");
		 		}
	    	});
		});
		</script>
		<?php
	}
	?>

</body>

</html>
