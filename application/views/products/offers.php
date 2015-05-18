<h1 class="spacedhead">>Offers for <?php echo $product->product_name;?></h1>
<div>
	Brand: <?php echo $product->brand?>
</div>
<div>
	Product: <?php echo $product->product_name?>
</div>

<br />
<?php
foreach($offers as $row)
{
	$offer_id = $row->offer_id;
	$product_id = $row->product_id;
	$amount = $row->amount;
	$qty = $row->qty;
	$offerred_by_user_id = $row->offered_by_user_id;
	$firstname = $row->firstname;
	$lastname = $row->lastname;
	$date_added = date("M d, Y", strtotime($row->date_added));
	$approved = $row->approved;
	$active = $row->active;

	$offered_by_owner_id = $row->offered_by_owner_id;
	if($offered_by_owner_id != 0)
	{
		$offer_by_name = $this->offer_by_name($offered_by_owner_id);
	}else{
		$offer_by_name = $firstname.' '.$lastname;
	}

	if($row->amount >= $product->make_an_offer_minimum_amount AND $row->qty >= $product->make_an_offer_minimum_qty)
	{
		if($offerred_by_user_id == $this->session->get('user_id') OR $this->session->get('user_id') == $owner_id)
		{
?>
	<div id="<?php echo $offer_id?>">
		<?php echo $offer_by_name?><br />
		Original Price : $<?php echo $product->price?> <br />
		Offer Price : $<?php echo $amount?> <br />
		<?php
		if($product->qty_type == "Pallet")
		{
		?>
		Sold By : <?php echo $product->number_of_cases_per_pallet?> Cases / <?php echo $product->qty_type?> <br />
		<?php
		}else{
		?>
		Sold By : Pack Per Case <?php echo $product->pack_per_case?> <?php echo $product->pack_per_case_size?> <br />
		<?php
		}
		?>
		Quantity Offer : <?php echo $qty?> <br />
		Quantity Available : <?php echo $product->qty?> <br />
		Date Submitted :  <?php echo $date_added?><br />
		<?php
		if($approved == "N" && $active == "Y" && ($offerred_by_user_id != $this->session->get('user_id') || $offered_by_owner_id != 0) )
		{
		?>
			<?php
			if($offered_by_owner_id != $this->session->get('user_id'))
			{
			?>
			<button class="accept" id="<?php echo $offer_id?>">ACCEPT</button> &nbsp; 
			<button class="decline" id="<?php echo $offer_id?>">REJECT OFFER</button> &nbsp; 
			<button class="counter_offer" id="<?php echo $product_id?>|<?php echo $offerred_by_user_id?>">MAKE COUNTER OFFER</button>
			<?php
			}
			?>

			<?php
			if($row->retracted == "N" AND $this->session->get('user_id') == $owner_id AND $offered_by_owner_id != 0)
			{
			?>
			<button class="retract" id="<?php echo $offer_id?>">RETRACT YOUR OFFER</button> 
			<?php	
			}
		}elseif($row->retracted == "N" AND $offerred_by_user_id == $this->session->get('user_id') AND $approved == "N" AND $active == "Y"){
		?>
			<button class="retract" id="<?php echo $offer_id?>">RETRACT YOUR OFFER</button> 
		<?
		}elseif($approved == "Y" AND $row->checkout == "No"){
		?>
			<p style="color:red;">This Offer has been approved... 
			<?php
			if($offerred_by_user_id == $this->session->get('user_id'))
			{
			?>
			<br /> <button class="checkout_now" id="<?php echo $offer_id?>">CHECKOUT NOW</button></p>
			<?php
			}
			?>
		<?php
		}elseif($active == "N"){
		?>
			<p style="color:red;">This Offer has been declined...</p>
		<?php
		}elseif($row->checkout == "Yes"){
		?>
			<p style="color:red;">This Offer has been checkout...</p>
		<?php
		}/*elseif($offerred_by_user_id == $this->session->get('user_id'))
		{
		?>
			<p style="color:red;">Your Offer</p>
		<?php
		}*/
		?>
	</div>
	<br />
<?php
		}
	}
}
?>
<br />
<style>
.fancybox-inner {
    overflow: hidden !important;
}
</style>
<?php echo html::script("assets/js/jquery-1.11.0.min.js");?> 
<?php echo html::script("assets/fancybox/jquery.fancybox.pack.js?v=2.1.5");?>
<?php echo html::stylesheet("assets/fancybox/jquery.fancybox.css?v=2.1.5");?> 	
<script type="text/javascript">
$(document).ready(function(){

	$(".checkout_now").click(function(){
		var id = $(this).attr('id');
		location.href="<?php echo URL::site('cart/checkout_offer');?>/"+id;
	});

	$(".retract").click(function(){
		var id = $(this).attr('id');
		data = new  Object();
		data.id = id;

		$.ajax({
			type: "POST",
			data: data,
			url: '<?php echo URL::site('products/retract_offer');?>',
			success: function(data) {
				$("div#"+id).hide("slow");
			}
		});
	});

	$(".decline").click(function(){
		var id = $(this).attr('id');
		data = new  Object();
		data.id = id;

		$.ajax({
			type: "POST",
			data: data,
			url: '<?php echo URL::site('products/decline_offer');?>',
			success: function(data) {
				$("div#"+id).hide("slow");
			}
		});
	});

	$(".accept").click(function(){
		var id = $(this).attr('id');
		data = new  Object();
		data.id = id;

		$.ajax({
			type: "POST",
			data: data,
			url: '<?php echo URL::site('products/accept_offer');?>',
			success: function(data) {
				$("div#"+id).hide("slow");
			}
		});
	});

	$(".counter_offer").click(function() {
		var id_array = $(this).attr('id').split('|');
		var product_id = id_array[0];
		var offerred_by_user_id = id_array[1];
		<?php
		if($this->session->get("user_id"))
		{
		?>
		$.fancybox.open({
			href: "<?php echo URL::site('items/make_counter_offer');?>/"+product_id+'/'+offerred_by_user_id,
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

});
</script>