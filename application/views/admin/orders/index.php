<h3>Search Orders</h3>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td valign="top" width="35%">
			<form name="search" method="GET" action="<?php echo URL::site('admin/orders/index');?>">
			<table width="100%" border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td>Order ID: </td>
				<td><input type="text" name="order_id" value="<?php echo $this->input->get("order_id")?>"></td>
			</tr>
<!-- 			<tr>
				<td>Company: </td>
				<td><input type="text" name="company" value="<?php echo $this->input->get("company")?>"></td>
			</tr> -->
			<tr>
				<td>First Name: </td>
				<td><input type="text" name="firstname" value="<?php echo $this->input->get("firstname")?>"></td>
			</tr>
			<tr>
				<td>Last Name: </td>
				<td><input type="text" name="lastname" value="<?php echo $this->input->get("lastname")?>"></td>
			</tr>
			<tr>
				<td>Email: </td>
				<td><input type="text" name="email" value="<?php echo $this->input->get("email")?>"></td>
			</tr>
			<tr>
				<td valign="top">Date Ordered: </td>
				<td>From: <br /><input type="text" name="date_from" value="<?php echo $this->input->get("date_from")?>" class="datepicker"> <br />To: <br /><input type="text" name="date_to" value="<?php echo $this->input->get("date_to")?>" class="datepicker"></td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit" value="Search"></td>
			</tr>
			</table>
			</form>
		</td>
		<td valign="top" width="65%">
			<table width="100%" border="1" cellpadding="2" cellspacing="2">
			<?php
			if($count_orders > 0)
			{
				?>
				<tr>
					<td><strong>Order ID</strong></td>
					<td><strong>Name</strong></td>
					<td><strong>Status</strong></td>
					<td><strong>Order Date</strong></td>
					<td>&nbsp;</td>
				</tr>
				<?php
				foreach($orders as $order)
				{
			?>
				<tr>
					<td><?php echo $order->uniq_id?></td>
					<td><?php echo $order->firstname?> <?php echo $order->lastname?></td>
					<td><?php echo $order->status?></td>
					<td><?php echo date("m/d/Y", $order->date_added)?></td>
					<td><a href="<?php echo URL::site("admin/orders/view/$order->uniq_id/$order->user_id");?>" target="_blank">VIEW</a></td>
				</tr>
			<?
				}
			}elseif($count_orders == 0)
			{
			?>
				<tr>
					<td colspan="5"><strong>No Result found...</strong></td>
				</tr>
			<?php
			}
			?>
			</table>
		</td>
	</tr>
</table>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery-ui.js");?> 
<?php echo html::stylesheet("assets/css/jquery-ui.css");?> 

<script type="text/javascript">
$(document).ready(function(){
	$(".datepicker").datepicker();
});
</script>