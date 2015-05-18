<h1 class="spacedhead"><?php echo $product->product_name?> Related Products</h1>
<br style="clear:both;"><br style="clear:both;">
<div style="">
	<div style="float: left; padding-left: 20px;"><h1>All Products</h1></div>
	<div style="float: left; padding-left: 50px;"><h1>Related Products</h1></div>
</div>
<br style="clear:both;">

<div style="padding-left: 30px; padding-top: 20px;">

<ul id="sortable1" class="connectedSortable">
<?php
foreach($products as $p)
{
	reset($rp_ids);
	if($p->product_id != $this->uri->segment(3) && !array_key_exists($p->product_id, $rp_ids))
	{
	?>
	<li class="ui-state-default" id="<?php echo $p->product_id?>"><?php echo $p->product_name?></li>
	<?php
	}
}
?>
</ul>

<ul id="sortable2" class="connectedSortable">
<?php
foreach($related_products as $rp)
{
?>
<li class="ui-state-default" id="<?php echo $rp->product_id?>"><?php echo $rp->product_name?></li>
<?php
}
?>
</ul>

</div>
<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery-ui.js");?> 
<?php echo html::stylesheet("assets/css/jquery-ui.css");?> 
<style>
#sortable1, #sortable2 {
border: 1px solid #eee;
width: 142px;
min-height: 20px;
list-style-type: none;
margin: 0;
padding: 5px 0 0 0;
float: left;
margin-right: 10px;
}
#sortable1 li, #sortable2 li {
margin: 0 5px 5px 5px;
padding: 5px;
font-size: 1.2em;
width: 120px;
}
</style>
<script type="text/javascript">
$(function() {
	$( "#sortable1, #sortable2" ).sortable({
		connectWith: ".connectedSortable",
		receive: function(event, ui) {
	     //console.log(ui.item[0].id);
	     var id = ui.item[0].id;
	     $.post('<?php echo url::site()?>products/add_related_product/', {id: id, main_product_id: <?php echo $this->uri->segment(3)?>}, function(data) {
	        
	     });
	   }
	});
});
</script>
