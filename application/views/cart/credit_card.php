<h1 class="spacedhead">Cart<span class="spacedhead">Shipping Address</span><span class="spacedhead">Credit Card</span></h1>

<table border="0" cellpadding="2" cellspacing="2" width="80%">
<tr>
	<td>Credit Card Number:</td>
	<td><input type="text" name="credit_card_number" id="credit_card_number"></td>
	<td><span id="error_message"></span></td>
</tr>
<tr>
	<td>Expiration Date:</td>
	<td>
		<?php
		$m = date("m"); 
		?>
		<select name="month" id="month">
			<option value="01" <?php echo $m == "01" ? "selected=selected" : ''?>>January</option>
			<option value="02" <?php echo $m == "02" ? "selected=selected" : ''?>>February</option>
			<option value="03" <?php echo $m == "03" ? "selected=selected" : ''?>>March</option>
			<option value="04" <?php echo $m == "04" ? "selected=selected" : ''?>>April</option>
			<option value="05" <?php echo $m == "05" ? "selected=selected" : ''?>>May</option>
			<option value="06" <?php echo $m == "06" ? "selected=selected" : ''?>>June</option>
			<option value="07" <?php echo $m == "07" ? "selected=selected" : ''?>>July</option>
			<option value="08" <?php echo $m == "08" ? "selected=selected" : ''?>>August</option>
			<option value="09" <?php echo $m == "09" ? "selected=selected" : ''?>>September</option>
			<option value="10" <?php echo $m == "10" ? "selected=selected" : ''?>>October</option>
			<option value="11" <?php echo $m == "11" ? "selected=selected" : ''?>>November</option>
			<option value="12" <?php echo $m == "12" ? "selected=selected" : ''?>>December</option>
		</select>
		&nbsp;
		<select name="year" id="year">
			<?php
			$year = date('Y');
			$year_plus_5 = $year + 5;
			for ($x=$year; $x<=$year_plus_5;) {
			?>
			<option value="<?php echo $x?>"><?php echo $x?></option>
			<?php
			$x++;
			}
			?>
		</select>
</tr>
<tr>
	<td>CCV:</td>
	<td><input type="text" name="ccv" id="ccv" value="" size="5" maxlength="3"></td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><button id="proceed_final">Proceed</button></td>
</tr>
</table>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){
	$("#proceed_final").click(function(){
		var credit_card_number = $("#credit_card_number").val();
		var month = $("#month").val();
		var year = $("#year").val();
		var ccv = $("#ccv").val();

		$("#error_message").html("");

		if(credit_card_number == "")
		{
			$("#error_message").append("Credit Card Number should not be blank.");
			return false;
		}

		if(month == "")
		{
			$("#error_message").append("Month should not be blank.");
			return false;
		}

		if(year == "")
		{
			$("#error_message").append("Year should not be blank.");
			return false;
		}

		if(ccv == "")
		{
			$("#error_message").append("CCV should not be blank.");
			return false;
		}

		var data = new Object();
		data.uniqid = "<?php echo $this->uri->segment(3)?>";

		$.ajax({
	        url: '<?php echo URL::site("cart/proceed_to_payment");?>',
	        type: 'post',
	       	data: data,
	        dataType: 'json',
	        success: function(data) {
	        	///location.href="<?php echo URL::site('payment/process.php');?>?total="+data.total+"&uniqid="+data.uniqid;
	        	location.href="<?php echo URL::site('cart/order_processed');?>/"+data.total+"/"+data.uniqid;
	        }
	    });

		
	});
});
</script>