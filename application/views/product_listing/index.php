<!-- <h1 class="spacedhead">Featured  Items</h1> -->
<?php
if($products_count == 1 OR $products_count == 0)
{
	$products_count_label = "Product";
}else{
	$products_count_label = "Products";
}
?>

<?php
if($products_count > 0)
{
?>
<p style="padding-left:20px;">Showing <?php echo $count_1?> - <?php echo $count_2?> of <?php echo $products_count?> <?php echo $products_count_label?></p>
<?php
foreach($products as $product)
{
?>
<!-- product item -->
<?php
/*
<li class="bgo0">
<div class="col1">
	<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $product->product_id?>">
	<?php
	if($this->get_product_picture($product->product_id))
	{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $this->get_product_picture($product->product_id)?>&w=149&h=92" border="0" />
	<?php
	}else{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/images/no_image.jpg&w=149&h=92" border="0" />
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
<br />
<a href="<?php echo URL::site('product_category/view/1/');?>/<?php echo $product->category_1?>/<?php echo url::title(productcategory_helper::get_category_name("category_1", $product->category_1))?>"><?php echo productcategory_helper::get_category_name("category_1", $product->category_1)?></a>&nbsp;
<a href="<?php echo URL::site('product_category/view/2/');?>/<?php echo $product->category_2?>/<?php echo url::title(productcategory_helper::get_category_name("category_2", $product->category_2))?>"><?php echo productcategory_helper::get_category_name("category_2", $product->category_2)?></a>&nbsp;
<a href="<?php echo URL::site('product_category/view/3');?>/<?php echo $product->category_3?>/<?php echo url::title(productcategory_helper::get_category_name("category_3", $product->category_3))?>"><?php echo productcategory_helper::get_category_name("category_3", $product->category_3)?></a>&nbsp;
<a href="<?php echo URL::site('product_category/view/4/');?>/<?php echo $product->category_4?>/<?php echo url::title(productcategory_helper::get_category_name("category_4", $product->category_4))?>"><?php echo productcategory_helper::get_category_name("category_4", $product->category_4)?></a>
</div>

<div class="col3">

</div>

<div class="col4">
$<?php echo $product->price?><br />

<button class="buybutton" id="<?php echo $product->product_id?>">Buy Now</button>
</div>

<div class="clearfix"></div></li>
<!-- product item -->
*/
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
<?php 
if($product->product_type != "charity")
{
	if($product->sale_price)
	{
		$da = ($product->price * $product->sale_price) / 100;
		$amount = $product->price - $da;
		$product_price = number_format($amount, 2);
	}else{
		$product_price = number_format($product->price, 2);
	}
?>
$<?php echo $product_price?> Per <?php echo $product->qty_type?><br />
<?php
}
?>

<button class="view" id="<?php echo $product->product_id?>">View Details</button>
<!-- <button class="addtocart" id="<?php echo $product->product_id?>">Add To Cart</button>
<button class="buybutton" id="<?php echo $product->product_id?>">Buy Now</button> -->
</div>


<div class="clearfix"></div></li>
<!-- product item -->

<?php
}
?>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div style="float:right;"><?=$this->pagination->render('classic')?></div>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="clearfix"></div>

<?php
if(count($visited_products) != 0)
{
?>
<h1 class="spacedhead">Previously Visited Products</h1>

<?php
foreach($visited_products as $vp)
{
?>
<!-- product item -->
<li>
<div class="col1">
	<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $vp->product_id?>">
	<?php
	if($this->get_product_picture($vp->product_id))
	{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $this->get_product_picture($vp->product_id)?>&w=209&h=155&zc=2" border="0" />
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
<h1><?php echo $vp->product_name?></h1>
</div>

<div class="col3">

</div>


<div class="col4">
<?php 
if($vp->product_type != "charity")
{
	if($vp->sale_price)
	{
		$da = ($vp->price * $vp->sale_price) / 100;
		$amount = $vp->price - $da;
		$vp_price = number_format($amount, 2);
	}else{
		$vp_price = number_format($vp->price, 2);
	}

?>
$<?php echo $vp_price?> Per <?php echo $vp->qty_type?><br />
<?php
}
?>

<button class="view" id="<?php echo $product->product_id?>">View Details</button>
<!-- <button class="addtocart" id="<?php echo $product->product_id?>">Add To Cart</button>
<button class="buybutton" id="<?php echo $vp->product_id?>">Buy Now</button> -->
</div>


<div class="clearfix"></div></li>
<!-- product item -->

<?php
	}
}

}else{
?>
<h1>No Products for this category</h1>
<?php
}
?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){
	$(".buybutton").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('cart/add_to_cart');?>/"+id;
		<?php
		/*
		if($this->session->get("user_id") && $this->session->get("user_status") == 1)
		{
		?>
			location.href="<?php echo URL::site('items/buy_it_now');?>/"+id;
			return false;
		<?php
		}else{
		?>
			alert("You are not allowed to make this action.");
			return false;
		<?php
		}	
		*/
		?>
	});

	$(".view").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('product_listing/details');?>/"+id;
	});

	$(".addtocart").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('cart/add_to_cart');?>/"+id;
	});
});
</script>