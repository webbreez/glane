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
<div class="clearfix"></div>

<div class="newtaglines">CONTACT US - 1.844.912.1870 | <a href="mailto:support@logiclane.com">support@logiclane.com</a></div>
<div class="mobileclearing clearfix"></div>



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


<?php echo $content;?>


<div class="clearfix"></div>
</div>


</div>


<!-- footer --><div class="wrapper footerdiv">

Copyright &copy; <?php echo date('Y'); ?> LogicLane LLC. &nbsp;&nbsp; All Rights Reserved. &nbsp;&nbsp;   <a href="<?php echo URL::site('page/view/9/terms-and-conditions');?>">Terms & Conditions</a>  |   <a href="<?php echo URL::site('page/view/11/privacy-policy');?>">Privacy Policy</a>  |  <a href="<?php echo URL::site('page/view/12/logiclane-guarantee');?>">LogicLane Guarantee</a> | <a href="mailto:support@logiclane.com">support@logiclane.com</a>

</div><!-- footer -->

<!-- <script id="IntercomSettingsScriptTag">
  window.intercomSettings = {
    // TODO: The current logged in user's full name
    name: "Support",
    // TODO: The current logged in user's email address.
    email: "support@logiclane.com",
    // TODO: The current logged in user's sign-up date as a Unix timestamp.
    created_at: <?php $created_at = strtotime("08/21/14"); echo $created_at;?>,
    app_id: "9c4yt6j3"
};
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://static.intercomcdn.com/intercom.v1.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
-->
</body>
</html>
