<h1 class="spacedhead">FAQS</h1>

<?php
foreach($faqs as $f)
{
?>
<!-- product item -->
<li class="bgo0">
<div class="col1">
	<a href="<?php echo URL::site('faqs/view');?>/<?php echo $f->id?>/<?php echo url::title($f->title)?>">
	<?php echo $f->title?>
	</a>
</div>

<div class="clearfix"></div></li>
<!-- product item -->

<?php
}
?>