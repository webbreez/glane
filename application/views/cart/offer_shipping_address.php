<h1 class="spacedhead">Cart<span class="spacedhead">Shipping Address</span><span class="spacedhead">Credit Card</span></h1>

<table border="0" cellpadding="2" cellspacing="2" width="100%">
<tr>
	<td width="30%"><strong>Product Name</strong></td>
	<td width="20%"><strong>Quantity</strong></td>
	<!-- <td width="20%"><strong>Price</strong></td> -->
	<td width="20%"><strong>Total</strong></td>
	<td width="10%"><strong>Shipping Fee</strong></td>
	<td width="20%"><strong>Shipping Address</strong></td>
</tr>
<?php
$total = 0;
$total_shipping_fee = 0;
$grand_total = 0;
foreach($cart as $c)
{
	$actual_price = $c->price;
	$price = $c->price * $c->qty;
	$total_shipping_fee = $total_shipping_fee + $c->shipping_fee;

	$take_all_price = $c->take_all_price ? $c->take_all_price : $c->price;
	$actual_product_qty = $c->actual_product_qty;

	if($actual_product_qty == $c->qty)
	{
		$actual_price = $actual_product_qty;
		$price = $take_all_price  * $c->qty;
		$product_price = number_format($take_all_price, 2);
	}elseif($c->on_sale == "Yes")
	{
		$actual_price = $c->price;
		$price = $c->price * $c->qty;
		$da = ($actual_price * $c->sale_price) / 100;
		$product_price = $actual_price - $da;
	}else{
		$actual_price = $c->price;
		$price = $c->price * $c->qty;
		$product_price = number_format($c->price, 2);
	}

?>
<tr id="tr_<?php echo $c->cart_item_id?>">
	<td>
		<?php
		$picture = productpicture_helper::get_product_picture($c->product_id);

		if($picture)
		{
		?>
		<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/upload/<?php echo $picture?>&w=75&h=45&zc=2" border="0" />
		<?php
		}else{
		?>
		<img src="<?php echo url::base();?>timthumb.php?src=<?php echo url::base();?>assets/images/no_image.jpg&w=75&h=45&zc=2" border="0" />
		<?php
		}
		?>
		<?php echo $c->product_name?>
	</td>
	<td><?php echo $c->offer_qty?></td>
	<!-- <td>$ <?php echo $product_price?></span></td> -->
	<!-- <td><span id="price_<?php echo $c->cart_item_id?>" class="span_price"><?php echo number_format($price, 2)?></span></td> -->
	<td>$ <?php echo $c->offer_total_price?></td>
	<td>$ <?php echo number_format($c->shipping_fee, 2)?></td>
	<td>
		<?php
			$shipping_fee_included = $c->shipping_fee_included ? $c->shipping_fee_included : 'No';
		?>
		<select name="shipping_address" id="product_pickup_address" class="shipping_address category required" rel="<?php echo $shipping_fee_included?>">
			<option value="0">Please Select</option>
			<?php
			foreach($shipping as $s)
			{
			?>
			<option value="<?php echo $s->user_address_id?>|<?php echo $c->qty?>|<?php echo $c->cart_item_id?>" <?php echo $s->user_address_id == $c->shipping_address_id ? "selected=selected" : ""?>><?php echo $s->user_address_1?> <?php echo $s->user_address_2?></option>
			<?
			}
			?>
		</select>
	</td>
</tr>
<?php
	//$total = $total + $final_amount;
	$total = $c->offer_total_price;
	$grand_total = $total + $total_shipping_fee;
	$total_qty = $c->offer_qty;
}
?>
<tr>
	<td>&nbsp;</td>
	<!-- <td>&nbsp;</td> -->
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><strong>Total</strong></td>
	<!-- <td>&nbsp;</td> -->
	<td><strong>$ <span id="total"><?php echo number_format($total, 2)?></span></strong></td>
	<td>&nbsp;</td>
	<td>&nbsp;<!-- <strong>$ <span class="total_shipping_fee"><?php echo number_format($total_shipping_fee, 2)?></span></strong> --></td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><strong>Shipping Fee</strong></td>
	<!-- <td>&nbsp;</td> -->
	<td><strong>$ <span class="total_shipping_fee"><?php echo number_format($total_shipping_fee, 2)?></span></strong></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><strong>Grand Total</strong></td>
	<!-- <td>&nbsp;</td> -->
	<td><strong>$ <span id="grand_total"><?php echo number_format($grand_total, 2)?></span></strong></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="5" align="right"><button id="proceed_to_cc">Proceed to Credit Card Information</button></td>
</tr>
</table>

<?php echo html::script("assets/js/jquery-1.11.0.min.js");?> 
<?php echo html::script("assets/fancybox/jquery.fancybox.pack.js?v=2.1.5");?>
<?php echo html::stylesheet("assets/fancybox/jquery.fancybox.css?v=2.1.5");?> 	
<script type="text/javascript">
$(document).ready(function(){
	$("#shipping_address2").change(function(){
		var id = $(this).val();

		$("#shipping_info").html('<span style="padding-left:40px;"><img src="<?php echo url::base();?>assets/images/ajax-loader.gif"></span>');

		if(id == 0)
		{
			$("#address_1").html("");
        	$("#address_2").html("");
        	$("#city").html("");
        	$("#state").html("");
        	$("#zip").html("");
        	$("#shipping_info").html("");
        	return false;
		}

		var data = new Object();
		data.id = id;
		data.qty = "<?php echo $total_qty?>";
		data.total = "<?php echo $total?>";

		$.ajax({
	        url: '<?php echo URL::site("cart/get_shipping_address");?>',
	        type: 'post',
	       	data: data,
	        dataType: 'json',
	        success: function(data) {
	        	$("#address_1").html(data.address_1);
	        	$("#address_2").html(data.address_2);
	        	$("#city").html(data.city);
	        	$("#state").html(data.state);
	        	$("#zip").html(data.zip);
	        	$("#shipping_info").html(data.shipping_info);
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	        	$("#shipping_info").html("There was an error while getting the shipping information, please try again.");
	        }
	    });
	});

	$(".shipping_address").change(function(){
		var vars = $(this).val().split("|");
		var id = vars[0];
		var qty = vars[1];
		var cart_id = vars[2];

		var rel = $(this).attr("rel");
		if(rel == "Yes")
		{
			var data = new Object();
			data.shipping_address_id = id;
			data.cart_id = cart_id;
			$.ajax({
		        url: '<?php echo URL::site("cart/update_cart_shipping_address");?>',
		        type: 'post',
		       	data: data,
		        success: function(data) {
		        }
		    });
			return false;
		}

		if(id == 0)
		{
			return false;
		}

		$.fancybox.open({
			href: "<?php echo URL::site('cart/get_shipping_address');?>/"+id+"/"+qty+"/"+cart_id,
			type : 'iframe',
			width : 600,
			height : 450,
			helpers     : { 
		        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		    }
		});

	});


	$("#proceed_to_cc").click(function(){
		// var shipping = $("#shipping_address").val();
		// if(shipping == 0)
		// {
		// 	alert("Please select a shipping address.");
		// 	return false;
		// }

		// var shipment_details = $("input[name='shipment_details']:checked").val();

		var data = new Object();
		// data.id = shipping;
		// data.shipment_details = shipment_details;
		data.product_id = "<?php echo $c->product_id?>";

		$.ajax({
	        url: '<?php echo URL::site("cart/save_cart_shipping_address_offer");?>',
	        type: 'post',
	       	data: data,
	        dataType: 'json',
	        success: function(data) {
	        	if(data.error == "Y")
	        	{
	        		alert(data.error_msg);
	        		return false;
	        	}else{
	        		location.href="<?php echo URL::site('cart/credit_card_offer');?>/"+data.uniq_id+"/<?php echo $offer_id?>";
	        		return false;
	        	}
	        }
	    });

		
	});
});
</script>