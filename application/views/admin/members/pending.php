<?php //echo html::script("assets/js/jquery-1.9.1.min.js");?>
<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<?php echo html::script("assets/js/additional-methods.js");?>
<?php echo html::script("assets/bootstrap/js/bootstrap.min.js");?>
<!-- Le styles -->
<?php echo html::stylesheet("assets/bootstrap/css/bootstrap.css");?>   
 
<?php echo html::script("assets/js/jquery.dataTables.js");?>
<?php echo html::script("assets/js/dt_bootstrap.js");?>
<?php echo html::stylesheet("assets/css/dt_bootstrap.css");?>
<script type="text/javascript">
$(document).ready(function(){

	$(".docs").live('click', (function () {
		var id = $(this).attr('id');
		location.href='<?php echo url::site()?>admin/legal_documents/view/'+id;
	}));

	$(".approve").live('click', (function () {
		var id = $(this).attr('id');
		location.href='<?php echo url::site()?>admin/members/approve/'+id;
	}));

	$(".decline").live('click', (function () {
		var id = $(this).attr('id');
		location.href='<?php echo url::site()?>admin/members/decline/'+id;
	}));

	// $(".delete").live('click', (function () {
 //    if (confirm("Are you sure you want to delete this?")){
	// 	  id = $(this).attr("id");
	// 	  tr_class = $("tr#row_"+id).attr("class");
	// 	  new_class = tr_class == "odd" ? "even" : "odd";
	// 	  $.post("<?php echo url::site()?>admin/members/delete", {id: id}, function(data){
	// 		  $("tr#row_"+id).remove();
	// 		  $('tr').next('tr.'+tr_class).removeClass(tr_class);
	// 		  $('tr').next('tr.'+tr_class).addClass(new_class);
	// 	  });
	//   } 
	// }));

	$.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
		//redraw to account for filtering and sorting
		// concept here is that (for client side) there is a row got inserted at the end (for an add) 
		// or when a record was modified it could be in the middle of the table
		// that is probably not supposed to be there - due to filtering / sorting
		// so we need to re process filtering and sorting
		// BUT - if it is server side - then this should be handled by the server - so skip this step
		if(oSettings.oFeatures.bServerSide === false){
			var before = oSettings._iDisplayStart;
			oSettings.oApi._fnReDraw(oSettings);
			//iDisplayStart has been reset to zero - so lets change it back
			oSettings._iDisplayStart = before;
			oSettings.oApi._fnCalculateEnd(oSettings);
		}
		
		//draw the 'current' page
		oSettings.oApi._fnDraw(oSettings);
	};

	oTable = $('#datatables').dataTable( {
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		},
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo url::site()?>admin/datatables/list_data/pending_users/",
		"aaSorting": [[ 1, "desc" ]]
	}).fnSetFilteringDelay(1000);

});

//for the delay on searching
jQuery.fn.dataTableExt.oApi.fnSetFilteringDelay = function ( oSettings, iDelay ) {
	var _that = this;

	if ( iDelay === undefined ) {
			iDelay = 250;
	}
		
	this.each( function ( i ) {
			$.fn.dataTableExt.iApiIndex = i;
			var
			$this = this, 
			oTimerId = null, 
			sPreviousSearch = null,
			anControl = $( 'input', _that.fnSettings().aanFeatures.f );
		
			anControl.unbind( 'keyup' ).bind( 'keyup', function() {
			var $$this = $this;

			if (sPreviousSearch === null || sPreviousSearch != anControl.val()) {
					window.clearTimeout(oTimerId);
					sPreviousSearch = anControl.val();  
					oTimerId = window.setTimeout(function() {
							$.fn.dataTableExt.iApiIndex = i;
							_that.fnFilter( anControl.val() );
					}, iDelay);
			}
			});
				
			return this;
	} );
	return this;
};
</script>
<h3>NEWLY REGISTERED MEMBERS</h3>
<br />
<br />
<table align="center" cellpadding="0" cellspacing="0" border="0" width="100%" class="table table-striped table-bordered" id="datatables">
	<thead>
		<tr>
			<th width="25%" id="firstname">Member Name</th>
			<th width="25%" id="email">Email</th>
			<th width="25%" id="type">User Type</th>
			<th width="25%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<!-- <iframe src="http://docs.google.com/viewer?url=http%3A%2F%2Framlawtitle.com%2Fassets%2Fuploads%2Fdocuments%2FTzad%2520Test%2520Document%25201.docx&embedded=true" width="600" height="780" style="border: none;"></iframe> -->