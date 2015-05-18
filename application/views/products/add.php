<h1 class="spacedhead">Add New Product</h1>
<div style="padding-left: 30px;">
<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
		<div>
			<h1>Product Details</h1>
		</div>
		<div>
			<strong>Brand</strong>:<br /><input type="text" id="brand" name="brand" class="span7 required" />
		</div>
		<div>
			<strong>Product</strong>: <br /><input type="text" id="product_name" name="product_name" class="span7 required" maxlength="50" />
		</div>
		<div>
			<strong>Department</strong>t:<br />
				<select name="department" id="department" class="" title="Please select a department" rel="department">
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
				<option value="<?php echo $category_1_id?>"><?php echo $category_1_name?></option>
				<?php
				}
				?>
			</select>
		</div>
		<!-- <div>
			Category 3:<br />
			<select name="category_3" id="category_3" class="category" rel="category_3"></select>
		</div>
		<div>
			Category 4:<br />
			<select name="category_4" id="category_4" class="category" rel="category_4"></select>
		</div> -->
		<div>
			<strong>Quantity Available</strong>:<br /><input type="text" id="qty" name="qty" class="span7 required" />
		</div>
		<div>
			<strong>Minimum number of items to purchase</strong>:<br /><input type="text" id="minimum_purchase" name="minimum_purchase" value="" class="span7" />
		</div>
		<div>
			<strong>Sold By</strong>: <br />
			<select name="qty_type" id="qty_type" class="required" title="Please select type">
				<option value="">Please Select</option>
				<option value="Unit">Per Unit</option>
				<option value="Pallet">Per Pallet</option>
				<option value="Case">Per Case</option>
			</select>
		</div>
		<div>
			<span id="span_per_unit" style="display:none;">
				<!-- <strong>Number of Unit</strong>:<br />
				<input type="text" id="number_of_unit" name="number_of_unit" value="" class="span7" /> -->
			</span>
			<span id="span_per_pallet" style="display:none;">
				<!-- <strong>Number of Unit</strong>:<br />
				<input type="text" id="number_of_unit_per_pallet" name="number_of_unit_per_pallet" value="" class="span7" />
				<br /> -->
				<strong>Case Per Pallet</strong>:<br />
				<input type="text" id="case_per_pallet" name="case_per_pallet" value="" class="span7" />
				<br />
				<strong>Unit Per Case Per Pallet</strong>:<br />
				<input type="text" id="unit_per_case_per_pallet" name="unit_per_case_per_pallet" value="" class="span7" />
				<br />
				<strong>Measurement Per Unit</strong>:<br />
				<input type="text" id="number_of_unit_per_case" name="number_of_unit_per_case" value="" class="span7" />
				<br />
			</span>
			<span id="span_per_case" style="display:none;">
				<!-- <strong>Number of Unit</strong>:<br />
				<input type="text" id="number_of_unit_per_case" name="number_of_unit_per_case" value="" class="span7" />
				<br /> -->
				<strong>Unit Per Case</strong>:<br />
				<input type="text" id="unit_per_case" name="unit_per_case" value="" class="span7" />
				<br />
			</span>
			<span id="span_pack_per_case_size">
			<strong>Measurement:</strong>:<br />
			<select name="pack_per_case_size" id="pack_per_case_size" class="" title="Please select type">
				<option value="">Please Select</option>
				<option value="Pounds">Pounds</option>
				<option value="Oz">Oz</option>
				<option value="Gram">Gram</option>
				<option value="Gallon">Gallon</option>
				<option value="Quart">Quart</option>
				<option value="Pint">Pint</option>
				<option value="Cup">Cup</option>
				<option value="Liquid Oz">Liquid Oz</option>
				<option value="Liter">Liter</option>
			</select>
			</span>
		</div>
		<div>
			<strong>Price</strong>: <br /> <input type="text" id="price" name="price" class="span7 required" />
		</div>
		<!-- <div>
			<strong>Sold By</strong> :<br />
			<input type="text" id="pack_per_case" name="pack_per_case" value="" class="span7" size="5" />
			<select name="pack_per_case_size" id="pack_per_case_size" class="category" title="Please select type">
				<option value="">Please Select</option>
				<option value="Pounds">Pounds</option>
				<option value="Oz">Oz</option>
				<option value="Gram">Gram</option>
				<option value="Gallon">Gallon</option>
				<option value="Quart">Quart</option>
				<option value="Pint">Pint</option>
				<option value="Cup">Cup</option>
				<option value="Liquid Oz">Liquid Oz</option>
				<option value="Liter">Liter</option>
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
			<textarea name="percentage_discount" id="percentage_discount" class="" title="" rows="10" cols="40"></textarea>
		</div>
		<div>
			<strong>Take All Price</strong>:<br />
			<input type="text" id="take_all_price" name="take_all_price" value="" class="span7" />
		</div>
		<div>
			<strong>On Sale?</strong>:<br />
			<select name="on_sale" id="on_sale" class="required" title="Please select">
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
		</div>
		<div id="div_sale_price">
			<strong>Sale Price Discount</strong>:<br />
			<input type="text" id="sale_price" name="sale_price" value="" class="span7" /> %
		</div>
		<div>
			<strong>Type</strong>:<br />
			<select name="product_type" id="product_type" class="required" title="Please select type">
				<option value="">Please Select</option>
				<option value="normal">Normal</option>
				<option value="charity">Charity</option>
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
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
		</div>
		<div id="div_make_an_offer" style="display:none;">
			<div>
				<strong>Offer minimum amount</strong>:<br />
				<input type="text" id="make_an_offer_minimum_amount" name="make_an_offer_minimum_amount" value="" class="span7" />
			</div>
			<div>
				<strong>Offer minimum quantity</strong>:<br />
				<input type="text" id="make_an_offer_minimum_qty" name="make_an_offer_minimum_qty" value="" class="span7" />
			</div>
			<div>
				<strong>Offer auto accept amount</strong>:<br />
				<input type="text" id="make_an_offer_auto_accept_amount" name="make_an_offer_auto_accept_amount" value="" class="span7" />
			</div>
			<div>
				<strong>Offer auto accept quantity</strong>:<br />
				<input type="text" id="make_an_offer_auto_accept_qty" name="make_an_offer_auto_accept_qty" value="" class="span7" />
			</div>
		</div>
		<br />
		<div>
			<strong>Picture</strong>:<br />
			<input type="file" id="picture" name="picture" class="span7 required" />
		</div>
		<div>
			<h1>Shipping Details</h1>
		</div>
		<div>
			<strong>Height</strong>:<br />
			<input type="text" id="height" name="height" value="" class="span7 required" /> cm
		</div>
		<div>
			<strong>Length</strong>:<br />
			<input type="text" id="length" name="length" value="" class="span7 required" /> cm
		</div>
		<div>
			<strong>Width</strong>:<br />
			<input type="text" id="width" name="width" value="" class="span7 required" /> cm
		</div>
		<div>
			<strong>Weight</strong>:<br />
			<input type="text" id="weight" name="weight" value="" class="span7 required" /> lbs
		</div>
		<div>
			<br />
			<input type="checkbox" id="shipping_fee_included" name="shipping_fee_included" value="Yes" class="span7" /> <strong>Shipping Included (If shipping is not included in price, buyer will be responsible for shipping costs)</strong>
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
				<option value="<?php echo $country->country_name_short?>"><?php echo $country->country_name?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div>
			<strong>Description</strong>:<br />
			<textarea name="description" id="description" class="required" title="Please enter product description" rows="10" cols="40"></textarea>
		</div>

		<div>
			<br />
			<input type="checkbox" id="short_dated" name="short_dated" value="Yes" class="span7" /> <strong>Short Dated?</strong>
			<br />
		</div>

		<div id="div_expiration_date" style="display:none;">
			<strong>Expiration Date</strong>:<br />
			<input type="text" id="expiration_date" name="expiration_date" class="span7 datepicker" />
		</div>

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
			<option value="<?php echo $oa->user_address_id?>"><?php echo $oa->user_address_1?> <?php echo $oa->user_address_2?></option>
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
</div>
<?php form::close()?>

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
