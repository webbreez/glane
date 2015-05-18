<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LogicLane - Opportunistic B2B Grocery Exchange</title>
<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.bxslider.min.js");?> 
<?php echo html::script("assets/js/jquery-ui.js");?> 
<?php echo html::script("assets/js/jquery-idleTimeout.js");?>

<?php echo html::stylesheet("assets/css/jquery-ui.css");?> 

<?php echo html::stylesheet("assets/css/style.css");?> 
<?php echo html::stylesheet("assets/css/stylemobile.css");?> 
<?php echo html::stylesheet("assets/fonts/stylesheet.css");?> 

<link rel="icon" type="image/png" href="<?php echo url::base();?>assets/images/favicon.ico">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53063238-1', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
    jQuery.noConflict()(function($){

        $(document).ready(function(){
           $(document).idleTimeout({
             inactivity: 1200000, 
             noconfirm: 1200000, 
             sessionAlive: 1200000
           });
        });


        $("#search").autocomplete({
            source: "<?php echo URL::site('index/find_products');?>",
            minLength: 1
        }); 

        $('#slider1').bxSlider({
            nextSelector: '#ssnext',
            prevSelector: '#ssprev',
            nextText: '',
            prevText: '',
            auto:true,
            mode:'fade',
            pager:false,
            controls:true,
            pause:5000
        });


$(".catmenu").click(function() {
$(".newmenu").slideToggle( "fast" );
$(".sm").toggleClass('sppt');
$(".sp").toggleClass('sppt');
   return false;
});



        $(".mmenus").click(function() {
        $(".mmdesktop").slideToggle( "fast" );
           return false;
        });



        $(".ccmenus").click(function() {
        $(".newmenu").slideToggle( "fast" );
           return false;
        });
              
    });
</script>
</head>

<body class="mainbody">

<!-- header --><div class="wrapper headerdiv"><!-- header -->

<a href="<?php echo URL::site('index/products');?>" class="mainlogo"></a>


<div class="searcharea">
    <?php echo form::open('index/search', array('id'=>'searchform'));?>
        <ul>
        <li>
            <input type="text" id="search" name="search" placeholder="Search Product" /> 
            <select name="search_category">
                <option value=""></option>
                <option value="brand">Brand</option>
                <option value="keyword">Keyword</option>
                <option value="90">90 days to Expiration Date</option>
                <option value="60">60 days to Expiration Date</option>
                <option value="30">30 days to Expiration Date</option>
            </select>
        </li>
        <li><button>Search</button></li>
        </ul>
    <?php echo form::close()?>
</div>

<div class="clearfix"></div>

<div class="newtaglines">CONTACT US - 1.844.912.1870 | <a href="mailto:support@logiclane.com">support@logiclane.com</a></div>
<div class="mobileclearing clearfix"></div>

<?php
if($this->session->get("user_id"))
{
?>
<div class="headerlinks2">
    <ul>
    <li>Welcome <?php echo $this->session->get("firstname")?> <?php echo $this->session->get("lastname")?>!<li>
   <!--  <li><a href="<?php echo URL::site('products');?>">My Products</a></li>
    <li><a href="<?php echo URL::site('legal_documents');?>">Legal Documents</a></li>
    <li><a href="<?php echo URL::site('items');?>">Products of Other Members</a></li>-->
    <li><a href="<?php echo URL::site('home');?>">My LogicLane</a></li> 
    <li><a href="<?php echo URL::site('advanced_search');?>">Advanced Search</a></li> 
    <li><a href="<?php echo URL::site('cart');?>">Cart</a></li> 
    <li><a href="<?php echo URL::site('logout');?>">Logout</a></li> 
    </ul>
</div>
<?php
}else{
?>
<div class="headerlinks2">
    <ul>
        <li><a href="https://logiclane.com/login">Sign in</a></li>
        <li><a href="<?php echo URL::site('register');?>">Register</a></li>
        <li><a href="<?php echo URL::site('advanced_search');?>">Advanced Search</a></li> 
        <li><a href="<?php echo URL::site('cart');?>">Cart</a></li> 
    <ul>
</div>
<?php
}
?>

<div class="clearfix"></div>

<!-- main menu -->
<a href="" class="mmenus mobileclearing">Main Menu</a>
<div class="mainmenu mmdesktop">
    <ul>
        <li><a href="<?php echo URL::site('page/view/7/about-us');?>">About Us</a></li>
        <li><a href="<?php echo URL::site('page/view/2/first-time');?>">First Time?</a></li>
        <li><a href="<?php echo URL::site('page/view/3/seller');?>">Seller</a></li>
        <li><a href="<?php echo URL::site('page/view/4/buyer');?>">Buyer</a></li>
        <li><a href="<?php echo URL::site('page/view/5/faqs');?>">FAQs</a></li>
        <li><a href="<?php echo URL::site('page/view/8/contact-us');?>">Contact Us</a></li>

        <li class="mobhide"><a href="" class="catmenu">Categories <span class="sp">+</span><span class="sm sppt">-</span></a></li>
    </ul>
</div><!-- main menu -->

<!-- new categories -->

<!-- mobile categories -->
<a href="" class="ccmenus mobileclearing">Categories</a>
<!-- mobile categories -->


<div class="newmenu">

<ul class="menu2cats">
<?php
foreach($category_1 as $category_1)
{
?>
<li><a href="<?php echo URL::site('product_category');?>/view/1/<?php echo $category_1->category_1_id?>/<?php echo url::title($category_1->category_1_name)?>"><?php echo $category_1->category_1_name?></a></li>
<?php
}
?>
</ul>

<div class="clearfix"></div></div>

<!-- new categories -->

<!-- header --><div class="clearfix"></div></div><!-- header -->


<div class="clearfix"></div>

<!-- header menu 2 <div class="wrapper headmenu2">



<div class="clearfix"></div>-->


<!-- featured slider --><div class="featuredslider" id="slider1">
 <?php
/*
foreach($featured_products as $fp)
{
?>
<!-- slide item -->
<div class="slideitem" style="background-image: url(<?php echo url::base();?>assets/upload/<?php echo $fp->banner?>);">
<a href="<?php echo URL::site('product_listing/details');?>/<?php echo $fp->product_id?>" class="detailsbutton detfeatured">details</a>
<button class="buybutton buffeatured" id="<?php echo $fp->product_id?>">Buy Now</button>
<span>Related Products</span>
<ul class="featuredrelated">
<li><a href="" style="background-image: url(<?php echo url::base();?>assets/images/tb1.jpg);">see details &raquo;</a></li>
<li><a href="" style="background-image: url(<?php echo url::base();?>assets/images/tb1.jpg);">see details &raquo;</a></li>
<li><a href="" style="background-image: url(<?php echo url::base();?>assets/images/tb1.jpg);">see details &raquo;</a></li>
<li><a href="" style="background-image: url(<?php echo url::base();?>assets/images/tb1.jpg);">see details &raquo;</a></li>
</ul>
</div><!-- slide item -->
<?php
}
*/
?>
</div><!-- featured slider -->


</div><!-- header menu 2 -->

<div class="clearfix"></div>

<?php
if($this->uri->segment(1) == "page" AND $this->uri->segment(3) == "8")
{
?>
<div class="cbanners">
    <img src="<?php echo url::base();?>assets/images/about-us.jpg" border="0" />
</div>
<?php
}
?>

<!-- body --><div class="wrapper contentdiv"><!-- body -->


<div class="clearfix spacer"></div>

<!-- main list product --><ul class="">

<!-- product item -->
<?php echo $content?>
<!-- product item -->


</ul><!-- main list product -->




<!-- body --><div class="clearfix"></div></div><!-- body -->

<!-- footer --><div class="wrapper footerdiv">

Copyright &copy; <?php echo date('Y'); ?> LogicLane LLC. &nbsp;&nbsp; All Rights Reserved. &nbsp;&nbsp;   <a href="<?php echo URL::site('page/view/9/terms-and-conditions');?>">Terms & Conditions</a>  |   <a href="<?php echo URL::site('page/view/11/privacy-policy');?>">Privacy Policy</a>  |  <a href="<?php echo URL::site('page/view/12/logiclane-guarantee');?>">LogicLane Guarantee</a> | <a href="mailto:support@logiclane.com">support@logiclane.com</a>

</div><!-- footer -->
<!-- 
<script id="IntercomSettingsScriptTag">
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
