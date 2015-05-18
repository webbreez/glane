<div id="notice" class="alert-error alert" style="display:none;">
	<div id="notice_msg"></div>
</div>

<div class="clearfix spacer"></div>
<h1 class="spacedhead">Please enter your email address</h1>
<div class="clearfix spacer"></div>

<ul class="mainbodyform">
<?php echo form::open('login/forgotpassword', array('id'=>'form', 'class'=>'form-horizontal'));?>

	<li>
		Email<br />
		<input type="text" name="email" class="span3 required email" />
	</li>
	<li><button class="silverbutton normalbutton">Submit</button></li>
<?php echo Form::close();?>
</ul>

<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate({
	  	submitHandler: function() {
	  		$.post("<?php echo URL::site('login/check_forgotpassword');?>", $('#form').serialize(), function(data){
				if(data === false){
					$("#notice").slideDown("slow");
					$("#notice_msg").html("Your email address is not in our database.");
				}else{
					$("#notice").slideDown("slow");
					$("#notice_msg").html("Your password has been sent.");
				}
			}, "json");
	  	}
	});
});
</script>
