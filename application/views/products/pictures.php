<?php
foreach($pictures as $picture)
{
?>
<p id="<?php echo $picture->product_images_id?>">
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $picture->product_images_filename?>&w=270&h=192&zc=2" border="0" />
	<br />
	<a href="javascript:void(0)" class="delete" id="<?php echo $picture->product_images_id?>" rel="<?php echo $picture->product_images_filename?>">DELETE</a>
</p>
<?php
}
?>

<?php echo form::open_multipart(NULL, array('id'=>'form'));?>

<h1 class="spacedhead">Add Picture</h1>
<div>
	Picture:<br />
	<input type="file" id="picture" name="picture" class="span7 required" />
</div>
<div>
	<button type="submit" class="silverbutton normalbutton">Submit</button>
</div>
		
<input type="hidden" name="product_id" value="<?echo $this->uri->segment(3)?>">
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){
	$("a.delete").click(function(){
    	if (confirm("Are you sure you want to delete this?")){
		var id = $(this).attr('id');
		var filename = $(this).attr('rel');
		data = new  Object();
		data.id = id;
		data.filename = filename;

		$.ajax({
			type: "POST",
			data: data,
			url: '<?php echo URL::site('products/delete_picture');?>',
			success: function(data) {
				$("p#"+id).hide("slow");
			}
		});
		} 
	});
});
</script>
