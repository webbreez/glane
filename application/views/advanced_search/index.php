<fieldset>
	<legend>Fields</legend>
	<p>Keyword: <input type="text" name="search_keyword" id="search_keyword" value="<?echo $this->input->get('search_keyword')?>"></p>
	<p>Brand: 
		<select name="brand" id="brand">
			<option value=""></option>
			<?php
			foreach($brands as $brand)
			{
			?>
			<option value="<?php echo $brand->brand_name?>" <?php echo $this->input->get('brand') == $brand->brand_name ? "selected=selected" : ''?>><?php echo $brand->brand_name?></option>
			<?php
			}
			?>
		</select>
	</p>
	<p>Category 1:
		<select name="category_1" id="category_1">
			<option value=""></option>
			<?php
			foreach($category_1 as $category_1)
			{
			?>
			<option value="<?php echo $category_1->category_1_id?>" <?php echo $this->input->get('category_1') == $category_1->category_1_id ? "selected=selected" : ''?>><?php echo $category_1->category_1_name?></option>
			<?php
			}
			?>
		</select>
	</p>
	<?php
	if($this->input->get("category_1"))
	{
	?>
		<p>Category 2:
		<select name="category_2" id="category_2">
		<option value=""></option>
		<?php
		foreach($category_2 as $category_2)
		{
		?>
		<option value="<?php echo $category_2->category_2_id?>" <?php echo $this->input->get('category_2') == $category_2->category_2_id ? "selected=selected" : ''?>><?php echo $category_2->category_2_name?></option>
		<?php
		}
		?>
		</select>
		</p>
		<?php
	}
	?>
	<?php
	if($this->input->get("category_2") && $this->input->get("category_2") != "undefined")
	{
	?>
		<p>Category 3:
		<select name="category_3" id="category_3">
		<option value=""></option>
		<?php
		foreach($category_3 as $category_3)
		{
		?>
		<option value="<?php echo $category_3->category_3_id?>" <?php echo $this->input->get('category_3') == $category_3->category_3_id ? "selected=selected" : ''?>><?php echo $category_3->category_3_name?></option>
		<?php
		}
		?>
		</select>
		</p>
		<?php
	}
	?>
	<?php
	if($this->input->get("category_3") && $this->input->get("category_3") != "undefined")
	{
	?>
		<p>Category 4:
		<select name="category_4" id="category_4">
		<option value=""></option>
		<?php
		foreach($category_4 as $category_4)
		{
		?>
		<option value="<?php echo $category_4->category_4_id?>" <?php echo $this->input->get('category_4') == $category_4->category_4_id ? "selected=selected" : ''?>><?php echo $category_4->category_4_name?></option>
		<?php
		}
		?>
		</select>
		</p>
		<?php
	}
	?>
	<p>
		Expiration Date:
		<select name="expiration_date" id="expiration_date">
            <option value=""></option>
            <option value="90" <?php echo $this->input->get("expiration_date") == 90 ? "selected=selected" : '' ?>>90 days to Expiration Date</option>
            <option value="60" <?php echo $this->input->get("expiration_date") == 60 ? "selected=selected" : '' ?>>60 days to Expiration Date</option>
            <option value="30" <?php echo $this->input->get("expiration_date") == 30 ? "selected=selected" : '' ?>>30 days to Expiration Date</option>
            <option value="expired" <?php echo $this->input->get("expiration_date") == 'expired' ? "selected=selected" : '' ?>>Expired</option>
        </select>
	</p>
	<p><button class="silverbutton normalbutton" id="search_button">Search</button></p>
</fieldset>
<br /><br />
<h1 class="spacedhead">Advanced Search Result</h1>
<?php
if($products_count == 1 OR $products_count == 0)
{
	$products_count_label = "Product";
}else{
	$products_count_label = "Products";
}
?>

<p style="padding-left:20px;">Showing <?php echo $products_count?> <?php echo $products_count_label?></p>
<?php
foreach($products as $product)
{
?>
<!-- product item -->
<li class="bgo0">
<div class="col1">
	<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $product->product_id?>">
	<?php
	if(productpicture_helper::get_product_picture($product->product_id))
	{
	?>
	<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo productpicture_helper::get_product_picture($product->product_id)?>&w=209&h=155&zc=2" border="0" />
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
<h1><?php echo $product->product_name?></h1>
<!--
<?php echo $product->product_description?>
&nbsp;
<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $product->product_id?>">View Product</a>
<br />
<a href="<?php echo URL::site('product_category/view/1/');?>/<?php echo $product->category_1?>/<?php echo url::title(productcategory_helper::get_category_name("category_1", $product->category_1))?>"><?php echo productcategory_helper::get_category_name("category_1", $product->category_1)?></a>&nbsp;
<a href="<?php echo URL::site('product_category/view/2/');?>/<?php echo $product->category_2?>/<?php echo url::title(productcategory_helper::get_category_name("category_2", $product->category_2))?>"><?php echo productcategory_helper::get_category_name("category_2", $product->category_2)?></a>&nbsp;
<a href="<?php echo URL::site('product_category/view/3');?>/<?php echo $product->category_3?>/<?php echo url::title(productcategory_helper::get_category_name("category_3", $product->category_3))?>"><?php echo productcategory_helper::get_category_name("category_3", $product->category_3)?></a>&nbsp;
<a href="<?php echo URL::site('product_category/view/4/');?>/<?php echo $product->category_4?>/<?php echo url::title(productcategory_helper::get_category_name("category_4", $product->category_4))?>"><?php echo productcategory_helper::get_category_name("category_4", $product->category_4)?></a>
-->
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
<!-- <button class="buybutton" id="<?php echo $product->product_id?>">Buy Now</button> -->
</div>

<div class="clearfix"></div></li>
<!-- product item -->

<?php
}
?>


<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){

	$(".view").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('product_listing/details');?>/"+id;
	});

	$("#brand").change(function(){
		var search_keyword = $("#search_keyword").val();
		var brand =  $(this).val();
		var category_1 = $("#category_1").val();
		var category_2 = $("#category_2").val();
		var category_3 = $("#category_3").val();
		var category_4 = $("#category_4").val();
		var expiration_date = $("#expiration_date").val();
		location.href="<?php echo URL::site('advanced_search/index');?>/"+"?search_keyword="+search_keyword+"&brand="+brand+"&category_1="+category_1+"&category_2="+category_2+"&category_3="+category_3+"&category_4="+category_4+"&expiration_date="+expiration_date;
	});

	$("#category_1").change(function(){
		var search_keyword = $("#search_keyword").val();
		var brand = $("#brand").val();
		var category_1 = $(this).val();
		var category_2 = $("#category_2").val();
		var category_3 = $("#category_3").val();
		var category_4 = $("#category_4").val();
		var expiration_date = $("#expiration_date").val();
		location.href="<?php echo URL::site('advanced_search/index');?>/"+"?search_keyword="+search_keyword+"&brand="+brand+"&category_1="+category_1+"&category_2="+category_2+"&category_3="+category_3+"&category_4="+category_4+"&expiration_date="+expiration_date;
	});

	$("#category_2").change(function(){
		var search_keyword = $("#search_keyword").val();
		var brand = $("#brand").val();
		var category_1 = $("#category_1").val();
		var category_2 = $(this).val();
		var category_3 = $("#category_3").val();
		var category_4 = $("#category_4").val();
		var expiration_date = $("#expiration_date").val();
		location.href="<?php echo URL::site('advanced_search/index');?>/"+"?search_keyword="+search_keyword+"&brand="+brand+"&category_1="+category_1+"&category_2="+category_2+"&category_3="+category_3+"&category_4="+category_4+"&expiration_date="+expiration_date;
	});

	$("#category_3").change(function(){
		var search_keyword = $("#search_keyword").val();
		var brand = $("#brand").val();
		var category_1 = $("#category_1").val();
		var category_2 = $("#category_2").val();
		var category_3 = $(this).val();
		var category_4 = $("#category_4").val();
		var expiration_date = $("#expiration_date").val();
		location.href="<?php echo URL::site('advanced_search/index');?>/"+"?search_keyword="+search_keyword+"&brand="+brand+"&category_1="+category_1+"&category_2="+category_2+"&category_3="+category_3+"&category_4="+category_4+"&expiration_date="+expiration_date;
	});

	$("#category_4").change(function(){
		var search_keyword = $("#search_keyword").val();
		var brand = $("#brand").val();
		var category_1 = $("#category_1").val();
		var category_2 = $("#category_2").val();
		var category_3 = $("#category_3").val();
		var category_4 = $(this).val();
		var expiration_date = $("#expiration_date").val();
		location.href="<?php echo URL::site('advanced_search/index');?>/"+"?search_keyword="+search_keyword+"&brand="+brand+"&category_1="+category_1+"&category_2="+category_2+"&category_3="+category_3+"&category_4="+category_4+"&expiration_date="+expiration_date;
	});

	$("#expiration_date").change(function(){
		var search_keyword = $("#search_keyword").val();
		var brand = $("#brand").val();
		var category_1 = $("#category_1").val();
		var category_2 = $("#category_2").val();
		var category_3 = $("#category_3").val();
		var category_4 = $("#category_4").val();
		var expiration_date = $(this).val();
		location.href="<?php echo URL::site('advanced_search/index');?>/"+"?search_keyword="+search_keyword+"&brand="+brand+"&category_1="+category_1+"&category_2="+category_2+"&category_3="+category_3+"&category_4="+category_4+"&expiration_date="+expiration_date;
	});

	$("#search_button").click(function(){
		var search_keyword = $("#search_keyword").val();
		var brand =  $(this).val();
		var category_1 = $("#category_1").val();
		var category_2 = $("#category_2").val();
		var category_3 = $("#category_3").val();
		var category_4 = $("#category_4").val();
		var expiration_date = $("#expiration_date").val();
		location.href="<?php echo URL::site('advanced_search/index');?>/"+"?search_keyword="+search_keyword+"&brand="+brand+"&category_1="+category_1+"&category_2="+category_2+"&category_3="+category_3+"&category_4="+category_4+"&expiration_date="+expiration_date;
	});
});
</script>