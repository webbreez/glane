<?php echo form::open_multipart(NULL, array('id'=>'form'));?>
<div class="span9">
	<fieldset>
		<div id="notice" class="alert-error alert">
			Edit Product
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Product Name:</label></div>
			<div class="span7"><input type="text" id="product_name" name="product_name" value="<?php echo $product->product_name?>" class="span7 required" /></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Price:</label></div>
			<div class="span7"><input type="text" id="price" name="price" value="<?php echo $product->price?>" class="span7 required" /></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Quantity:</label></div>
			<div class="span7"><input type="text" id="qty" name="qty" value="<?php echo $product->qty?>" class="span7 required" /></div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Category 1:</label></div>
			<div class="span7">
				<select name="category_1" id="category_1" class="required category" title="Please select a category" rel="category_1">
				<option value=""></option>
				<?php
				foreach($category_1 as $cat_1)
				{
					$category_1_id = $cat_1->category_1_id;
					$category_1_name = $cat_1->category_1_name;
				?>
				<option value="<?php echo $category_1_id?>" <?php echo $product->category_1 == $category_1_id ? 'selected=selected' : ''?>><?php echo $category_1_name?></option>
				<?php
				}
				?>
			</select>
			</div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Category 2:</label></div>
			<div class="span7">
				<select name="category_2" id="category_2" class="category" rel="category_2">
				<?php
				foreach($list_product_category_2 as $cat_2)
				{
				?>
				<option value="<?php echo $cat_2->category_2_id?>" <?php echo $product->category_2 == $cat_2->category_2_id ? 'selected=selected' : ''?>><?php echo $cat_2->category_2_name?></option>
				<?
				}
				?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Category 3:</label></div>
			<div class="span7">
				<select name="category_3" id="category_3" class="category" rel="category_3">
				<?php
				foreach($list_product_category_3 as $cat_3)
				{
				?>
				<option value="<?php echo $cat_3->category_3_id?>" <?php echo $product->category_3 == $cat_3->category_3_id ? 'selected=selected' : ''?>><?php echo $cat_3->category_3_name?></option>
				<?
				}
				?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Category 4:</label></div>
			<div class="span7">
				<select name="category_4" id="category_4" class="category" rel="category_4">
				<?php
				foreach($list_product_category_4 as $cat_4)
				{
				?>
				<option value="<?php echo $cat_4->category_4_id?>" <?php echo $product->category_4 == $cat_4->category_4_id ? 'selected=selected' : ''?>><?php echo $cat_4->category_4_name?></option>
				<?
				}
				?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Description:</label></div>
			<div class="span7">
				<textarea name="description" id="description" class="required" title="Please enter product description" rows="10" cols="40"><?php echo $product->product_description?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="span3" style="text-align:right;"><label class="control-label">Featured:</label></div>
			<div class="span7">
				<select name="featured" id="featured" class="required category" title="">
					<option value="No" <?php echo $product->featured == "No" ? "selected=selected" : ''?> >No</option>
					<option value="Yes" <?php echo $product->featured == "Yes" ? "selected=selected" : ''?> >Yes</option>
				</select>
			</div>
		</div>
		<?php
		//if($product->featured == "Yes")
		//{
		?>
			<div class="row">
				<div class="span3" style="text-align:right;"><label class="control-label">Upload Picture Banner:</label></div>
				<div class="span7">
					<?php if($product->banner){?><img src="<?php echo url::base();?>assets/upload/<?php echo $product->banner?>" /><?php }?>
					<input type="file" id="banner" name="banner" class="" />
				</div>
			</div>
		<?php
		//}
		?>
		<div class="form-actions">
			<div class="span4 offset2">
				<button type="submit" class="btn btn-primary"><i class="icon-upload icon-white"></i> Submit</button>
			</div>
		</div>
	</fieldset>
</div>
<?php form::close()?>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<?php echo html::script("assets/js/jquery.validate.min.js");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#form").validate();

	$(".category").change(function(){
		var id = $(this).val();
		var type = $(this).attr("rel");

		var data = new Object();
		data.id = id;
		data.type = type;

		$.ajax({
		type: "POST",
		dataType: "json",
		data: data,
		url: '<?php echo URL::site('products/get_categories');?>',
		success: function(data) {
			if(data.length > 0)
            {
               	var options = '<option value=""></option>';
                $.each(data, function(i, value){
                    options += '<option value="' + value.key + '">' + value.val + '</option>';
                });

                if(type == 'category_1')
                {
                	$("select[name='category_2']").html(options);
                	$("select[name='category_3']").html("<option value=\"\"></option>");
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_2')
                {
                	$("select[name='category_3']").html(options);
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_3')
                {
                	$("select[name='category_4']").html(options);
                }

            }else{
            	var options = '<option value=""></option>';
            	if(type == 'category_1')
                {
                	$("select[name='category_2']").html(options);
                	$("select[name='category_3']").html("<option value=\"\"></option>");
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_2')
                {
                	$("select[name='category_3']").html(options);
                	$("select[name='category_4']").html("<option value=\"\"></option>");
                }else if(type == 'category_3')
                {
                	$("select[name='category_4']").html(options);
                }
            }
		}
		});
	});

});
</script>
