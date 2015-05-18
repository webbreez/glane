<h1 class="spacedhead">Select Shipping</h1>

<?php echo $shipping_info?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){
	$(".submit").click(function(){
		var id = "<?php echo $id?>";
		var cart_id = "<?php echo $cart_id?>";
		var shipment_details = $("input[name='shipment_details']:checked").val().split("|");

		var data = new Object();

		data.id = id;
		data.cart_id = cart_id;
		data.a = shipment_details[0];
		data.b = shipment_details[1];
		data.c = shipment_details[2];
		data.d = shipment_details[3];
		data.e = shipment_details[4];
		data.f = shipment_details[5];
		data.g = shipment_details[6];
		data.h = shipment_details[7];
		data.i = shipment_details[8];
		data.j = shipment_details[9];

		$.ajax({
	        url: '<?php echo URL::site("cart/save_shipment_details");?>',
	        type: 'post',
	       	data: data,
	        dataType: 'json',
	        success: function(data) {
	        	//parent.$.fancybox.close();
	        	window.top.location.reload();
	        }
	    });

	});
});
</script>