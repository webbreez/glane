<h1 class="spacedhead">Upload Products</h1>
<div style="padding-left: 30px;">
<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
	<div>
		Excel File:<br />
		<input type="file" id="excel" name="excel" class="span7 required" />
	</div>
	<br />
	<div>
		<button type="submit" class="silverbutton normalbutton">Submit</button>
	</div>
	<input type="hidden" name="_hidden">
</div>
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>

<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate();
});
</script>
