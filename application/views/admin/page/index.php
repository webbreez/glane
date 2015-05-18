<?php echo html::script("assets/js/jquery-1.3.2.min.js");?>
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript" src="<?php echo url::base();?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$().ready(function() {
	// validate the form when it is submitted
	$("#form").validate();
	
	CKEDITOR.replace('content_1', {
		filebrowserImageUploadUrl : '<?php echo url::site("admin/page/ck_upload_file");?>',
		filebrowserUploadUrl : '<?php echo url::site("assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files");?>',
		height: 350,
		width: 800
	});

	CKEDITOR.instances["content_1"].on("instanceReady", function(){
		//set keyup event
        this.document.on("keyup", updateTextArea);
        //and paste event
        this.document.on("paste", updateTextArea);
    });

    function updateTextArea(){
		CKEDITOR.tools.setTimeout( function(){
			$("#content_1").val(CKEDITOR.instances.content_1.getData());
            $("#content_1").trigger('keyup');
        }, 0);
    }

    CKEDITOR.replace('content_2', {
		filebrowserImageUploadUrl : '<?php echo url::site("admin/page/ck_upload_file");?>',
		height: 350,
		width: 800
	});

	CKEDITOR.instances["content_2"].on("instanceReady", function(){
		//set keyup event
        this.document.on("keyup", updateTextArea);
        //and paste event
        this.document.on("paste", updateTextArea);
    });

    function updateTextArea(){
		CKEDITOR.tools.setTimeout( function(){
			$("#content_2").val(CKEDITOR.instances.content_2.getData());
            $("#content_2").trigger('keyup');
        }, 0);
    }
	
});
</script>
<style type="text/css">
.validate_error
{
	display: block;
	color: red;
	font-size: .8em;
}
</style>

<?php echo form::open(NULL, array('id'=>'form'));?>
	<h3><?echo $page_title?> > Content</h3>
	<p><?php echo form::textarea("content_1", $content->content);?></p>
	<p><?php echo form::submit("Submit", "Submit");?></p>
<?php echo form::close();?>