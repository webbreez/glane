<h1 class="spacedhead">Edit Product</h1>
<div style="padding-left: 30px;">
<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
		<div>
			<h1>Product Details</h1>
		</div>
		<div>
			<strong>Brand</strong>:<br /><input type="text" id="brand" name="brand" value="<?php echo $product->brand?>" class="span7 required" />
		</div>
		<div>
			<strong>Product</strong>:<br />
			<input type="text" id="product_name" name="product_name" value="<?php echo $product->product_name?>" class="span7 required" maxlength="50" />
		</div>
		<div>
			<strong>Department</strong>:<br />
				<select name="department" id="department" class="category" title="Please select a department" rel="department">
					<option value="1">Grocery</option>
				</select>
		</div>
		<div>
			<strong>Category</strong>:<br />
				<select name="category_1" id="category_1" class="category" rel="category_1">
				<?php
				foreach($category_1 as $cat_1)
				{
					$category_1_id = $cat_1->category_1_id;
					$category_1_name = $cat_1->category_1_name;
				?>
				<option value="<?php echo $category_1_id?>" <?php echo $product->category_1 == $category_1_id ? 'selected=selected' : ''?>><?php echo $category_1_name?></option>
				<?php
				}
				?>
				</select>
		</div>
		<!-- <div>
			Category 3:<br />
				<select name="category_3" id="category_3" class="category" rel="category_3">
				<?php
				foreach($list_product_category_3 as $cat_3)
				{
				?>
				<option value="<?php echo $cat_3->category_3_id?>" <?php echo $product->category_3 == $cat_3->category_3_id ? 'selected=selected' : ''?>><?php echo $cat_3->category_3_name?></option>
				<?
				}
				?>
				</select>
		</div>
		<div>
			Category 4:<br />
				<select name="category_4" id="category_4" class="category" rel="category_4">
				<?php
				foreach($list_product_category_4 as $cat_4)
				{
				?>
				<option value="<?php echo $cat_4->category_4_id?>" <?php echo $product->category_4 == $cat_4->category_4_id ? 'selected=selected' : ''?>><?php echo $cat_4->category_4_name?></option>
				<?
				}
				?>
				</select>
		</div> -->
		<div>
			<strong>Quantity Available</strong>:<br />
			<input type="text" id="qty" name="qty" value="<?php echo $product->qty?>" class="span7 required" />
		</div>
		<div>
			<strong>Minimum number of items to purchase</strong>:<br /><input type="text" id="minimum_purchase" name="minimum_purchase" value="<?php echo $product->minimum_purchase?>" class="span7" />
		</div>
		<div>
			<strong>Sold By</strong>: <br />
			<select name="qty_type" id="qty_type" class="required" title="Please select type">
				<option value="">Please Select</option>
				<option value="Unit" <?php echo $product->qty_type == "Unit" ? 'selected=selected' : ''?>>Per Unit</option>
				<option value="Pallet" <?php echo $product->qty_type == "Pallet" ? 'selected=selected' : ''?>>Per Pallet</option>
				<option value="Case" <?php echo $product->qty_type == "Case" ? 'selected=selected' : ''?>>Per Case</option>
			</select>
		</div>
		<!-- <div id="div_per_pallet" <?php echo $product->qty_type == "Pallet" ? "style=display:block;" : "style=display:none;"?>> -->
		<div>
			<span id="span_per_unit" <?php echo $product->qty_type == "Unit" ? "style=display:block;" : "style=display:none;"?>>
				<!-- <strong>Number of Unit</strong>:<br />
				<input type="text" id="number_of_unit" name="number_of_unit" value="<?php echo $product->number_of_unit?>" class="span7" /> -->
			</span>
			<span id="span_per_pallet" <?php echo $product->qty_type == "Pallet" ? "style=display:block;" : "style=display:none;"?>>
				<!-- <strong>Number of Unit</strong>:<br />
				<input type="text" id="number_of_unit_per_pallet" name="number_of_unit_per_pallet" value="<?php echo $product->number_of_unit_per_pallet?>" class="span7" />
				<br /> -->
				<strong>Case Per Pallet</strong>:<br />
				<input type="text" id="case_per_pallet" name="case_per_pallet" value="<?php echo $product->case_per_pallet?>" class="span7" />
				<br />
				<strong>Unit Per Case Per Pallet</strong>:<br />
				<input type="text" id="unit_per_case_per_pallet" name="unit_per_case_per_pallet" value="<?php echo $product->unit_per_case_per_pallet?>" class="span7" />
				<br />
				<strong>Measurement Per Unit</strong>:<br />
				<input type="text" id="number_of_unit_per_case" name="number_of_unit_per_case" value="<?php echo $product->number_of_unit_per_case?>" class="span7" />
				<br />
			</span>
			<span id="span_per_case" <?php echo $product->qty_type == "Case" ? "style=display:block;" : "style=display:none;"?>>
				<!-- <strong>Number of Unit</strong>:<br />
				<input type="text" id="number_of_unit_per_case" name="number_of_unit_per_case" value="<?php echo $product->number_of_unit_per_case?>" class="span7" />
				<br /> -->
				<strong>Unit Per Case</strong>:<br />
				<input type="text" id="unit_per_case" name="unit_per_case" value="<?php echo $product->unit_per_case?>" class="span7" />
			</span>
			<span id="span_pack_per_case_size">
			<strong>Measurement:</strong>:<br />
			<select name="pack_per_case_size" id="pack_per_case_size" class="" title="Please select type">
				<option value="">Please Select</option>
				<option value="Pounds" <?php echo $product->pack_per_case_size == "Pounds" ? 'selected=selected' : ''?>>Pounds</option>
				<option value="Oz" <?php echo $product->pack_per_case_size == "Oz" ? 'selected=selected' : ''?>>Oz</option>
				<option value="Gram" <?php echo $product->pack_per_case_size == "Gram" ? 'selected=selected' : ''?>>Gram</option>
				<option value="Gallon" <?php echo $product->pack_per_case_size == "Gallon" ? 'selected=selected' : ''?>>Gallon</option>
				<option value="Quart" <?php echo $product->pack_per_case_size == "Quart" ? 'selected=selected' : ''?>>Quart</option>
				<option value="Pint" <?php echo $product->pack_per_case_size == "Pint" ? 'selected=selected' : ''?>>Pint</option>
				<option value="Cup" <?php echo $product->pack_per_case_size == "Cup" ? 'selected=selected' : ''?>>Cup</option>
				<option value="Liquid Oz" <?php echo $product->pack_per_case_size == "Liquid Oz" ? 'selected=selected' : ''?>>Liquid Oz</option>
				<option value="Liter" <?php echo $product->pack_per_case_size == "Liter" ? 'selected=selected' : ''?>>Liter</option>
			</select>
			</span>
		</div>
		<div>
			<strong>Price</strong>:<br />
			<input type="text" id="price" name="price" value="<?php echo $product->price?>" class="span7 required" />
		</div>
		<!-- <div>
			<strong>Sold By</strong> :<br />
			<input type="text" id="pack_per_case" name="pack_per_case" value="<?php echo $product->pack_per_case?>" class="span7" size="5" />
			<select name="pack_per_case_size" id="pack_per_case_size" class="category" title="Please select type">
				<option value="">Please Select</option>
				<option value="Pounds" <?php echo $product->pack_per_case_size == "Pounds" ? 'selected=selected' : ''?>>Pounds</option>
				<option value="Oz" <?php echo $product->pack_per_case_size == "Oz" ? 'selected=selected' : ''?>>Oz</option>
				<option value="Gram" <?php echo $product->pack_per_case_size == "Gram" ? 'selected=selected' : ''?>>Gram</option>
				<option value="Gallon" <?php echo $product->pack_per_case_size == "Gallon" ? 'selected=selected' : ''?>>Gallon</option>
				<option value="Quart" <?php echo $product->pack_per_case_size == "Quart" ? 'selected=selected' : ''?>>Quart</option>
				<option value="Pint" <?php echo $product->pack_per_case_size == "Pint" ? 'selected=selected' : ''?>>Pint</option>
				<option value="Cup" <?php echo $product->pack_per_case_size == "Cup" ? 'selected=selected' : ''?>>Cup</option>
				<option value="Liquid Oz" <?php echo $product->pack_per_case_size == "Liquid Oz" ? 'selected=selected' : ''?>>Liquid Oz</option>
				<option value="Liter" <?php echo $product->pack_per_case_size == "Liter" ? 'selected=selected' : ''?>>Liter</option>
			</select> Per Unit
		</div> -->
		<div>
			<strong>Discounts Available</strong>:<br />
			<div style="color:red;">
			Sample Format <br />
			1-5 10% <br />
			6-10 15% <br />
			11-max 20% <br />
			</div>
			<textarea name="percentage_discount" id="percentage_discount" class="" title="" rows="10" cols="40"><?php echo $product->percentage_discount?></textarea>
		</div>
		<div>
			<strong>Take All Price</strong>:<br />
			<input type="text" id="take_all_price" name="take_all_price" value="<?php echo $product->take_all_price?>" class="span7" />
		</div>
		<div>
			<strong>On Sale?</strong>:<br />
			<select name="on_sale" id="on_sale" class="required" title="Please select">
				<option value="No" <?php echo $product->on_sale == "No" ? 'selected=selected' : ''?>>No</option>
				<option value="Yes" <?php echo $product->on_sale == "Yes" ? 'selected=selected' : ''?>>Yes</option>
			</select>
		</div>
		<div id="div_sale_price">
			<strong>Sale Price Discount</strong>:<br />
			<input type="text" id="sale_price" name="sale_price" value="<?php echo $product->sale_price?>" class="span7" /> %
		</div>
		<div>
			<strong>Type</strong>:<br />
			<select name="product_type" id="product_type" class="required" title="Please select type">
				<option value="">Please Select</option>
				<option value="normal" <?php echo $product->product_type == "normal" ? 'selected=selected' : ''?>>Normal</option>
				<option value="charity" <?php echo $product->product_type == "charity" ? 'selected=selected' : ''?>>Charity</option>
			</select>
		</div>
		<br />
		<div>
			<h1>Product Offer Feature</h1>
		</div>
		<div>
			<strong>Make an Offer</strong>:<br />
			<select name="make_an_offer" id="make_an_offer" class="required" title="Please select type">
				<option value="">Please Select</option>
				<option value="Yes" <?php echo $product->make_an_offer == "Yes" ? 'selected=selected' : ''?>>Yes</option>
				<option value="No" <?php echo $product->make_an_offer == "No" ? 'selected=selected' : ''?>>No</option>
			</select>
		</div>
		<div id="div_make_an_offer" <?php echo $product->make_an_offer == "Yes" ? 'style=display:block;' : 'style=display:none;'?>>
			<div>
				<strong>Offer minimum amount</strong>:<br />
				<input type="text" id="make_an_offer_minimum_amount" name="make_an_offer_minimum_amount" value="<?php echo $product->make_an_offer_minimum_amount?>" class="span7" />
			</div>
			<div>
				<strong>Offer minimum quantity</strong>:<br />
				<input type="text" id="make_an_offer_minimum_qty" name="make_an_offer_minimum_qty" value="<?php echo $product->make_an_offer_minimum_qty?>" class="span7" />
			</div>
			<div>
				<strong>Offer auto accept amount</strong>:<br />
				<input type="text" id="make_an_offer_auto_accept_amount" name="make_an_offer_auto_accept_amount" value="<?php echo $product->make_an_offer_auto_accept_amount?>" class="span7" />
			</div>
			<div>
				<strong>Offer auto accept quantity</strong>:<br />
				<input type="text" id="make_an_offer_auto_accept_qty" name="make_an_offer_auto_accept_qty" value="<?php echo $product->make_an_offer_auto_accept_qty?>" class="span7" />
			</div>
		</div>
		<br />
		<div>
			<h1>Shipping Details</h1>
		</div>
		<div>
			<strong>Height</strong>:<br />
			<input type="text" id="height" name="height" value="<?php echo $product->height?>" class="span7 required" /> cm
		</div>
		<div>
			<strong>Length</strong>:<br />
			<input type="text" id="length" name="length" value="<?php echo $product->length?>" class="span7 required" /> cm
		</div>
		<div>
			<strong>Width</strong>:<br />
			<input type="text" id="width" name="width" value="<?php echo $product->width?>" class="span7 required" /> cm
		</div>
		<div>
			<strong>Weight</strong>:<br />
			<input type="text" id="weight" name="weight" value="<?php echo $product->weight?>" class="span7 required" /> lbs
		</div>
		<div>
			<br />
			<input type="checkbox" id="shipping_fee_included" name="shipping_fee_included" value="Yes" <?php echo $product->shipping_fee_included == "Yes" ? 'checked=checked' : ''?> class="span7" /> <strong>Shipping Included (If shipping is not included in price, buyer will be responsible for shipping costs)</strong>
		</div>
		<div>
			<br />
			<strong>Country of Origin</strong> <br />
			<select name="country_of_origin" id="country_of_origin" class="" title="Please select type">
				<option value="">Please Select</option>
				<?php
				foreach($countries as $country)
				{ 
				?>
				<option value="<?php echo $country->country_name_short?>" <?php echo $product->country_of_origin == $country->country_name_short ? 'selected=selected' : ''?>><?php echo $country->country_name?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div>
			<strong>Description</strong>:<br />
			<textarea name="description" id="description" class="required" title="Please enter product description" rows="10" cols="40"><?php echo $product->product_description?></textarea>
		</div>
		<?php
		if($product->featured == "Yes")
		{
		?>
			<?php if($product->banner){?><img src="<?php echo url::base();?>assets/upload/<?php echo $product->banner?>" /><?php }?>
		<div>
			<strong>Upload Picture Banner</strong>:<br />
			<input type="file" id="banner" name="banner" class="span7" />
		</div>
		<?php
		}
		?>

		<div>
			<br />
			<input type="checkbox" id="short_dated" name="short_dated" value="Yes" <?php echo $product->short_dated == "Yes" ? 'checked=checked' : ''?> class="span7" /> <strong>Short Dated?</strong>
			<br />
		</div>

		<div id="div_expiration_date" <?php echo $product->short_dated == "Yes" ? "style=display:block;" : "style=display:none;"?>>
			<?php 
			$expiration_date_array_1 = explode(" ", $product->expiration_date);
			$expiration_date_array_2 = explode("-", $expiration_date_array_1[0]);
			$expiration_date = $expiration_date_array_2[1]."/".$expiration_date_array_2[2]."/".$expiration_date_array_2[0];
			?>
			<strong>Expiration Date</strong>:<br />
			<input type="text" id="expiration_date" name="expiration_date" value="<?php echo $expiration_date?>" class="span7 datepicker" />
		</div>

		<input type="hidden" name="featured" value="<?php echo $product->featured?>">

		<br />
		<div>
			<h1>Shipping Pickup Address</h1>
		</div>
		<div>
			<strong>Address</strong>:<br />
			<select name="product_pickup_address" id="product_pickup_address" class="required">
				<option value="">Please Select</option>
			<?php
			foreach($addresses as $oa)
			{
			?>
			<option value="<?php echo $oa->user_address_id?>" <?php echo $oa->user_address_id  == $product->product_pickup_address ? 'selected=selected' : ''?>><?php echo $oa->user_address_1?> <?php echo $oa->user_address_2?></option>
			<?
			}
			?>
			</select>
		</div>

		<br />
		<br />
		<div>
			<button type="submit" class="silverbutton normalbutton">Submit</button>
		</div>
<?php form::close()?>
</div>
<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery-ui.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<?php echo html::stylesheet("assets/css/jquery-ui.css");?> 
<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate();

	$("#brand").autocomplete({
		source: "<?php echo URL::site('products/get_brands');?>",
		minLength: 1
	});	

	$(".datepicker").datepicker();

	$("#short_dated").on("click", function() {
		if($("#short_dated").prop('checked') == true){
    		$("#div_expiration_date").show();
		}else{
			$("#div_expiration_date").hide();
		}
	});

	$("#product_type").change(function(){
		var val = $(this).val();
		if(val == "charity")
		{
			$("#price").val("0");
		}
	});

	$("#make_an_offer").change(function(){
		var val = $(this).val();
		if(val == "Yes")
		{
			$("#div_make_an_offer").show();
		}else{
			$("#div_make_an_offer").hide();
		}
	});

	$("#qty_type").change(function(){
		var val = $(this).val();
		if(val == "Pallet")
		{
			$("#span_per_pallet").show();
			$("#span_pack_per_case_size").show();
			$("#span_per_case").hide();
			$("#span_per_unit").hide();
		}else if(val == "Case"){
			$("#span_per_case").show();
			$("#span_pack_per_case_size").show();
			$("#span_per_pallet").hide();
			$("#span_per_unit").hide();
		}else if(val == "Unit"){
			$("#span_per_case").hide();
			$("#span_per_pallet").hide();
			$("#span_per_unit").show();
			$("#span_pack_per_case_size").show();
		}else{
			$("#span_per_pallet").hide();
			$("#span_per_case").hide();
			$("#span_per_unit").hide();
			$("#span_pack_per_case_size").hide();
		}
	});

	$(".category").change(function(){
		var id = $(this).val();
		var type = $(this).attr("rel");

		var data = new Object();
		data.id = id;
		data.type = type;

		$.ajax({
		type: "POST",
		dataType: "json",
		data: data,
		url: '<?php echo URL::site('products/get_categories');?>',
		success: function(data) {
			if(data.length > 0)
            {
               	var options = '<option value=""></option>';
                $.each(data, function(i, value){
                    options += '<option value="' + value.key + '">' + value.val + '</option>';
                });

                if(type == 'category_1')
                {
                	$("select[name='category_2']").html(options);
                	$("select[name='category_3']").html("<option value=\"\"></option>");
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_2')
                {
                	$("select[name='category_3']").html(options);
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_3')
                {
                	$("select[name='category_4']").html(options);
                }

            }else{
            	var options = '<option value=""></option>';
            	if(type == 'category_1')
                {
                	$("select[name='category_2']").html(options);
                	$("select[name='category_3']").html("<option value=\"\"></option>");
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_2')
                {
                	$("select[name='category_3']").html(options);
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_3')
                {
                	$("select[name='category_4']").html(options);
                }
            }
		}
		});
	});
});
</script>
