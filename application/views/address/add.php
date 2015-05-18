<div class="clearfix spacer"></div>
<h1 class="spacedhead">Add Address</h1>
<div class="clearfix spacer"></div>

<ul class="mainbodyform">
<?php echo form::open(NULL, array('id'=>'form', 'class'=>'form-horizontal'));?>
	<li>
		Address 1<br />
		<input type="text" name="address_1" class="span3 required" />
	</li>
	<li>
		Address 2<br />
		<input type="text" name="address_2" class="span3" />
	</li>
	<li>
		City<br />
		<input type="text" name="city" class="span3 required" />
	</li>
	<li>
		State<br />
		<input type="text" name="state" class="span3 required" />
	</li>
	<li>
		Zip<br />
		<input type="text" name="zip" class="span3 required" />
	</li>
	<li>
		Address Type?<br />
		<select name="type" class="required">
			<option value="">Please Select</option>
			<option value="Office">Office</option>
			<option value="Warehouse">Warehouse</option>
			<option value="Office/Warehouse">Both</option>
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
