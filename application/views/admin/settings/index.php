<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
<div id="notice" class="alert-error alert" style="display:none;">
	<a href="javascript:void(0);" class="close">&times;</a>
	<div id="notice_msg"></div>
</div>
<h1>Profile Info</h1>
<p>First Name: <input type="text" name="firstname" value="<?php echo $admin->firstname?>" id="firstname" class="required" title="Please enter your First Name"></p>
<p>Last Name: <input type="text" name="lastname" value="<?php echo $admin->lastname?>" id="lastname" class="required" title="Please enter your Last Name"></p>
<p>Current Password: <input type="password" name="passw" value="" id="passw" class="required" title="Please enter your Password"></p>
<p>New Password: <input type="password" name="new_passw" value="" id="new_passw" class="required" title="Please enter your New Password"></p>
<p>Confirm Password: <input type="password" name="confirm_passw" value="" id="confirm_passw" class="required" title="Your Password did not match."></p>

<input type="submit" value="Update">
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script>
$().ready(function() {
	$("#form").validate({
		submitHandler: function() {
	  		$.post("<?php echo URL::site('admin/settings/save');?>", $('#form').serialize(), function(data){
				$("#notice").slideDown("slow");
				$("#notice_msg").html(data.msg);
			},'json');
	  	}
	});
});
</script>