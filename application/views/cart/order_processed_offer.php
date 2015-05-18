<table border="0" cellpadding="2" cellspacing="2" width="100%">
	<tr>
		<td colspan="3"><h1 class="spacedhead">Your order has been processed. Please check your email for confirmation.</h1></td>
	</tr>
	<tr>
		<td colspan="3"><h1 class="spacedhead">Your order transaction id is <?php echo $this->uri->segment(4)?>.</h1></td>
	</tr>
</table>

<br />
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
	<!-- <td><span id="price_<?php echo $c->cart_item_id?>" class="span_price"><?php echo number_format($price, 2)?></span></td> -->
	<td>$ <?php echo $c->offer_total_price;?></td>
	<td>$ <?php echo number_format($c->shipping_fee, 2)?></td>
	<td>
		<select name="shipping_address" id="product_pickup_address" class="shipping_address category required" disabled="disabled">
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
</table>