<!--<style type="text/css">@import url(<?php echo $data['baseurl']; ?>global/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>-->
<div class="content">
	<div class="row">
		<div id="main-content" class="span11">
			<div class="store-picture center">

			</div>
			<div id="store">
				<form id="manage-store-form" method="post" action="<?php echo $data['baseurl']; ?>store/save-product">
					<input type="hidden" id="product_id" name="product_id" value="" />
					<div class="clearfix">
						<label for="category">Category</label>
						<div class="input">
							<select id="category" name="category">

							</select>
						</div>
					</div>
					<div class="clearfix">
						<label for="item_name">Item name</label>
						<div class="input">
							<input type="text" id="item_name" name="item_name" />
						</div>
					</div>
					<div class="clearfix">
						<label for="code_name">Code name</label>
						<div class="input">
							<input type="text" id="code_name" name="code_name" />
						</div>
					</div>
					<div class="clearfix">
						<label for="price">Price per quantity</label>
						<div class="input">
							<input type="number" id="price" name="price" />
						</div>
					</div>
					<div class="clearfix">
						<label for="quantity">Quantity</label>
						<div class="input">
							<input type="number" id="quantity" name="quantity" />
						</div>
					</div>
					<div class="clearfix">
						<label for="description">Description</label>
						<div class="input">
							<textarea id="description" class="xlarge" rows="3" name="description"></textarea>
						</div>
					</div>
					<div class="clearfix">
						<label>Visible to public ?</label>
						<div class="input">
							<label style="width: 50px">Yes <input type="radio" name="visible" value="1" class="radio-1" checked="checked" /></label>
							<label style="width: 50px">No <input type="radio" name="visible" value="0" class="radio-2" /></label>
						</div>
					</div>
					<div class="actions">
						<button type="submit" class="btn primary" id="submit" name="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>

		<div id="side-content" class="span5">
			<div id="pagination">

			</div>
			<div id="search-container">
				<form id="search-form">
					<input type="text" id="search" name="search" placeholder="Search" onkeyup="Search.filter();" class="span5" />
					<button type="submit" id="search-button" name="search-button"></button>
				</form>
			</div>
			<div id="search-result">

			</div>
			<button class="btn info" onclick="clearForm()">New</button>
		</div>
	</div>
</div>
<?php include Doo::conf()->SITE_PATH .  Doo::conf()->PROTECTED_FOLDER . "viewc/template/footer.php"; ?>

<!--<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/plupload/js/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>-->

<script type="text/javascript">
	var cachePage = 1;
	var product_id = 0;
	//declare class to be appended
	var headerDiv = $('.header-message');
	var errorDiv = $('.error-message');
			
	//declare message variable
	var header = "";
	var message = "";
	
	$('#manage-store-form').bind('submit', function(e){
		e.preventDefault();
		
		$.ajax({
			type: 'POST',
			url : $(this).attr('action'),
			data: $(this).serialize(),
			dataType: 'json',
			success: function(data){
				if(data){
					//NO USE refreshForm() to avoid send request to server to retrieve data again
					if(data[0] !== 'failed'){
						$('#product_id').val(data[1]); 
						Search.onload('<?php echo $data['baseurl']; ?>store/admin-get-pagination/'+cachePage);
					} else {
						header = "Store Error";
						message = data[1];
						headerDiv.html(header);
						errorDiv.html(message);
						Common.navModal();
					}
				}
			}
		});
	});
	
	function clearForm(){
		$('.page-header').html('');
		$('#manage-store-form')[0].reset();
		$('.radio-1').attr('checked', true);
		$('#product_id').val('');
		var str = '<button type="submit" class="btn primary">Submit</button>&nbsp;';
		str += '<button type="reset" class="btn">Cancel</button>';
		Common.clearDiv('.actions');
		$('.actions').append(str);
	}
	
	function deleteProduct(id){
		$.delete_('<?php echo $data['baseurl']; ?>store/delete-product/'+id, function(data){
			
			if(data){
				clearForm();
				Search.onload('<?php echo $data['baseurl']; ?>store/admin-get-pagination/'+cachePage);
			}
			else {
				header = "Delete Error";
				message = "The page is not found.";
				headerDiv.html(header);
				errorDiv.html(message);
				Common.navModal();
			}
		});
	}
	
	function refreshForm(id){
		$.get('<?php echo $data['baseurl']; ?>store/get-one-product/'+id, function(data){
			if(data){
				product_id = data.product_id;
				Common.clearDiv('.store-picture');
				
				var frame = '<iframe id="item-picture" src="<?php echo $data['baseurl']; ?>template/store-picture-form/'+ product_id +'" style="width:550px;height:330px;margin-left: 75px;border:none">';
				frame += '</iframe>';
				
				$('.store-picture').append(frame);
				
				$('#product_id').val(data.product_id);
				$('#category').val(data.category);
				$('#item_name').val(data.product_name);
				$('#code_name').val(data.product_code);
				$('#price').val(data.price);
				$('#quantity').val(data.quantity);
				$('#description').val(data.description);
				
				if(data.visible === '1'){
					$('.radio-1').attr('checked', true);
					$('.radio-2').attr('checked', '');
				}
				else {
					$('.radio-1').attr('checked', '');
					$('.radio-2').attr('checked', true);
				}
				
				var str = '<button type="submit" class="btn primary">Submit</button>&nbsp;';
				str += '<button class="btn" type="reset">Cancel</button>&nbsp;';
				str += '<button class="btn danger" type="button" onclick="deleteProduct('+ data.product_id +')">Delete</button>';
				Common.clearDiv('.actions');
				$('.actions').append(str);
				
			}
		});
	}
	
	function countPage(){
		$.get('<?php echo $data['baseurl']; ?>store/admin-count-page', function(data){
			if(data){
				paginate(data);
				Search.onload('<?php echo $data['baseurl']; ?>store/admin-get-pagination/'+cachePage, '#manage-store-form');
			} else {
				return false;
			}
		});
	}

	function paginate(count){
		$("#pagination").paginate({
			count 		: count,
			start 		: 1,
			border					: true,
			border_color			: '#fff',
			text_color  			: '#fff',
			background_color    	: 'black',
			border_hover_color		: '#ccc',
			text_hover_color  		: '#000',
			background_hover_color	: '#fff',
			images					: false,
			mouse					: 'press',
			onChange     			: function(page){
				cachePage = page;
				Search.onload('<?php echo $data['baseurl']; ?>store/admin-get-pagination/'+cachePage, '#manage-store-form');
			}
		});
	}	
	
	function getCategory(){
		$.ajax({
			type: 'GET',
			url: '<?php echo $data['baseurl']; ?>store/get-category',
			success: function(data){
				var str = '';
				
				if(data){
					str += '<option value="">Please select a category</option>';
					for(var i = 0; i < data.length; i++){
						str += '<option value="'+ data[i].category_id +'">'+ data[i].category_name +'</option>';
					}
				} else {
					str += '<option value="">Please make a store category</option>';
					$('.page-header').append('To set category go to <a href="<?php echo $data['baseurl']; ?>store/edit-category">store category</a>');
				}
				Common.clearDiv('#category');
				$('#category').append(str);
			}
		});
	}
	
	$(function(){
		getCategory();
		
		countPage();
		
	})
</script>