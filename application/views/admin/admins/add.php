<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
<div id="notice" class="alert-error alert" style="display:none;">
	<a href="javascript:void(0);" class="close">&times;</a>
	<div id="notice_msg"></div>
</div>
<h1>Add Admin</h1>
<p>First Name: <input type="text" name="firstname" value="" id="firstname" class="required" title="Please enter your First Name"></p>
<p>Last Name: <input type="text" name="lastname" value="" id="lastname" class="required" title="Please enter your Last Name"></p>
<p>Username: <input type="text" name="username" value="" id="username" class="required" title="Please enter your Username"></p>
<p>Password: <input type="password" name="passw" value="" id="passw" class="required" title="Please enter your Password"></p>

<p>Can Edit Member?: <input type="radio" name="edit_member" value="Y"> Yes <input type="radio" name="edit_member" value="N" checked="checked"> No</p>
<p>Can Delete Member?: <input type="radio" name="delete_member" value="Y"> Yes <input type="radio" name="delete_member" value="N" checked="checked"> No</p>
<p>Can Edit Product?: <input type="radio" name="edit_product" value="Y"> Yes <input type="radio" name="edit_product" value="N" checked="checked"> No</p>
<p>Can Delete Product?: <input type="radio" name="delete_product" value="Y"> Yes <input type="radio" name="delete_product" value="N" checked="checked"> No</p>
<p>Can Download Legal Docs?: <input type="radio" name="download_legal_docs" value="Y"> Yes <input type="radio" name="download_legal_docs" value="N" checked="checked"> No</p>
<p>Can Approve Legal Docs?: <input type="radio" name="approve_legal_docs" value="Y"> Yes <input type="radio" name="approve_legal_docs" value="N" checked="checked"> No</p>
<p>Can Decline Legal Docs?: <input type="radio" name="decline_legal_docs" value="Y"> Yes <input type="radio" name="decline_legal_docs" value="N" checked="checked"> No</p>

<input type="submit" value="Add">
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script>
$().ready(function() {
	$("#form").validate({
		submitHandler: function() {
	  		$.post("<?php echo URL::site('admin/admins/save');?>", $('#form').serialize(), function(data){
				if(data.success == "N"){
					$("#notice").slideDown("slow");
					$("#notice_msg").html("Username already in use, please choose another one.");
				}else{
					location.href = "<?php echo URL::site('admin/admins/index');?>";
				}
			}, "json");
	  	}
	});
});
</script>