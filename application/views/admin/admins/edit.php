<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
<div id="notice" class="alert-error alert" style="display:none;">
	<a href="javascript:void(0);" class="close">&times;</a>
	<div id="notice_msg"></div>
</div>
<h1>Edit Admin</h1>
<p>First Name: <input type="text" name="firstname" value="<?php echo $admin->firstname?>" id="firstname" class="required" title="Please enter your First Name"></p>
<p>Last Name: <input type="text" name="lastname" value="<?php echo $admin->lastname?>" id="lastname" class="required" title="Please enter your Last Name"></p>
<p>Username: <input type="text" name="username" value="<?php echo $admin->username?>" id="username" class="required" title="Please enter your Username"></p>
<p>Password: <input type="password" name="passw" value="<?php echo base64_decode($admin->password)?>" id="passw" class="required" title="Please enter your Password"></p>

<p>Can Edit Member?: <input type="radio" name="edit_member" value="Y" <?php echo $admin->edit_member == "Y" ? 'checked=checked' : ''?>> Yes <input type="radio" name="edit_member" value="N" <?php echo $admin->edit_member == "N" ? 'checked=checked' : ''?>> No</p>
<p>Can Delete Member?: <input type="radio" name="delete_member" value="Y" <?php echo $admin->delete_member == "Y" ? 'checked=checked' : ''?>> Yes <input type="radio" name="delete_member" value="N" <?php echo $admin->delete_member == "N" ? 'checked=checked' : ''?>> No</p>
<p>Can Edit Product?: <input type="radio" name="edit_product" value="Y" <?php echo $admin->edit_product == "Y" ? 'checked=checked' : ''?>> Yes <input type="radio" name="edit_product" value="N" <?php echo $admin->edit_product == "N" ? 'checked=checked' : ''?>> No</p>
<p>Can Delete Product?: <input type="radio" name="delete_product" value="Y" <?php echo $admin->delete_product == "Y" ? 'checked=checked' : ''?>> Yes <input type="radio" name="delete_product" value="N" <?php echo $admin->delete_product == "N" ? 'checked=checked' : ''?>> No</p>
<p>Can Download Legal Docs?: <input type="radio" name="download_legal_docs" value="Y" <?php echo $admin->download_legal_docs == "Y" ? 'checked=checked' : ''?>> Yes <input type="radio" name="download_legal_docs" value="N" <?php echo $admin->download_legal_docs == "N" ? 'checked=checked' : ''?>> No</p>
<p>Can Approve Legal Docs?: <input type="radio" name="approve_legal_docs" value="Y" <?php echo $admin->approve_legal_docs == "Y" ? 'checked=checked' : ''?>> Yes <input type="radio" name="approve_legal_docs" value="N" <?php echo $admin->approve_legal_docs == "N" ? 'checked=checked' : ''?>> No</p>
<p>Can Decline Legal Docs?: <input type="radio" name="decline_legal_docs" value="Y" <?php echo $admin->decline_legal_docs == "Y" ? 'checked=checked' : ''?>> Yes <input type="radio" name="decline_legal_docs" value="N" <?php echo $admin->decline_legal_docs == "N" ? 'checked=checked' : ''?>> No</p>
<input type="hidden" name="orig_username" value="<?php echo $admin->username?>">
<input type="hidden" name="admin_id" value="<?php echo $admin->id?>">
<input type="submit" value="Update">
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script>
$().ready(function() {
	$("#form").validate({
		submitHandler: function() {
	  		$.post("<?php echo URL::site('admin/admins/edit_save');?>", $('#form').serialize(), function(data){
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