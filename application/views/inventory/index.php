<div class="row">
	<div class="span7">
		<div id="notice" class="alert-error alert" style="display:none;">
			<a href="javascript:void(0);" class="close">&times;</a>
			Invalid login info.  Please try again.
		</div>
		<?php echo form::open('inventory/login/check', array('id'=>'login_form', 'class'=>'form-horizontal'));?>
		<fieldset>
			<legend>Manager Login <small><em>Provide your login info to access the site.</em></small></legend>
			<div class="control-group">
				<label class="control-label">Username:</label>
				<div class="controls">
					<input type="text" name="username" class="span3 required" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Password:</label>
				<div class="controls">
					<input type="password" name="password" class="span3 required" />
					<!-- <p class="help-block"><a href="<?php echo url::site('inventory/help/forgot_password');?>">Forgot your password?</a></p> -->
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary"><i class="icon-user icon-white"></i> Login</button>
				<button type="reset" class="btn"><i class="icon-refresh"></i> Clear</button>
			</div>
		</fieldset>
		<?php echo Form::close();?>
	</div>
</div>
<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#login_form").validate({
	  	submitHandler: function() {
	  		$.post("<?php echo URL::site('inventory/index/check');?>", $('#login_form').serialize(), function(data){
				if(data === false){
					$("#notice").slideDown("slow");
				}else{
					location.href = "<?php echo URL::site('inventory/home');?>";
				}
			}, "json");
	  	}
	});
});
</script>
