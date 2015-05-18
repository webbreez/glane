<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
<div class="error"></div>
<h1 class="spacedhead">Your Offer</h1>
<p>Quantity: <input type="text" name="qty" id="qty" class="required" title="Please enter the number of products" style="width:50px;"></p>
<p>US $: <input type="text" name="amount" id="amount" class="required" title="Please enter the amount" style="width:50px;"> per <?php echo $product->qty_type?></p>
<!-- <p>Note:</strong>: <textarea name="note"></textarea></p> -->
<!-- <p>Ship Date</strong>: <input type="text" id="shipdate" name="shipdate" value="" class="span7 datepicker" style="width:150px;" /></p> -->

<input type="hidden" name="product_id" value="<?php echo $product_id?>">
<input type="hidden" name="offered_by_user_id" value="<?php echo $offered_by_user_id?>">
<input type="submit" value="Submit">
<!-- <input type="submit" value="Submit" onclick="formSubmit()"> -->
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<?php echo html::script("assets/js/jquery-ui.js");?> 
<?php echo html::stylesheet("assets/css/jquery-ui.css");?> 
<script>
$().ready(function() {
	$("#form").validate();

	$(".datepicker").datepicker();
});

// function formSubmit() {
//     parent.$.fancybox.close();
//     $('#offer').submit();
// }
</script>