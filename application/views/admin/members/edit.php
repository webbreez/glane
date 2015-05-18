<h3>PROFILE</h3>
<?php echo form::open(null, array('id'=>'register_form', 'class'=>'form-horizontal'));?>
<div id="notice" class="alert-error alert" style="display:none;">
	<a href="javascript:void(0);" class="close">&times;</a>
	<div id="notice_msg"></div>
</div>
<p>Email Address: <input type="text" name="email" id="email" value="<?php echo $member->email?>" class="required" disabled="disabled"></p>
<p>First Name: <input type="text" name="firstname" id="firstname" value="<?php echo $member->firstname?>" class="required" title="Please enter your First Name"></p>
<p>Last Name: <input type="text" name="lastname" id="lastname" value="<?php echo $member->lastname?>" class="required" title="Please enter your Last Name"></p>
<p>Password: <input type="password" name="password" id="password" value="<?php echo base64_decode($member->password)?>"  class="required" title="Please enter your Password"></p>
<p>Status: 
	<select name="user_status">
		<option value="0" <?php echo $member->user_status == 0 ? 'selected' : ''?>>InActive</option>
		<option value="1" <?php echo $member->user_status == 1 ? 'selected' : ''?>>Active</option>
		<option value="2" <?php echo $member->user_status == 2 ? 'selected' : ''?>>Pending</option>
		<option value="3" <?php echo $member->user_status == 3 ? 'selected' : ''?>>Suspended</option>
	</select>
</p>
<p>Are you a?
	<select name="type" class="required">
		<option value="">Please Select</option>
		<option value="vendor" <?php echo $member->type == 'vendor' ? 'selected' : ''?> >Vendor</option>
		<option value="buyer" <?php echo $member->type == 'buyer' ? 'selected' : ''?>>Buyer</option>
		<option value="vendor/buyer" <?php echo $member->type == 'vendor/buyer' ? 'selected' : ''?>>Both</option>
	</select>
</p>
<input type="hidden" name="user_id" value="<?php echo $member->user_id?>">
<input type="submit" value="Submit">
<?php echo Form::close();?>

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
		"sAjaxSource": "<?php echo url::site()?>admin/datatables/list_data/address/<?php echo $this->uri->segment(4)?>",
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
<h3>ADDRESS</h3>
<br />
<br />
<table align="center" cellpadding="0" cellspacing="0" border="0" width="100%" class="table table-striped table-bordered" id="datatables">
	<thead>
		<tr>
			<th width="20%" id="user_address_1">Address 1</th>
			<th width="20%" id="user_address_2">Address 2</th>
			<th width="20%" id="user_address_city">City</th>
			<th width="20%" id="user_address_state">State</th>
			<th width="20%" id="user_address_zip">Zip</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>