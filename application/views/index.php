<h1 class="spacedhead">Featured  Items</h1>

<?php
foreach($products as $product)
{
?>
<!-- product item -->
<li class="bgo0">
<div class="col1">
	<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $product->product_id?>">
	<?php
	if($this->get_product_picture($product->product_id))
	{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $this->get_product_picture($product->product_id)?>&w=149&h=92&zc=2" border="0" />
	<?php
	}else{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/images/no_image.jpg&w=149&h=92&zc=2" border="0" />
	<?php
	}
	?>
	</a>
</div>

<div class="col2">
<h1><?php echo $product->product_name?></h1>
<?php echo $product->product_description?>
&nbsp;
<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $product->product_id?>">View Product</a>
</div>

<div class="col3">
04 hrs<br />
30 mins
</div>

<div class="col4">
$<?php echo $product->price?><br />

<button class="buybutton" id="<?php echo $product->product_id?>">Buy Now</button>
</div>

<div class="clearfix"></div></li>
<!-- product item -->

<?php
}
?>


<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){
	$(".buybutton").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('items/buy_it_now');?>/"+id;
	});
});
</script>