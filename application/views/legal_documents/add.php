<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
		<div id="notice_msg" class="alert-error alert">
			Please select a document to upload. (jpg, gif, png or pdf only)
		</div>
		<div class="row">
			Title:<br />
			<input type="text" id="title" name="title" class="span7 required" />
		</div>
		<div class="row">
			File:<br />
			<input type="file" name="upload" id="upload" class="required" />
		</div>
		<div>
			<button type="submit" class="silverbutton normalbutton">Submit</button>
		</div>
	</fieldset>
</div>
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate();
});
</script>
