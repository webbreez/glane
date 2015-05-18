<div class="clearfix spacer"></div>
<h1 class="spacedhead linebottom">Welcome back <?php echo $this->session->get("firstname")?> <?php echo $this->session->get("lastname")?>!
<?php
if($this->session->get("user_status") == "2")
{
?>
<br />
<span style="color:red;">(Your Application is still Pending and needs approval by the Admin.)</span>
<?php
}
?>
</h1>
<div class="clearfix spacer"></div>


<!-- col 1 --><div class="memcol1">

<ul class="normalform blockedbar">
<li><a href="<?php echo URL::site('home');?>">Home</a></li>
<!-- <li><a href="<?php echo URL::site('my_basket');?>">My Basket</a></li> -->
<li><a href="<?php echo URL::site('profile');?>">Edit Profile</a></li>
<li><a href="<?php echo URL::site('address');?>">My Addresses</a></li>
<?php
if(($this->session->get('user_type') == "vendor" || $this->session->get('user_type') == "vendor/buyer") && $this->session->get('user_status') == 1)
{
?>
<li><a href="<?php echo URL::site('products');?>">Items I'm Selling</a></li>
<?php
}
?>

<?php
if(($this->session->get('user_type') == "vendor" || $this->session->get('user_type') == "buyer" || $this->session->get('user_type') == "vendor/buyer") && $this->session->get('user_status') == 1)
{
?>
<li><a href="<?php echo URL::site('my_orders/');?>">My Orders</a></li>
<li><a href="<?php echo URL::site('my_sales/');?>">My Sales</a></li>
<?php
}
?>

<li><a href="<?php echo URL::site('items/watching');?>">Items I'm Watching</a></li>
<li><a href="<?php echo URL::site('legal_documents');?>">Legal Documents</a></li>
</ul>

<div class="clearfix spacer"></div>
<h1 class="spacedhead">Notifications!</h1>
<div class="clearfix spacer"></div>


<ul class="normalform">
<?php
foreach($notifications as $n)
{
?>
<li><a href="<?php echo URL::site("products/offers/$n->product_id");?>"><?php echo $n->product_name?></a></li>
<?php
}
?>
</ul>

</div><!-- col 1 -->


<!-- col 2 --><div class="memcol2">
<!-- 
<div class="roundgreyborder">My Orders</div> -->

</div><!-- col 2 -->