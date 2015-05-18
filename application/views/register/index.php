<div class="clearfix spacer"></div>
<h1 class="spacedhead">Register</h1>
<div class="clearfix spacer"></div>

<div id="notice" class="alert-error alert" style="display:none;">
	<div id="notice_msg"></div>
	<div>
		<button class="silverbutton normalbutton change_email">Use Different Email Address</button> OR <button class="silverbutton normalbutton reset">Reset Password</button>
	</div>
	<br />
</div>

<?php echo form::open('register/check_username', array('id'=>'register_form', 'class'=>'form-horizontal'));?>

<ul class="mainbodyform" style="width:400px;float:left;">
	<li>
		<strong>Email Address</strong><br />
		<input type="text" name="email" id="email" class="span3 required email" />
	</li>
	<li>
		<strong>Password</strong><br />
		<input type="password" name="passw" class="span3 required" />
	</li>
	<li>
		<strong>First Name</strong><br />
		<input type="text" name="firstname" class="span3 required" />
	</li>
	<li>
		<strong>Last Name</strong><br />
		<input type="text" name="lastname" class="span3 required" />
	</li>
	<li>
		<strong>Address 1</strong><br />
		<input type="text" name="address_1" class="span3 required" />
	</li>
	
	
</ul>
<ul class="mainbodyform" style="width:400px;float:left;">
	<li>
		<strong>Address 2</strong><br />
		<input type="text" name="address_2" class="span3" />
	</li>
	<li>
		<strong>City</strong><br />
		<input type="text" name="city" class="span3 required" />
	</li>
	<li>
		<strong>State</strong><br />
		<select name="state"  class="required" >
			<option value="">Please Select</option>
			<?php 
			foreach($states as $state)
			{
			?>
			<option value="<?php echo $state->abbreviation?>"><?php echo $state->state?></option>
			<?php
			}
			?>
		</select>
	</li>
	<li>
		<strong>Zip</strong><br />
		<input type="text" name="zip" class="span3 required" />
	</li>
	<li>
		<strong>Are you a?</strong><br />
		<select name="type" class="required">
			<option value="">Please Select</option>
			<option value="vendor">Vendor</option>
			<option value="buyer">Buyer</option>
			<option value="vendor/buyer">Both</option>
			<option value="charity">Charity</option>
		</select>
	</li>
	<li><button class="silverbutton normalbutton">Next</button><!-- &nbsp;<button type="reset" class="btn"><i class="icon-refresh"></i> Clear</button> --></li>
</ul>
<?php echo Form::close();?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#register_form").validate({
	  	submitHandler: function() {
	  		$.post("<?php echo URL::site('register/check_username');?>", $('#register_form').serialize(), function(data){
				if(data.success == "N"){
					$("#notice").slideDown("slow");
					$("#notice_msg").html("Email address is already registered");
					$("#notice_msg").focus();
				}else{
					//location.href = "<?php echo URL::site('register/successful');?>";
					location.href = "<?php echo URL::site('register/step_2/');?>/"+data.uid;
				}
			}, "json");
	  	}
	});

	$(".change_email").click(function(){
		$("#email").val("");
		$("#email").focus();
	});

	$(".reset").click(function(){
		location.href="<?php echo URL::site('forgotpassword');?>";
	});

});
</script>
