<!-- column 1 -->
<div id="notice" class="alert-error alert" style="display:none;">
	<div id="notice_msg">Email Address/Password is incorrect</div>
</div>
<ul class="loginboxcol1">
<?php echo form::open('login/check', array('id'=>'login_form', 'class'=>'form-horizontal'));?>
<li>Email Address<br /><input name="username" type="text" maxlength="100"  class="required" /></li>
<li>Password<br /><input name="password" type="password" maxlength="50" class="required" /></li>
<li class="fonthalf"><a href="<?php echo URL::site('forgotpassword/index');?>">Forgot Password?</a></li>
<li class="fonthalf fleft cbox lgchck"><input name="" type="checkbox" value=""  /></li>
<li  class="fonthalf fleft lgchck">Stay signed in</li>
<li class="fonthalf fleft prv">To protect your privacy, remember to sign out when you're done shopping. <a href="<?php echo URL::site('page/view/1/learn-more');?>">Learn more</a></li>
<li class="clearfix"></li>
<li><button class="silverbutton normalbutton">Sign In</button></li>

<?php echo Form::close();?>
</ul>

<!-- column 1 -->

<!-- column 2 --><div class="loginboxcol2">
<h1>New to LogicLane?</h1>

<a class="silverbutton normalbutton" href="<?php echo URL::site('register');?>">Register</a>
</div><!-- column 2 -->


<script type="text/javascript">
$(document).ready(function(){
	$("#login_form").validate({
	  	submitHandler: function() {
	  		$.post("<?php echo URL::site('login/check');?>", $('#login_form').serialize(), function(data){
				if(data.success == false){
					$("#notice").slideDown("slow");
				}else{
					if(data.redirect == true)
					{
						location.href = "<?php echo URL::site($redirect);?>";
					}else{
						location.href = "<?php echo URL::site('register/upload_legal_docs');?>";
					}
				}
			}, "json");
	  	}
	});
});
</script>
