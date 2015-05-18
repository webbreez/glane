<div class="clearfix spacer"></div>
<h1 class="spacedhead">Legal Documentation</h1>
<div class="clearfix spacer"></div>

<div id="notice" class="alert-error alert" style="display:none;">
	<div id="notice_msg"></div>
	<div>
	</div>
	<br />
</div>

<?php echo form::open_multipart("register/upload_legal_docs", array('id'=>'register_form', 'class'=>'form-horizontal'));?>

<ul class="mainbodyform" style="width:400px;float:left;">
	<li>
		Internal Revenue Service W-9 Form<br />
		Download the form <a href="http://www.irs.gov/pub/irs-pdf/fw9.pdf">here</a>
		<input type="file" name="irs_w9form[]" id="irs_w9form" class="span3 required" />
		<div id="div_upload_more_irs_w9form"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_irs_w9form">Upload More</a>
		</div>
	</li>
	<li>
		State of Incorporation OR State of Organization<br />
		<select name="state_of_incorporation"  class="required" >
			<option value="">Please Select</option>
			<?php 
			foreach($states as $state)
			{
			?>
			<option value="<?php echo $state->abbreviation?>"><?php echo $state->state?></option>
			<?php
			}
			?>
		</select>
	</li>
	<?php
	/*
	<li>
		Certificate of Incorporation OR Certificate of Organization<br />
		<input type="file" name="certificate_of_incorporation[]" id="certificate_of_incorporation" class="span3 required" />
		<div id="div_upload_more_certificate_of_incorporation"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_certificate_of_incorporation">Upload More</a>
		</div>
	</li>
	<li>
		Current Business License<br /> (Note: Optional, but will assist with faster validation)<br />
		<input type="file" name="current_business_license[]" id="current_business_license" class="span3" />
		<div id="div_upload_more_current_business_license"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_current_business_license">Upload More</a>
		</div>
	</li>
	<?php
	if($user_type == "vendor" || $user_type == "vendor/buyer")
	{
	?>
	<li>
		Documentation Authorizing Sales of Goods<br />
		<input type="file" name="documentation_authorizing_sales_of_goods[]" id="documentation_authorizing_sales_of_goods" class="span3 required" />
		<div id="div_upload_more_documentation_authorizing_sales_of_goods"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_documentation_authorizing_sales_of_goods">Upload More</a>
		</div>
	</li>
	<?php
	}
	?>
	<?php
	if($user_type == "charity")
	{
	?>
	<li>
		Documentation Regarding Charitable Status<br /> (Note: Optional, unless charity)<br />
		<input type="file" name="documentation_regarding_charitable_status[]" id="documentation_regarding_charitable_status" class="span3 required" />
		<div id="div_upload_more_documentation_regarding_charitable_status"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_documentation_regarding_charitable_status">Upload More</a>
		</div>
	</li>
	<?php
	}
	?>

	<li>
		Additional Documentation<br /> (Note: Optional)<br />
		<input type="file" name="additional_documentation[]" id="additional_documentation" class="span3" />
		<div id="div_upload_more_additional_documentation"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_additional_documentation">Upload More</a>
		</div>
	</li>

	<li>
		Additional Comments<br /> (Note: Optional)<br />
		<textarea name="additional_comments" cols="20" rows="10"></textarea>
	</li>
	*/
	?>
	<?php
	if($user_type == "charity")
	{
	?>
	<li>
		<!-- Documentation Regarding Charitable Status<br /> (Note: Optional, unless charity)<br /> -->
		<stong>Upload 501(c)(3) charity documentation from IRS</strong>
		<input type="file" name="documentation_regarding_charitable_status[]" id="documentation_regarding_charitable_status" class="span3 required" />
		<div id="div_upload_more_documentation_regarding_charitable_status"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_documentation_regarding_charitable_status">Upload More</a>
		</div>
	</li>
	<?php
	}
	?>
	<?php
	if($user_type == "vendor")
	{
	?>
	<li>
		<strong>Upload one or more of the following: Distribution agreement(s); Letter from producer(s) with contact information for which you will be distributing products; Redacted Invoice(s) or Purchase Order(s) from producer for which you will be distributing products</strong><br />
		<input type="file" name="documentation_authorizing_sales_of_goods[]" id="documentation_authorizing_sales_of_goods" class="span3 required" />
		<div id="div_upload_more_documentation_authorizing_sales_of_goods"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_documentation_authorizing_sales_of_goods">Upload More</a>
		</div>
	</li>
	<li>
		<strong>Please detail any constraints (geographic, time, buyer types, physical locations only, Internet only, disclosure of brand, etc.) to your ability to sell the products which you will offer on LogicLane</strong><br />
		<input type="file" name="additional_documentation[]" id="additional_documentation" class="span3" />
		<div id="div_upload_more_additional_documentation"></div>
		<div>
			<a href="javascript:void(0)" id="upload_more_additional_documentation">Upload More</a>
		</div>
	</li>
	<?php
	}
	?>
</ul>

<div class="clearfix spacer"></div>

<ul class="mainbodyform" style="width:400px;float:left;">
	<input type="hidden" name="uid" value="<?php echo $uid?>">
	<li><button class="silverbutton normalbutton">Next</button><!-- &nbsp;<button type="reset" class="btn"><i class="icon-refresh"></i> Clear</button> --></li>
</ul>
<?php echo Form::close();?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#register_form").validate();

	$("#upload_more_irs_w9form").click(function(){
		$("#div_upload_more_irs_w9form").append("<input type=\"file\" name=\"irs_w9form[]\" id=\"irs_w9form\" class=\"span3 required\" />");
	});

	$("#upload_more_state_of_incorporation").click(function(){
		$("#div_upload_more_state_of_incorporation").append("<input type=\"file\" name=\"state_of_incorporation[]\" id=\"state_of_incorporation\" class=\"span3 required\" />");
	});

	$("#upload_more_certificate_of_incorporation").click(function(){
		$("#div_upload_more_certificate_of_incorporation").append("<input type=\"file\" name=\"certificate_of_incorporation[]\" id=\"certificate_of_incorporation\" class=\"span3 required\" />");
	});

	$("#upload_more_current_business_license").click(function(){
		$("#div_upload_more_current_business_license").append("<input type=\"file\" name=\"current_business_license[]\" id=\"current_business_license\" class=\"span3\" />");
	});

	$("#upload_more_documentation_authorizing_sales_of_goods").click(function(){
		$("#div_upload_more_documentation_authorizing_sales_of_goods").append("<input type=\"file\" name=\"documentation_authorizing_sales_of_goods[]\" id=\"documentation_authorizing_sales_of_goods\" class=\"span3\" />");
	});

	$("#upload_more_documentation_regarding_charitable_status").click(function(){
		$("#div_upload_more_documentation_regarding_charitable_status").append("<input type=\"file\" name=\"documentation_regarding_charitable_status[]\" id=\"documentation_regarding_charitable_status\" class=\"span3\" />");
	});

	$("#upload_more_additional_documentation").click(function(){
		$("#div_upload_more_additional_documentation").append("<input type=\"file\" name=\"additional_documentation[]\" id=\"additional_documentation\" class=\"span3\" />");
	});

});
</script>
