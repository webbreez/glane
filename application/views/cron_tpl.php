<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LogicLane</title>
<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<?php echo html::script("assets/js/additional-methods.js");?>
<?php echo html::script("assets/bootstrap/js/bootstrap.min.js");?>
        
<?php echo html::stylesheet("assets/css/style.css");?> 
<?php echo html::stylesheet("assets/css/stylemobile.css");?> 
<?php echo html::stylesheet("assets/fonts/stylesheet.css");?>   
<script type="text/javascript">
    jQuery.noConflict()(function($){


        $(".mmenus").click(function() {
        $(".mmdesktop").slideToggle( "fast" );
           return false;
        });
              
    });
</script>  

<link rel="icon" type="image/png" href="<?php echo url::base();?>assets/images/favicon.ico">
</head>

<body class="logibody">


<!-- header --><div class="wrapper loginheaderdiv"><!-- header -->
<a href="<?php echo URL::site('home');?>" class="mainlogo"></a>

<div class="taglines">Opportunistic B2B Grocery Exchange</div>



<!-- header --><div class="clearfix"></div></div><!-- header -->
<a href="" class="mmenus mobileclearing">Main Menu</a>
<div class="menucontainer mmdesktop">
<ul class="normlinks">
<li><a href="<?php echo URL::site('page/view/7/about-us');?>">About Us</a></li>
<li><a href="<?php echo URL::site('page/view/4/buyer');?>">Buyers</a></li>
<li><a href="<?php echo URL::site('page/view/3/seller');?>">Sellers</a></li>
<li><a href="">Charities</a></li>
<li><a href="<?php echo URL::site('page/view/5/faqs');?>">FAQ</a></li>
<li><a href="<?php echo URL::site('page/view/8/contact-us');?>">Contact Us</a></li>
</ul>
</div>




<div class="loginarea">



<div class="wrapper loginbox">



<div class="clearfix"></div>
</div>


</div>


<!-- footer --><div class="wrapper footerdiv">

Copyright &copy; <?php echo date('Y'); ?> LogicLane LLC. &nbsp;&nbsp; All Rights Reserved. &nbsp;&nbsp;   <a href="http://logiclane.com/admin/page/edit/9">User Agreement</a>  |   <a href="http://logiclane.com/admin/page/edit/9">Privacy Policy</a>  |  <a href="http://logiclane.com/admin/page/edit/9">Sales & Donations Policy</a>

</div>
</body>
</html>
