<h3>ADD NEW MEMBER</h3>
<?php echo form::open(null, array('id'=>'register_form', 'class'=>'form-horizontal'));?>
<div id="notice" class="alert-error alert" style="display:none;">
	<a href="javascript:void(0);" class="close">&times;</a>
	<div id="notice_msg"></div>
</div>
<p>Email Address: <input type="text" name="email" id="email" value="" class="email required"></p>
<p>Password: <input type="password" name="password" id="password" value=""  class="required" title="Please enter your Password"></p>
<p>First Name: <input type="text" name="firstname" id="firstname" value="" class="required" title="Please enter your First Name"></p>
<p>Last Name: <input type="text" name="lastname" id="lastname" value="" class="required" title="Please enter your Last Name"></p>
<p>Address 1: <input type="text" name="address_1" id="address_1" value="" class="required"></p>
<p>Address 2: <input type="text" name="address_2" id="address_2" value="" class=""></p>
<p>City: <input type="text" name="city" id="city" value="" class="required"></p>
<p>State: <input type="text" name="state" id="state" value="" class="required"></p>
<p>Zip: <input type="text" name="zip" id="zip" value="" class="required"></p>
<p>
	Are you a?<br />
	<select name="type" class="required">
		<option value="">Please Select</option>
		<option value="vendor">Vendor</option>
		<option value="buyer">Buyer</option>
		<option value="vendor/buyer">Both</option>
	</select>
</p>
<input type="submit" value="Submit">
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
					location.href = "<?php echo URL::site('admin/members/pending');?>";
				}
			}, "json");
	  	}
	});

});
</script>