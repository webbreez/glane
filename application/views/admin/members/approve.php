<?php echo html::script("assets/js/jquery-1.11.0.min");?>
<script type="text/javascript" src="<?php echo url::base();?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$().ready(function() {
	// validate the form when it is submitted
	
	CKEDITOR.replace('message', {
		filebrowserImageUploadUrl : '<?php echo url::site("admin/page/ck_upload_file");?>',
		filebrowserUploadUrl : '<?php echo url::site("assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files");?>',
		height: 250,
		width: 600
	});

	CKEDITOR.instances["message"].on("instanceReady", function(){
		//set keyup event
        this.document.on("keyup", updateTextArea);
        //and paste event
        this.document.on("paste", updateTextArea);
    });

    function updateTextArea(){
		CKEDITOR.tools.setTimeout( function(){
			$("#message").val(CKEDITOR.instances.message.getData());
            $("#message").trigger('keyup');
        }, 0);
    }
	
});
</script>
<h3>You are about to approve a member</h3>
<?php echo form::open(null, array('id'=>'register_form', 'class'=>'form-horizontal'));?>
<div id="notice" class="alert-error alert" style="display:none;">
	<a href="javascript:void(0);" class="close">&times;</a>
	<div id="notice_msg"></div>
</div>
<p>Email Address: <input type="text" name="email" id="email" value="<?php echo $member->email?>" class="required"></p>
<p>First Name: <input type="text" name="firstname" id="firstname" value="<?php echo $member->firstname?>" class="required" title="Please enter your First Name"></p>
<p>Last Name: <input type="text" name="lastname" id="lastname" value="<?php echo $member->lastname?>" class="required" title="Please enter your Last Name"></p>
<p>Approve as: 
	<select name="type">
		<option value="vender" <?php echo $member->type == "vendor" ? 'selected' : ''?>>Vendor</option>
		<option value="buyer" <?php echo $member->type == "buyer" ? 'selected' : ''?>>Buyer</option>
		<option value="vendor/buyer" <?php echo $member->type == "vendor/buyer" ? 'selected' : ''?>>Both</option>
	</select>
</p>
<p>Email message: <?php echo form::textarea("message");?></p>
<input type="hidden" name="user_id" value="<?php echo $member->user_id?>">
<input type="submit" value="Submit">
<?php echo Form::close();?>