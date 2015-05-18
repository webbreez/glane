<?php echo html::script("assets/js/jquery-1.11.0.min");?>
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript" src="<?php echo url::base();?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$().ready(function() {
	// validate the form when it is submitted
	$("#form").validate();
	
	CKEDITOR.replace('content', {
		filebrowserImageUploadUrl : '<?php echo url::site("admin/page/ck_upload_file");?>',
		filebrowserUploadUrl : '<?php echo url::site("assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files");?>',
		height: 350,
		width: 800
	});

	CKEDITOR.instances["content"].on("instanceReady", function(){
		//set keyup event
        this.document.on("keyup", updateTextArea);
        //and paste event
        this.document.on("paste", updateTextArea);
    });

    function updateTextArea(){
		CKEDITOR.tools.setTimeout( function(){
			$("#content").val(CKEDITOR.instances.content.getData());
            $("#content").trigger('keyup');
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
	<h3>Page > Content</h3>
	<p>Title: <br /> <?php echo form::input("title", $faqs->title);?></p>
	<p><?php echo form::textarea("content", $faqs->content);?></p>
	<p><?php echo form::submit("Submit", "Submit");?> <!-- OR <a href="javascript:void(0)" id="delete">DELETE</a> --></p>
<?php echo form::close();?>