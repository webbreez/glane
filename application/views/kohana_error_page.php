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
              
    });
</script>
</head>

<body class="mainbody">

<!-- header --><div class="wrapper headerdiv"><!-- header -->

<a href="<?php echo URL::site('index/products');?>" class="mainlogo"><!--B2B Opportunistic Grocery Exchange-->&nbsp;</a>


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



<div class="headerlinks2">
    <ul>
        <li><a href="https://logiclane.com/login">Sign in</a></li>
        <li><a href="<?php echo URL::site('register');?>">Register</a></li>
        <li><a href="<?php echo URL::site('advanced_search');?>">Advanced Search</a></li> 
        <li><a href="<?php echo URL::site('cart');?>">Cart</a></li> 
    <ul>
</div>


<div class="clearfix"></div>
<?php
/*
if(!$this->session->get("user_id"))
{
*/
?>
<!-- main menu -->
<div class="mainmenu">
    <ul>
        <li><a href="<?php echo URL::site('page/view/7/about-us');?>">About Us</a></li>
        <li><a href="<?php echo URL::site('page/view/2/first-time');?>">First Time?</a></li>
        <li><a href="<?php echo URL::site('page/view/3/seller');?>">Seller</a></li>
        <li><a href="<?php echo URL::site('page/view/4/buyer');?>">Buyer</a></li>
        <li><a href="<?php echo URL::site('page/view/5/faqs');?>">FAQs</a></li>
        <li><a href="<?php echo URL::site('page/view/8/contact-us');?>">Contact Us</a></li>
    </ul>
</div><!-- main menu -->
<?php
/*
}
*/
?>



<!-- header --><div class="clearfix"></div></div><!-- header -->


<div class="clearfix"></div>


<!-- body --><div class="wrapper contentdiv errpagenote"><!-- body -->

<br><br>

<p>We're very sorry, but LogicLane is experiencing some technical difficulties. Please accept our apologies.</p>

<p>Our team has been notified and will be correcting the issue as soon as possible.</p>

<p>Would you like to return to shopping <a href="https://logiclane.com/index/products">click here</a> or to your <a href="https://logiclane.com/cart">cart</a>? Would you like to contact our Customer Service Team? If so, please email <a href="mailto:support@logiclane.com">support@logiclane.com</a> to send email? Or, feel free to call us on 844.912.1870.</p>
<!-- body --><div class="clearfix"></div></div><!-- body -->


<!-- footer --><div class="wrapper footerdiv">

Copyright &copy; <?php echo date('Y'); ?> LogicLane LLC. &nbsp;&nbsp; All Rights Reserved. &nbsp;&nbsp;   <a href="<?php echo URL::site('page/view/9/terms-and-conditions');?>">Terms & Conditions</a>  |   <a href="<?php echo URL::site('page/view/11/privacy-policy');?>">Privacy Policy</a>  |  <a href="<?php echo URL::site('page/view/12/logiclane-guarantee');?>">LogicLane Guarantee</a> | <a href="mailto:support@logiclane.com">support@logiclane.com</a>

</div><!-- footer -->

</body>
</html>
