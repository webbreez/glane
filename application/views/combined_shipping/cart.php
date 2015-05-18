<h1 class="spacedhead">Cart<span class="spacedhead">Shipping Address</span><span class="spacedhead">Credit Card</span></h1>

<table border="0" cellpadding="2" cellspacing="2" width="100%">
<tr>
	<td width="40%"><strong>Product Name</strong></td>
	<td width="20%"><strong>Quantity</strong></td>
	<td width="30%"><strong>Price</strong></td>
	<td width="30%"><strong>Total</strong></td>
</tr>
<?php
$total = 0;
foreach($cart as $c)
{
	$take_all_price = $c->take_all_price ? $c->take_all_price : $c->price;
	$actual_product_qty = $c->actual_product_qty;

	//check if there is similar products that will be shipped on a different address and it has a take all quantity total
	$check_cart_take_all = $this->check_cart_take_all($c->product_id, $actual_product_qty);
	$multiple_take_all = "No";

	if($check_cart_take_all == "Yes")
	{
		$multiple_take_all = "Yes";
		$actual_price = $take_all_price;
		$price = $take_all_price  * $c->qty;
		$product_price = number_format($take_all_price, 2);
	}else{
		if($actual_product_qty == $c->qty)
		{
			$actual_price = $take_all_price;
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
		<br />
		<a href="<?php echo URL::site('cart/duplicate');?>/<?php echo $c->product_id?>">Click here to duplicate the product and send it to other shipping address</a>
	</td>
	<td>
		<input type="text" name="qty" class="qty" id="<?php echo $c->cart_item_id?>" value="<?php echo $c->qty?>" size="5">
	</td>
	<td>$ <?php echo $product_price?></span></td>
	<!-- <td><span id="price_<?php echo $c->cart_item_id?>" class="span_price"><?php echo number_format($price, 2)?></span></td> -->
	<td>$ <span id="price_<?php echo $c->cart_item_id?>" class="span_price">
		<?php 
			// $discount = productdiscount_helper::get_discount($c->product_id, $c->qty);
			// if($discount == 0)
			// {
			// 	echo number_format($price, 2);
			// }else{
			// 	echo $discount;
			// }

			if($multiple_take_all == "Yes")
			{
				$final_amount = $price;
				echo number_format($price, 2);
				$discount_label = "";
				$price_desc = "$".$take_all_price." take all price";
			}else{

				if($actual_product_qty == $c->qty)
				{
					$final_amount = $price;
					echo number_format($price, 2);
					$discount_label = "";
					$price_desc = "$".$take_all_price." take all price";
				}elseif($c->on_sale == "Yes")
				{
					$final_amount = $price;
					$da = ($final_amount * $c->sale_price) / 100;
					$sale_price = $final_amount - $da;

					$final_amount = $sale_price;

					if($c->percentage_discount)
					{
						$discounted_amount = 0;
						$amount = 0;
						$percentage_discount = $c->percentage_discount;
						$percentage_discount_main = explode("\n", trim($percentage_discount));
						foreach($percentage_discount_main as $pdm)
						{
							$percentage_discount_array = explode(" ", $pdm);
							$percentage_discount_items_array = explode("-", $percentage_discount_array[0]);
							$percentage_discount_items_from = $percentage_discount_items_array[0];
							$percentage_discount_items_to = $percentage_discount_items_array[1];
							if($c->qty >= $percentage_discount_items_from && $c->qty <= $percentage_discount_items_to){
								$discount = substr($percentage_discount_array[1], 0, 2);
								$pp = $product_price * $c->qty;
								$da = ($pp * $discount) / 100;
								$amount = $pp - $da;
								$discounted_amount = number_format($amount, 2);
							}
						}

						if($discounted_amount != 0)
						{
							$final_amount = $amount;
							echo $discounted_amount;
							$discount_label = "<span class=\"discount\" id=\"discount_$c->cart_item_id\" style=\"padding-left: 5px; color:red; font-size: 11px;\">($discount % discount)</span>";
							$price_desc = $discount." % discount";
						}else{
							echo number_format($final_amount, 2);
							$discount_label = "<span class=\"discount\" id=\"discount_$c->cart_item_id\" style=\"padding-left: 5px; color:red; font-size: 11px;\"></span>";
							$price_desc = "regular price";
						}
					}else{
						echo number_format($sale_price, 2);
						$discount_label = "";
						$price_desc = $da." % sale price";
					}

				}elseif($c->percentage_discount)
				{
					$discounted_amount = 0;
					$amount = 0;
					$percentage_discount = $c->percentage_discount;
					$percentage_discount_main = explode("\n", trim($percentage_discount));
					foreach($percentage_discount_main as $pdm)
					{
						$percentage_discount_array = explode(" ", $pdm);
						$percentage_discount_items_array = explode("-", $percentage_discount_array[0]);
						$percentage_discount_items_from = $percentage_discount_items_array[0];
						$percentage_discount_items_to = $percentage_discount_items_array[1];
						if($c->qty >= $percentage_discount_items_from && $c->qty <= $percentage_discount_items_to){
							$discount = substr($percentage_discount_array[1], 0, 2);
							$product_price = $c->price * $c->qty;
							$da = ($product_price * $discount) / 100;
							$amount = $product_price - $da;
							$discounted_amount = number_format($amount, 2);
						}
					}

					if($discounted_amount != 0)
					{
						$final_amount = $amount;
						echo $discounted_amount;
						$discount_label = "<span class=\"discount\" id=\"discount_$c->cart_item_id\" style=\"padding-left: 5px; color:red; font-size: 11px;\">($discount % discount)</span>";
						$price_desc = $discount." % discount";
					}else{
						$final_amount = $price;
						echo number_format($price, 2);
						$discount_label = "<span class=\"discount\" id=\"discount_$c->cart_item_id\" style=\"padding-left: 5px; color:red; font-size: 11px;\"></span>";
						$price_desc = "regular price";
					}
				}else{
					$final_amount = $price;
					echo number_format($price, 2);
					$discount_label = "<span class=\"discount\" id=\"discount_$c->cart_item_id\" style=\"padding-left: 5px; color:red; font-size: 11px;\"></span>";
					$price_desc = "regular price";
				}
			}
		?>
	</span><?php echo $discount_label?></td>
	<input type="hidden" id="hidden_price_<?php echo $c->cart_item_id?>" value="<?php echo $actual_price?>">
</tr>
<?php
	//$this->update_cart_product_price($c->cart_item_id, $product_price, $final_amount, $price_desc, $actual_product_qty);

	$total = $total + $final_amount;
}
?>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><strong>Total</strong></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><strong><span id="total">$ <?php echo number_format($total, 2)?></span></strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<?php
if($check_cart_qty)
{
?>
<tr>
	<td>&nbsp;</td>
	<td colspan="3" align="right"><span style="color: red;"><?php echo $check_cart_qty?></span></td>
</tr>
<?php
}
?>
<tr>
	<td colspan="4" align="right">
		<button id="checkout">Checkout</button>&nbsp;
		<button id="continue_shopping">Continue Shopping</button>&nbsp;
		<button id="similar_address">View Products with the same Seller and same Address</button>
	</td>
</tr>
</table>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){
	$("#checkout").click(function(){
		<?php
		/*
		if($this->session->get("user_id") && $this->session->get("user_status") == 1)
		{
		?>
			var data = new Object();
			$.ajax({
	        url: '<?php echo URL::site("cart/check_minimum_purchase");?>',
	        type: 'post',
	       	data: data,
	        dataType: 'json',
	        success: function(data) {
	        	if(data.error == "N")
	        	{
		        	location.href="<?php echo URL::site('cart/shipping_address');?>/";
					return false;
				}else{
					alert(data.error_msg);
					return false;
				}
	        }
	    });

			
		<?
		}else{
		?>
			location.href="<?php echo URL::site('login/index/cart');?>/";
			return false;
		<?php
		}	*/
		?>
	});

	$("#continue_shopping").click(function(){
		location.href="<?php echo URL::site('index/products');?>/";
	});

	$("#similar_address").click(function(){
		location.href="<?php echo URL::site('combined_shipping/products');?>/<?php echo $this->uri->segment(3)?>";
	});

	$(".qty").blur(function(){
		var id = $(this).attr('id');
		var val = $(this).val();
		var price = $("#hidden_price_"+id).val();
		var new_price = parseFloat(price) * parseFloat(val);
		var np = Number(new_price).toFixed(2);

		// $("#price_"+id).html(np);

		// var total = 0;
		// $("span.span_price").each(function() {
		// 	var p = $(this).text();
		// 	total = parseFloat(total) + parseFloat(p);
		// });

		// var tt = Number(total).toFixed(2);
		// $("#total").html(tt);

		var data = new Object();

		data.id = id;
		data.qty = val;
		$.ajax({
	        url: '<?php echo URL::site("cart/update_qty");?>',
	        type: 'post',
	       	data: data,
	        dataType: 'json',
	        success: function(data) {
	        	if(data.error == "Y")
	        	{
	        		alert(data.error_msg);
	        		location.href="<?php echo URL::site('combined_shipping/cart');?>/<?php echo $this->uri->segment(3)?>";
	        		return false;
	        	}

	        	location.href="<?php echo URL::site('combined_shipping/cart');?>/<?php echo $this->uri->segment(3)?>";
	        	return false;
	        	
	        	if(data.discount)
	        	{
	        		$("#price_"+id).html(data.amount);
	        		$("#discount_"+id).html(data.discount);
	        	}else{
	        		$("#price_"+id).html(data.amount);
	        		$("#discount_"+id).html("");
	        	}

	        	var total = 0;
				$("span.span_price").each(function() {
					var p = $(this).text().replace(",","");
					total = parseFloat(total) + parseFloat(p);
				});

				var tt = Number(total).toFixed(2);
				$("#total").html(tt);

	        	if(data.remove == "Y")
	        	{
	        		$("#tr_"+data.id).hide("slow");
	        	}
	        }
	    });
	});
});
</script>