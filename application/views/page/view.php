<?php
if($this->uri->segment(1) == "page" AND $this->uri->segment(3) == "5")
{
?>
<style>
.faqlinklist{ 
list-style:none;
padding:0px;
margin:0px 0px 60px 0px;
position:relative;
}

.faqlinklist li a {
padding:0px;
margin:0px 0px 12px 0px; 
font-size:14px;
text-decoration:none;
}

.faqitem span { 
position:relative;
font-size:17px;
font-weight:bold;
padding:0px;
margin:0px 0px 10px 0px;
}

.faqitem { 
position:relative;
padding:0px;
margin:0px 0px 40px 0px;
}
</style>
<?php
}
?>
<h1 class="spacedhead"><?php echo $content->title?></h1>
<div class="clearfix spacer"></div>

<?php echo $content->content?>