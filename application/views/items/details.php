<?php
//save the user's info
productsvisit_helper::save_data($this->session->get("user_id"), $product->product_id, $product->category_1);
?>
<div style="padding-left: 30px;">
<h1 class="spacedhead">Product Details</h1>


<!--  col 1 --><div class="productcol pp1">

<?php
$pctr = 0;
foreach($pictures as $picture)
{
	if($pctr == 0)
	{
		$pstyle = "display:block;";
	}else{
		$pstyle = "display:none;";
	}
?>
<span id="<?php echo $picture->product_images_id?>" style="<?php echo $pstyle?>">
	<a class="fancybox-buttons" data-fancybox-group="button" href="<?php echo url::base();?>assets/upload/<?php echo $picture->product_images_filename?>"><img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $picture->product_images_filename?>&w=270&h=192&zc=2" border="0" /></a>
</span>
<?php
	$pctr++;
}
?>

<p><strong>Product Name: <?php echo $product->product_name?></strong></p>

<p><strong>Category:</strong>
		<?php
		echo $category_1.' '.$category_2.' '.$category_3.' '.$category_4;
		?>
</p>

<p><strong>Description:</strong> <?php echo $product->product_description?></p>

<p><strong>Quantity:</strong> <?php echo $product->qty?> <?php echo $product->qty_type?>s
<?php 
	if($product->qty_type == "Unit")
	{
		echo ' / '.$product->number_of_unit_per_case .' '. $product->pack_per_case_size;
	}elseif($product->qty_type == "Pallet"){
		echo //'<br />Number of Unit: '.$product->number_of_unit_per_pallet .
			 ' / '. $product->case_per_pallet . 
			 ' Case Per Pallet'.
			 ' / '. $product->unit_per_case_per_pallet . 
			 ' Unit Per Case'.
			 ' / '. $product->number_of_unit_per_case . 
			 ' '.$product->pack_per_case_size;
// ' Pallet Per '. $product->pack_per_case_size;
	}elseif($product->qty_type == "Case"){
		echo //'<br />'.$product->number_of_unit_per_case .
			 ' / '. $product->unit_per_case . 
			 ' '  .'Per Case  '.
			 ' / '.$product->number_of_unit_per_case .' '. $product->pack_per_case_size;
	}
	?> 
</p>

<?php
/*
<p><strong>Sold By:</strong> <?php echo $product->qty_type?>  /

<?php 
if ($product->qty_type == "Pallet")
{
?>
<?php echo $product->number_of_cases_per_pallet?>
<?php
}else{
?>
<?php echo $product->pack_per_case?> <?php echo $product->pack_per_case_size?>
<?php
}
?>
</p>
*/?>

<p><strong>Country of Origin:</strong> <?php echo $product->country_of_origin?></p>
<p><strong>Size:</strong> <?php echo $product->height?>x<?php echo $product->length?>x<?php echo $product->width?></p>
<p><strong>Weight:</strong> <?php echo $product->weight?> Lbs</p>

<?php
if($product->short_dated == "Yes")
{
	$expiration_date = date("F d, Y", strtotime($product->expiration_date));
?>
<p><strong>Expiration Date:</strong> <?php echo $expiration_date?></p>
<?php
}
?>
<!-- <p><strong>Sold By:</strong> 
	<?php 
	if($product->qty_type == "Unit")
	{
		echo $product->number_of_unit .' '. $product->pack_per_case_size . ' / Unit';
	}elseif($product->qty_type == "Pallet"){
		echo '<br />Number of Unit: '.$product->number_of_unit_per_pallet .
			 '<br /> Case Per Pallet: '. $product->case_per_pallet . 
			 '<br /> Unit Per Case Per Pallet: '. $product->unit_per_case_per_pallet .
			 ' / Pallet';
	}elseif($product->qty_type == "Case"){
		echo '<br />Number of Unit: '.$product->number_of_unit_per_case .
			 '<br /> Unit Per Case: '. $product->unit_per_case . 
			 ' / Case';
	}
	?> 
</p> -->

<div class="clearfix"></div></div><!--  col 1 -->


<!--  col 2 --><div class="productcol pp2">
<p><strong>Original List Price:</strong> <span class="pricingb">$<?php echo number_format($product->price, 2)?></span> 


<?php 
	if($product->qty_type == "Unit")
	{
	// 	echo ' Per Unit  ';
	}elseif($product->qty_type == "Pallet"){
		echo ' Per Pallet  ';
	}elseif($product->qty_type == "Case"){
		echo ' Per Case  ';
	}
	?> 



</p>

<?php if($product->minimum_purchase) { ?>
<p><strong>Minimum number of items to purchase:</strong> <?php echo $product->minimum_purchase?>

<?php 
	if($product->qty_type == "Unit")
	{
	// 	echo ' Unit(s)  ';
	}elseif($product->qty_type == "Pallet"){
		echo ' Pallet(s)  ';
	}elseif($product->qty_type == "Case"){
		echo ' Case(s)  ';
	}
	?> 

</p>
<?php } ?>


<?php
if($product->on_sale == "Yes")
{
	$da = ($product->price * $product->sale_price) / 100;
	$amount = $product->price - $da;
	$sale_price = number_format($amount, 2);
?>
<p style="color:red"><strong>LogicLane Price:</strong> <span class="pricingb">$<?php echo $sale_price?></span>

<?php 
	if($product->qty_type == "Unit")
	{
	// 	echo ' Per Unit  ';
	}elseif($product->qty_type == "Pallet"){
		echo ' Per Pallet  ';
	}elseif($product->qty_type == "Case"){
		echo ' Per Case  ';
	}
	?> 


<br />You save <?php echo $product->sale_price?>% </p>
<?php
}
?>

<?php
if($product->shipping_fee_included == "Yes")
{
?>
<p style="color:red"><strong>Free Shipping</strong></p>
<?php
}
?>
<?php
if($product->percentage_discount)
{
?>
<p><strong>Discounts:</strong> <br />
<?php
	$discount_array = explode("\n", trim($product->percentage_discount));
	$on_sale = $product->on_sale;
	foreach($discount_array as $discount)
	{
		$discount_percentage_array = explode(" ", $discount);
		$discount_percentage = substr($discount_percentage_array[1], 0, 2);
		$dp = ($product->price * $discount_percentage) / 100;
		$discounted_amount = $product->price - $dp;

		if($on_sale == "Yes")
		{
			$sale_price = ($product->price * $product->sale_price) / 100;
			$da = $product->price - $sale_price;
			$dp = ($da * $discount_percentage) / 100;
			$discounted_amount = $da - $dp;
		}

		echo $discount.' $'.number_format($discounted_amount, 2).'<br />';
	}
?>
<!-- <p><strong>Discounts:</strong> <br /><?php echo nl2br($product->percentage_discount)?></p> -->
</p>
<?php
}
?>

<p>Take All price is <span class="pricingb">$<?php echo number_format($product->take_all_price, 2)?></span>

<?php 
if($product->qty_type == "Unit")
{
// 	echo ' Per Unit  ';
}elseif($product->qty_type == "Pallet"){
	echo ' Per Pallet  ';
}elseif($product->qty_type == "Case"){
	echo ' Per Case  ';
}
?>
</p>
<!-- <a href="<?php echo URL::site('items/buy_it_now');?>/<?php echo $product->product_id?>" class="butbotton fancybox fancybox.iframe">Buy it Now</a> -->

<!-- <button class="buynow" id="<?php echo $product->product_id?>">Buy it Now</button> -->
<p><button class="addtocart stbutton" id="<?php echo $product->product_id?>" rel="<?php echo $product->minimum_purchase?>">Add To Cart</button></p>

<p><button class="takeall stbutton" id="<?php echo $product->product_id?>">Take All</button></p>

<?php
if($product->make_an_offer == "Yes")
{ 
?>
<p><button id="make_an_offer" class="stbutton">Make Your Offer</button></p>
<?php
}
?>

<p><button class="similar_address stbutton" id="<?php echo $product->product_pickup_address?>" rel="<?php echo $product->minimum_purchase?>">View Products with the same Seller and Address</button></p>


<div class="clearfix"></div></div><!--  col 2 -->



<!--  col 3 --><div class="productcol pp3">
<strong>Similar products</strong>
<ul class="mainlistproduct">
<?php
foreach($related_products as $rp)
{
?>
<li>
<div class="col1">
	<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $rp->product_id?>">
	<?php
	if($this->get_product_picture($rp->product_id))
	{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $this->get_product_picture($rp->product_id)?>&w=209&h=155&zc=2" border="0" />
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
<h1><?php echo $rp->product_name?> <span style="color:red;"><?php if($rp->product_type == "charity"){ echo "(Charity)";}?></span></h1>
</div>

<div class="col3">

</div>


<div class="col4">
<?php 
if($rp->product_type != "charity")
{
	if($rp->sale_price)
	{
		$da = ($rp->price * $rp->sale_price) / 100;
		$amount = $rp->price - $da;
		$rp_price = number_format($amount, 2);
	}else{
		$rp_price = number_format($rp->price, 2);
	}
?>
$<?php echo $rp_price?> Per <?php echo $rp->qty_type?><br />
<?php
}
?>

<button class="view" id="<?php echo $rp->product_id?>">View Details</button>
</div>


<div class="clearfix"></div></li>
<!-- product item -->
<?php
}
?>
</ul>
<div class="clearfix"></div>
</div><!--  col 3 -->


<?php echo html::script("assets/js/jquery-1.11.0.min.js");?> 
<?php echo html::script("assets/fancybox/jquery.fancybox.pack.js?v=2.1.5");?>
<?php echo html::stylesheet("assets/fancybox/jquery.fancybox.css?v=2.1.5");?> 	

<style>
.fancybox-inner {
    overflow: hidden !important;
}
</style>

<script>
$(document).ready(function() {
	//$('.fancybox').fancybox();

	$(".view").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('product_listing/details');?>/"+id;
	});

	$(".addtocart").click(function(){
		var id = $(this).attr('id');
		var qty = $(this).attr('rel');
		location.href="<?php echo URL::site('cart/add_to_cart');?>/"+id+"/"+qty;
	});

	$(".similar_address").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('index/similar_address');?>/"+id;
	});

	$(".takeall").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('cart/take_all');?>/"+id+"/<?php echo $product->qty?>";
	});


	$(".buynow").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('cart/add_to_cart');?>/"+id;
		<?php
		/*
		if($this->session->get("user_id"))
		{
		?>
			location.href="<?php echo URL::site('items/buy_it_now');?>/"+id;
			return false;
		<?php
		}else{
		?>
			alert("Please login first before you can buy that product.");
			return false;
		<?php
		}*/
		?>
	});

	$("#make_an_offer").click(function() {
		<?php
		if($this->session->get("user_id"))
		{
		?>
		$.fancybox.open({
			href: "<?php echo URL::site('items/make_an_offer');?>/<?php echo $product->product_id?>",
			type : 'iframe',
			width : 400,
			height : 400,
			fitToView : true,
   			autoSize : true,
   			overflow : 'hidden', 
            scrolling   : 'no'
		});
		<?php
		}else{
		?>
			alert("Please login first before you can buy that product.");
			return false;
		<?php
		}	
		?>
	});

	$('.fancybox-buttons').fancybox({
		openEffect  : 'none',
		closeEffect : 'none',

		prevEffect : 'none',
		nextEffect : 'none',

		closeBtn  : false,

		helpers : {
			title : {
				type : 'inside'
			},
			buttons	: {}
		},

		afterLoad : function() {
			this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
		}
	});

});
</script>


