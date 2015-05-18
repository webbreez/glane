<div class="row">
<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
<div class="span9">
	<fieldset>
	<legend><h4>Register</h4></legend>
		<div id="notice" class="alert-error alert" style="display:none;">
			<a href="javascript:void(0);" class="close">&times;</a>
			<div id="notice_msg"></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Email:</label></div>
			<div class="span4"><input type="text" id="email" name="email" value="" class="span4" /></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Password:</label></div>
			<div class="span4"><input type="password" id="password" name="password" value="" class="span4" /></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Confirm Password:</label></div>
			<div class="span4"><input type="password" id="confirm_password" name="confirm_password" value="" class="span4" /></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">First Name:</label></div>
			<div class="span4"><input type="text" id="firstname" name="firstname" value="" class="span4" /></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Last Name:</label></div>
			<div class="span4"><input type="text" id="lastname" name="lastname" value="" class="span4" /></div>
		</div>
		<div class="form-actions">
			<div class="span4 offset2">
				<button type="submit" class="btn btn-primary"><i class="icon-upload icon-white"></i> Submit</button>
			</div>
		</div>
	</fieldset>
</div>
<?php form::close()?>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 8
			},
			confirm_password: {
				required: true,
				minlength: 8,
				equalTo: "#password"
			},
			firstname: {
				required: true
			},
			lastname: {
				required: true
			}
		},
	  	submitHandler: function() {
	  		$.post("<?php echo URL::site('admin/register/check');?>", $('#form').serialize(), function(data){
				if(data.success == "N"){
					$("#notice").slideDown("slow");
					$("#notice_msg").html(data.message);
				}else{
					location.href = "<?php echo URL::site('admin/register/index');?>";
				}
			}, "json");
	  	}
	});
});
</script>
