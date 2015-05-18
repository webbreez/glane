<div class="clearfix spacer"></div>
<h1 class="spacedhead">Edit Address</h1>
<div class="clearfix spacer"></div>

<ul class="mainbodyform">
<?php echo form::open(NULL, array('id'=>'form', 'class'=>'form-horizontal'));?>
	<li>
		Address 1<br />
		<input type="text" name="address_1" class="span3 required" value="<?php echo $address->user_address_1?>" />
	</li>
	<li>
		Address 2<br />
		<input type="text" name="address_2" class="span3" value="<?php echo $address->user_address_2?>" />
	</li>
	<li>
		City<br />
		<input type="text" name="city" class="span3 required" value="<?php echo $address->user_address_city?>" />
	</li>
	<li>
		State<br />
		<input type="text" name="state" class="span3 required" value="<?php echo $address->user_address_state?>" />
	</li>
	<li>
		Zip<br />
		<input type="text" name="zip" class="span3 required" value="<?php echo $address->user_address_zip?>" />
	</li>
	<li>
		Address Type?<br />
		<select name="type" class="required">
			<option value="">Please Select</option>
			<option value="Office" <?php echo $address->user_address_type == "Office" ? "selected=selected" : ''?>>Office</option>
			<option value="Warehouse" <?php echo $address->user_address_type == "Warehouse" ? "selected=selected" : ''?>>Warehouse</option>
			<option value="Office/Warehouse" <?php echo $address->user_address_type == "Office/Warehouse" ? "selected=selected" : ''?>>Both</option>
		</select>
	</li>
	<li>
		Primary?<br />
		<select name="primary" class="required">
			<option value="">Please Select</option>
			<option value="Yes" <?php echo $address->user_address_primary == "Yes" ? "selected=selected" : ''?>>Yes</option>
			<option value="No" <?php echo $address->user_address_primary == "No" ? "selected=selected" : ''?>>No</option>
		</select>
	</li>
	<li><button class="silverbutton normalbutton">Update</li>
<?php echo Form::close();?>
</ul>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate();
});
</script>
