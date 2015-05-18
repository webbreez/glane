<div class="clearfix spacer"></div>
<h1 class="spacedhead">User Profile</h1>
<div class="clearfix spacer"></div>

<div id="notice" class="alert-error alert" style="display:none;">
	<div id="notice_msg"></div>
</div>

<ul class="mainbodyform">
<?php echo form::open(NULL, array('id'=>'form', 'class'=>'form-horizontal'));?>

	<li>
		Email Address<br />
		<input type="text" name="email" id="email" class="span3 required email" value="<?php echo $user->email?>" />
	</li>
	<li>
		Password<br />
		<input type="password" name="passw" class="span3 required" value="<?php echo base64_decode($user->password)?>" />
	</li>
	<li>
		First Name<br />
		<input type="text" name="firstname" class="span3 required" value="<?php echo $user->firstname?>" />
	</li>
	<li>
		Last Name<br />
		<input type="text" name="lastname" class="span3 required" value="<?php echo $user->lastname?>" />
	</li>
	<li><button class="silverbutton normalbutton">Update</button></li>
	<input type="hidden" name="current_email" value="<?php echo $user->email?>">
<?php echo Form::close();?>
</ul>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate({
	  	submitHandler: function() {
	  		$.post("<?php echo URL::site('profile/check_username');?>", $('#form').serialize(), function(data){
				if(data.success == "N"){
					$("#notice").slideDown("slow");
					$("#notice_msg").html("Email address is already registered");
					$("#notice_msg").focus();
				}else{
					$("#notice").slideDown("slow");
					$("#notice_msg").html("Update Successful");
					location.href="<?php echo URL::site('profile/index/updated');?>"
				}
			}, "json");
	  	}
	});

	<?php
	if($this->uri->segment(3) == "updated")
	{
	?>
	$("#notice").slideDown("slow");
	$("#notice_msg").html("Update Successful");
	<?php
	}
	?>
});
</script>
