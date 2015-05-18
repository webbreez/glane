<h1 class="spacedhead">Items I'm Watching</h1>

<?php
foreach($products as $product)
{
?>
<!-- product item -->
<li>
<div class="col1">
	<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $product->product_id?>">
	<?php
	if($this->get_product_picture($product->product_id))
	{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $this->get_product_picture($product->product_id)?>&w=209&h=155&zc=2" border="0" />
	<?php
	}else{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/images/no_image.jpg&w=209&h=155&zc=2" border="0" />
	<?php
	}
	?>
	</a>
</div>

<div class="col2">
<h1><?php echo $product->product_name?> <span style="color:red;"><?php if($product->product_type == "charity"){ echo "(Charity)";}?></span></h1>
</div>

<div class="col3">

</div>


<div class="col4">
$<?php echo number_format($product->price, 2)?><br />
<button class="view" id="<?php echo $product->product_id?>">View Details</button>
<!-- <button class="addtocart" id="<?php echo $product->product_id?>">Add To Cart</button>
<button class="buybutton" id="<?php echo $product->product_id?>">Buy Now</button> -->
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