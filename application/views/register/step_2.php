<div class="clearfix spacer"></div>
<h1 class="spacedhead">Registration > Business Profile</h1>
<div class="clearfix spacer"></div>

<div id="notice" class="alert-error alert" style="display:none;">
	<div id="notice_msg"></div>
	<div>
	</div>
	<br />
</div>

<?php echo form::open('register/step_2', array('id'=>'register_form', 'class'=>'form-horizontal'));?>

<ul class="mainbodyform" style="width:400px;float:left;">
	<li>
		<strong>Entity Name</strong><br />
		<input type="text" name="business_name" id="business_name" class="span3 required" />
	</li>
	<li>
		<strong>Entity Description</strong><br />
		<textarea name="business_description" class="span3 required" rows="5" cols="40" /></textarea>
	</li>
</ul>

<div class="clearfix spacer"></div>
<h1 class="spacedhead">Registration > Entity Profile</h1>
<div class="clearfix spacer"></div>

<ul class="mainbodyform" style="width:400px;float:left;">
	<li>
		<strong>Entity Type</strong><br />
		<select name="entity_type" class="required">
			<option value="">Please Select</option>
			<option value="Sole Proprietor">Sole Proprietor</option>
			<option value="Partnership">Partnership</option>
			<option value="LLC">LLC</option>
			<option value="S Corporation">S Corporation</option>
			<option value="C Corporation">C Corporation</option>
			<option value="Non Profit Corporation">Non Profit Corporation</option>
		</select>
	</li>
	<li>
		<strong>Entity Category</strong><br />
		<select name="entity_category" class="required">
			<option value="">Please Select</option>
			<option value="Producer">Producer</option>
			<option value="Distributor">Distributor</option>
			<option value="Retailer ">Retailer </option>
			<option value="Charitable Organization">Charitable Organization</option>
		</select>
	</li>
	<!-- <li>
		Entity Privileges <br />
		<input type="radio" name="entity_privileges" value="Seller" checked="checked"> Seller <input type="radio" name="entity_privileges" value="Buyer"> Buyer 
	</li> -->
	<li>
		<strong>Year Entity Established</strong>  <a href="javascript:void(0);" title="Note the year that the entity was established"><img src="<?php echo url::base();?>assets/images/info.png" border="0"></a><br />
		<input type="text" name="year_established" id="year_established" class="span3 required" />
	</li>
	<li>
		<strong>Number of Entity Locations</strong>  <a href="javascript:void(0);" title="List the number of stores, locations, warehouses etc"><img src="<?php echo url::base();?>assets/images/info.png" border="0"></a><br />
		<input type="text" name="number_of_entity" id="number_of_entity" class="span3 required" />
	</li>
	<li>
		<strong>Number of Employees</strong><br />
		<input type="text" name="number_of_employees" id="number_of_employees" class="span3 required" />
	</li>
	<li>
		<strong>Number of Direct Customers</strong>  <a href="javascript:void(0);" title="Estimate the numbers of customers that you serve - could be number of companies or number of customers"><img src="<?php echo url::base();?>assets/images/info.png" border="0"></a><br />
		<input type="text" name="number_of_direct_customers" id="number_of_direct_customers" class="span3 required" />
	</li>
</ul>

<div class="clearfix spacer"></div>
<h1 class="spacedhead">Registration > Entity Business References</h1>
<div class="clearfix spacer"></div>

<ul class="mainbodyform" style="width:400px;float:left;">

	<li>
		<strong>Entity Business Reference</strong><br />
		<input type="text" name="ref_business_name" id="ref_business_name" class="span3 required" />
	</li>
	<li>
		<strong>Reference Contact Name</strong><br />
		<input type="text" name="ref_contact_name" id="ref_contact_name" class="span3 required" />
	</li>
	<li>
		<strong>Reference Contact Address</strong><br />
		<input type="text" name="ref_contact_address" id="ref_contact_address" class="span3 required" />
	</li>
	<li>
		<strong>Reference Contact Email Address</strong><br />
		<input type="text" name="ref_contact_email_address" id="ref_contact_email_address" class="span3 required" />
	</li>
	<li>
		<strong>Reference Contact Phone Number</strong><br />
		<input type="text" name="ref_contact_phone_number" id="ref_contact_phone_number" class="span3 required" />
	</li>
	<li>
		<strong>Length of Reference Relationship</strong><br />
		<input type="text" name="ref_lenght_of_business_relationship" id="ref_lenght_of_business_relationship" class="span3 required" />
	</li>
	<!-- <li>
		<strong>Entity EIN or other tax identification number</strong><br /> (e.g. SSN for sole proprietor)<br />
		<input type="text" name="ref_entiry_ein" id="ref_entiry_ein" class="span3 required" />
	</li> -->

	<li>
		<strong>Agree to the <a href="<?php echo URL::site('page/view/9/terms-and-conditions');?>" target="_blank">Terms and Conditions</a>?</strong><br />
		<input type="checkbox" name="agree" id="agree" class="span3 required" /> Yes
	</li>
	
	<input type="hidden" name="uid" value="<?php echo $uid?>">
	<li><button class="silverbutton normalbutton">Next</button><!-- &nbsp;<button type="reset" class="btn"><i class="icon-refresh"></i> Clear</button> --></li>
</ul>
<?php echo Form::close();?>

<?php echo html::script("assets/js/jquery-1.10.2.js");?> 
<?php echo html::script("assets/js/jquery-ui-1.11.2.js");?> 
<?php echo html::stylesheet("assets/js/jquery-ui.css");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(function() {
	$( document ).tooltip();
});
$(document).ready(function(){
	$("#register_form").validate({
	  	submitHandler: function() {
	  		$.post("<?php echo URL::site('register/save_step_2');?>", $('#register_form').serialize(), function(data){
				if(data.success == "N"){
					$("#notice").slideDown("slow");
					$("#notice_msg").html("Email address is already registered");
					$("#notice_msg").focus();
				}else{
					//location.href = "<?php echo URL::site('register/successful');?>";
					location.href = "<?php echo URL::site('register/step_3');?>/"+data.uid;
				}
			}, "json");
	  	}
	});

});
</script>