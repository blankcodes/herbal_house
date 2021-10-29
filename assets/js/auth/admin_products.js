var base_url;
var page;

if (page == 'admin_products') {
	showProducts(1);
}
else if (page == 'admin_products_category') {
	showProductsCategory(1);
}
else if (page == 'product_code_list') {
	showProductsCodeList(1);
}
else if (page == 'admin_walkin_buyers') {
	showWalkinTx(1);
}
else if(page == 'stockist_admin'){
	showStockistList(1);
}
$("#_add_stocks_btn").on('click', function() {
	getProductList();	
})
$("#refresh_prodct_tbl").on('click', function() {
	showProducts(1);	
})
$("#refresh_prodct_category_tbl").on('click', function() {
	showProductsCategory(1);	
})
$("#add_product_modal_btn").on('click', function() {
	$("#add_product_modal").modal('show');
	$("#_modal_title").text('Add Product')
	showProductCategorySelect();
})
$("#add_product_cat_modal_btn").on('click', function() {
	$("#add_product_cat_modal").modal('show');	
})
$('#product_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showProducts(page_no);
});
$('#_walkin_tx_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showWalkinTx(page_no);
});
$('#product_category_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showProductsCategory(page_no);
});
$('#_stockist_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showStockistList(page_no);
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#prodct_img_thumbnail')
                .attr('src', e.target.result)
                .width(200)

            $('#_edit_prodct_img_thumbnail')
                .attr('src', e.target.result)
                .width(200)

            $('#prodct_cat_img_thumbnail')
                .attr('src', e.target.result)
                .width(200)
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$("#_add_product_form").on('submit', function(e) {
	e.preventDefault();
	var description = window.parent.tinymce.get('editor_description').getContent();
	var formData = new FormData(this);
	var srp_price = $('#srp_price').val();
	var dc_price = $('#dc_price').val();
	var product_image = $("#product_image").val();
	formData.append('description', description);

	if (parseInt(dc_price) >= parseInt(srp_price)) {
		$.NotificationApp.send("Oh Snap!","Discounted price should not be higher than or equal to SRP price!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	if (!product_image || product_image == '') {
		$.NotificationApp.send("Oh Snap!","Product image is required!","top-right","rgba(0,0,0,0.2)","warning");
		return false;
	}

	$("#add_product_btn").attr('disabled','disabled').text('Adding...');
	$.ajax({
		url: base_url+'api/v1/product/_add_product',
		type: 'POST',
		dataType: 'JSON',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
			403: function() {
				$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$('#_add_product_form input' ).val('');
			$('#editor_description').val('');
			$("#add_product_modal").modal('hide');	
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showProducts(1)
		}
		else if(res.data.status == 'failed' && res.data.message.product_category) {
			$.NotificationApp.send("Oh Snap!!",res.data.message.product_category,"top-right","rgba(0,0,0,0.2)","warning");
		}
		else{
			$.NotificationApp.send("Oh Snap!!",res.data.message,"top-right","rgba(0,0,0,0.2)","warning");

		}
		$("#add_product_btn").removeAttr('disabled').text('Add Product');
	})

	.fail(function() {
		$("#add_product_btn").removeAttr('disabled').text('Add Product');
	});
});

function showProducts(page_no){
	$("#_products_tbl").html('<tr class="text-center"><td colspan="9">Loading Products...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/product/_get_all',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		$('#product_pagination').html(res.pagination);
		string = '';
		status= '';
		for(var i in res.result) {
			if (res.count > 0) {
				status = res.result[i].status;
				if (status == 'inactive') {
					status = 'bg-danger';
				}
				else{
					status = 'bg-success';
				}

				string +='<tr>'
                 	+'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
                    +'</td>'
                    +'<td width="190">'
                        +'<img src="'+base_url+res.result[i].image+'" alt="product img" class="rounded me-1" height="25" />'
                        +'<p class="m-0 d-inline-block align-middle">'
                            +'<a target="_blank" href="'+res.result[i].url+'" class="text-body">'+res.result[i].name+'</a>'
                        +'</p>'
                    +'</td>'
                    +'<td width="150">'+res.result[i].category+'</td>'
                    +'<td>₱ '+res.result[i].srp_price+'</td>'
                    +'<td>₱ '+res.result[i].dc_price+'</td>'
                    +'<td> '+res.result[i].points+'</td>'
                    
                    +'<td>'+res.result[i].qty+' <i class="uil-edit pointer-cursor" onclick="updateQty(\''+res.result[i].qty+'\',\''+res.result[i].p_id+'\')"></i></td>'
                    +'<td><span class="text-capitalize badge '+status+' pointer-cursor" onclick="changeProductStatus(\''+res.result[i].p_id+'\',\''+res.result[i].status+'\')">'+res.result[i].status+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
                    +'<td class="take-action">'
                    		+'<div class="dropdown">'
					    	+'<button class="btn btn-light dropdown-toggle btn-md font-12" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +'Action'
					    	+'</button>'
					    	+'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
					        	+'<a  class="dropdown-item" href="#view_product"  onclick="productView('+res.result[i].p_id+')""><i class="uil-eye"></i> View</a>'
					        	+'<a class="dropdown-item" href="#edit_product" onclick="getProductDataByID('+res.result[i].p_id+')"><i class="uil-edit"></i> Edit</a>'
					        	+'<a class="dropdown-item" href="#delete_product" onclick="deleteProduct('+res.result[i].p_id+')"><i class="uil-trash-alt"></i> Delete</a>'
					    	+'</div>'
						+'</div>'
                    +'</td>'
       			+'</tr>'
			}
			else{
				string = '<tr class="text-center"><td colspan="9">No records found!...</td></tr>';
			}
			$('#_products_tbl').html(string);
		}

	})
	.fail(function() {
		$("#_products_tbl").html('<tr class="text-center"><td colspan="9">No records found!</td></tr>');
	})
}
function deleteProduct(p_id) {
	sweetAlert({
		title:'Are you sure?',
		text: 'Once deleted, you will not be able to recover this item!',
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$.ajax({
	    	url: base_url+'api/v1/product/_delete_product',
	    	type: 'POST',
	    	dataType: 'JSON',
	    	data: {p_id:p_id,},
	    })
	    .done(function(res) {
	    	if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showProducts(1);
	    	}
	    })
	    .fail(function() {
	    	console.log("error");
	    })
	});
}
function changeProductStatus(p_id, status) {
	ch_status = 'inactive';
	if (status == 'inactive') {
		ch_status = 'active';
	}
	sweetAlert({
		title:'Are you sure?',
		text: "Update this Product's status to "+ch_status+"?",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$.ajax({
	    	url: base_url+'api/v1/product/_update_product_status',
	    	type: 'POST',
	    	dataType: 'JSON',
	    	data: {p_id:p_id, status:ch_status},
	    	statusCode: {
				403: function() {
					$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
				}
			}
	    })
	    .done(function(res) {
	    	if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showProducts(1);
	    	}
	    })
	    .fail(function() {
	    	console.log("error");
	    })
	});
}

$("#_add_product_cat_form").on('submit', function(e) {
	e.preventDefault();
	$("#add_product_cat_btn").attr('disabled','disabled').text('Adding...');
	var formData = new FormData(this);
	var product_cat_image = $("#product_cat_image").val();

	if (!product_cat_image || product_cat_image == '') {
		$.NotificationApp.send("Oh Snap!","Product image is required!","top-right","rgba(0,0,0,0.2)","warning");
		return false;
	}

	$.ajax({
		url: base_url+'api/v1/product/_add_product_category',
		type: 'POST',
		dataType: 'JSON',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		    403: function() {
		     	$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
		    }
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$('#_add_product_cat_form input' ).val('');
			$("#add_product_cat_modal").modal('hide');	
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showProductsCategory(1);
		}
		else{
			$.NotificationApp.send("Oh snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
		}
		$("#add_product_cat_btn").removeAttr('disabled').text('Add Product');
	})
	.fail(function(){
		$("#add_product_cat_btn").removeAttr('disabled').text('Add Product');
	})
})
function showProductCategorySelect() {
	$("#product_category").html('Loading...');
	$.ajax({
		url: base_url+'products/getProductCategory',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		string = '';
		string='<option selected disabled>Select Product Category</option>';
		for(var i in res.data) {
			string+='<option value="'+res.data[i].pc_id+'">'+res.data[i].name+'</option>'
		}
		$("#product_category").html(string);
	})
	.fail(function() {
		console.log("error");
	})
}
function showProductsCategory(page_no){
	$("#_products_category_tbl").html('<tr class="text-center"><td colspan="4">Loading Product Category...</td></tr>');
	$.ajax({
		url: base_url+'products/categories/'+page_no,
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		$('#product_category_pagination').html(res.pagination);
		string = '';
		status= '';
		for(var i in res.result) {
			if (res.count > 0) {
				status = res.result[i].status;
				if (status == 'inactive') {
					status = 'bg-danger';
				}
				else{
					status = 'bg-success';
				}

				string +='<tr>'
                 	+'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
                    +'</td>'
                    +'<td>'+res.result[i].category+'</td>'
                    +'<td><span class="text-capitalize badge '+status+' pointer-cursor" onclick="changeProductCategoryStatus(\''+res.result[i].pc_id+'\',\''+res.result[i].status+'\')">'+res.result[i].status+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
                    +'<td class="">'
                    	+'<a class="text-muted pr-1 btn-rounded" href="#delete_product" onclick="deleteProductCategory('+res.result[i].pc_id+')"><i class="uil-trash-alt"></i></a>'
                    	+'<a class="text-muted pr-1 btn-rounded" href="#edit_product" onclick="editProductCategory('+res.result[i].pc_id+')"><i class="uil-edit"></i></a>'
                    +'</td>'
       			+'</tr>'
			}
			else{
				string = '<tr class="text-center"><td colspan="7">No records found!...</td></tr>';
			}
			$('#_products_category_tbl').html(string);
		}
	})
	.fail(function() {
		$("#_products_category_tbl").html('<tr class="text-center"><td colspan="7">No records found!</td></tr>');
	})
}

function changeProductCategoryStatus(pc_id, status) {
	ch_status = 'inactive';
	if (status == 'inactive') {
		ch_status = 'active';
	}
	
	sweetAlert({
		title:'Are you sure?',
		text: "Update this Product Category status to "+ch_status+"?",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$.ajax({
	    	url: base_url+'api/v1/product/_update_product_category_status',
	    	type: 'POST',
	    	dataType: 'JSON',
	   		data: {pc_id:pc_id, status:ch_status},
	   		statusCode: {
			    403: function() {
			     	$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
			    }
			}
	    })
	    .done(function(res) {
	    	if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showProductsCategory(1);
    		}
	    })
	    .fail(function() {
	    	console.log("error");
	    })
	});
}
function getProductDataByID(p_id) {
	$("#loader").removeAttr('hidden');
	$('#_edit_product_url').attr('readonly', 'readonly');
	$("#close_edit_product_url_").attr('hidden','hidden');
	$("#edit_product_url_").removeAttr('hidden');
	
	$("#advance_product_url").addClass('collapsed');
	$.ajax({
		url: base_url+'api/v1/product/_get_product_data_by_id',
		type: 'GET',
		dataType: 'JSON',
		data: {p_id:p_id},
	})
	.done(function(res) {
		showProductCategorySelectUpdate(res.data.pc_id, res.data.category);
		$("#_edit_modal_title").text('Update Product '+res.data.name)
		$("#_edit_product_name").val(res.data.name)
		$("#_edit_srp_price").val(res.data.srp_price)
		$("#_edit_dc_price").val(res.data.dc_price)
		$("#_edit_qty").val(res.data.qty)
		$("#_edit_p_id").val(res.data.p_id)
		$("#_edit_priority").val(res.data.priority)
		$("#_edit_profit_sharing_points").val(res.data.profit_sharing_points)
		$("#_edit_points").val(res.data.points)
		$("#_edit_investment_point").val(res.data.investment_point)
		$(tinymce.get('_edit_editor_description').getBody()).html(res.data.description);
		$("#_edit_prodct_img_thumbnail").attr('src', base_url+''+res.data.image)
		$("#_edit_product_url").val(res.data.url)


		$("#edit_product_modal").modal('show');
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
	})
}
function showProductCategorySelectUpdate(pc_id, category) {
	$("#product_category").html('Loading...');
	$.ajax({
		url: base_url+'api/v1/product/_get_product_category',
		type: 'GET',
		dataType: 'JSON',
	})
	.done(function(res) {
		string = '';
		string='<option selected value="'+pc_id+'">'+category+'</option>';
		for(var i in res.data) {
			string+='<option value="'+res.data[i].pc_id+'">'+res.data[i].name+'</option>'
		}
		$("#_edit_product_category").html(string);
	})
	.fail(function() {
		console.log("error");
	})
}
function productView(p_id){
	$.ajax({
		url: base_url+'api/v1/product/_get_product_data_by_id',
		type: 'GET',
		dataType: 'JSON',
		data: {p_id:p_id},
	})
	.done(function(res) {
		stock_status = '';
		stock_status = '';
		if (res.data.qty > 0) {
			stock_status = '<span class="badge badge-success-lighten" >Instock</span>';
		}
		else{
			stock_status = '<span class="badge badge-danger-lighten" >Out of Stock</span>';
		}
		$("#_view_stock_status").html(stock_status);

		$("#_view_title_modal").text(res.data.name);
		$("#main_prod_img").attr('src',base_url+res.data.image);
		$("#_view_prod_name").text(res.data.name);
		$("#_view_added_date").text(res.data.created_at);
		$("#_view_dc_price").text('₱ '+res.data.dc_price);
		$("#_view_srp_price").text('₱ '+res.data.srp_price);
		$("#_view_description").html(res.data.description);
		$("#view_product_modal").modal('show');
	})
	.fail(function() {
		console.log("error");
	})	
}
$("#_update_product_form").on('submit', function(e) {
	e.preventDefault();
	var description = window.parent.tinymce.get('_edit_editor_description').getContent();
	var formData = new FormData(this);
	var srp_price = $('#_edit_srp_price').val();
	var dc_price = $('#_edit_dc_price').val();
	formData.append('description', description);

	if (parseInt(dc_price) >= parseInt(srp_price)) {
		$.NotificationApp.send("Error!","Discounted price should not be higher than or equal to SRP price!","top-right","rgba(0,0,0,0.2)","warning");
		return false;
	}

	$("#update_product_btn").attr('disabled','disabled').text('Updating...');
	$.ajax({
		url: base_url+'api/v1/product/_update_product',
		type: 'POST',
		dataType: 'JSON',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		403: function() {
			  	$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$("#edit_product_modal").modal('hide');	
			$("#_edit_product_image").val('');
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showProducts(1)
		}
		else if(res.data.status == 'failed' && res.data.message.product_category) {
			$.NotificationApp.send("Oh Snap!",res.data.message.product_category,"top-right","rgba(0,0,0,0.2)","warning");
		}
		else{
			$.NotificationApp.send("Oh Snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","warning");
		}
		$("#update_product_btn").removeAttr('disabled').text('Update Product');
	})
	.fail(function() {
		$("#update_product_btn").removeAttr('disabled').text('Update Product');
	})
})
function deleteProductCategory(pc_id) {
	sweetAlert({
		title:'Are you sure?',
		text: "Once deleted, you will not be able to recover this item!",
		type:'warning',
		showCancelButton: true,
		confirmButtonColor: '#3699ff',
		cancelButtonColor: '#98a6ad',
		confirmButtonText: 'Yes, proceed!'
	},function(isConfirm){
		('ok');
	});
	$('.swal2-confirm').click(function(){
		$.ajax({
	    	url: base_url+'api/v1/product/_delete_product_category',
	    	type: 'POST',
	   		dataType: 'JSON',
	   		data: {pc_id:pc_id,},
	   		statusCode: {
				403: function() {
			     	$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
			    }
			}
	    })
	   	.done(function(res) {
	   		if (res.data.status == 'success') {
				$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
				showProductsCategory(1);
	   		}
	   	})
	   	.fail(function() {
	   		console.log("error");
	   	})
	});
}
$("#edit_product_url_").on('click', function() {
	$('#_edit_product_url').removeAttr('readonly').focus();
	$("#close_edit_product_url_").removeAttr('hidden');
	$("#edit_product_url_").attr('hidden','hidden');
})
$("#close_edit_product_url_").on('click', function() {
	$('#_edit_product_url').attr('readonly','readonly');
	$("#edit_product_url_").removeAttr('hidden');
	$("#close_edit_product_url_").attr('hidden','hidden');
})
function updateQty(qty, p_id) {
	$("#__edit_qty").val(qty);
	$("#__edit_p_id").val(p_id);
	$("#update_qty_product_modal").modal('show');
}
$("#_update_product_qty_form").on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/product/_update_quantity',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showProducts(1)
		}
	})
	.fail(function() {
	})
	.always(function() {
	});
	
})
$("#generate_code_btn").on('click', function() {
	getProductList();
	$("#generate_prod_code_modal").modal('show')	
})
$("#_generate_prod_form").on('submit', function(e) {
	e.preventDefault();

	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/product/_generate_code',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#generate_code_modal").modal('hide');
			showProductsCodeList(1)
			$("#_code_form input").val('');
		}
		else {
			$.NotificationApp.send("Oh, snap!","Something went wrong. Please try again!","top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		console.log("error");
		$("#loader").attr('hidden','hidden');
	})
})
$("#refresh_prodct_code_tbl").on('click', function() {
	showProductsCodeList(1);
})
function showProductsCodeList(page_no){
	$("#_product_codes_tbl").html('<tr class="text-center"><td colspan="6">Loading Product Category...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/product/_get_product_codes',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		$('#product_code_pagination').html(res.pagination);
		string = '';
		badge_stat = 'warning';
		for(var i in res.result) {
			if (res.count > 0) {
				if (res.result[i].status == 'new') {
					badge_stat = 'success'
				}
				else if(res.result[i].status == 'used'){
					badge_stat = 'danger'
				}
				string +='<tr>'
                 	+'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
                    +'</td>'
                    +'<td>'+res.result[i].name+'</td>'
                    +'<td>'+res.result[i].product_code+'</td>'
                    +'<td><span class="badge badge-'+badge_stat+'-lighten text-capitalize">'+res.result[i].status+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
                    +'<td class="take-action text-left">'
                    	+'<a class="dropdown-item btn-rounded" href="#delete_product" onclick="deleteProductCategory('+res.result[i].pc_id+')"><i class="uil-trash-alt"></i> Delete</a>'
                    +'</td>'
       			+'</tr>'
			}
			else{
				string = '<tr class="text-center"><td colspan="6">No records found!...</td></tr>';
			}
			$('#_product_codes_tbl').html(string);
		}
	})
	.fail(function() {
		$("#_product_codes_tbl").html('<tr class="text-center"><td colspan="6">No records found!</td></tr>');
	})
}
$("#_process_walkin_buyer").on('click', function() {
	getProductList();
	$("#walkin_buy_modal").modal('toggle');
})
$("#search_code_name_form").on('submit', function(e) {
	e.preventDefault();
	keyword = $("#search_code_name").val();

	if (!keyword || keyword == '' || keyword == ' ') {
		return false;
	}
	$.ajax({
		url: base_url+'api/v1/users/_get',
		type: 'GET',
		dataType: 'JSON',
		data: {keyword:keyword}
	})
	.done(function(res) {
		string = '';
		if (res.data.status == 'success') {
			for(var i in res.data.search){
				string+='<a href="#" onclick="searchUserCode(\''+res.data.search[i].user_code+'\',\''+res.data.search[i].name+'\')" class="dropdown-item notify-item"><span id="user_name"> '+res.data.search[i].name+'</span> <span>(#'+res.data.search[i].user_code+')</span></a>'
			}
		}
		else if(res.data.status == 'no_record'){
			string = '<span class="margin-left-10">'+res.data.message+'</span>'
		}
		$("#search_user_dropdown").show()
		$("#_member_search").html(string);
	})
	.fail(function() {
		string = '<span class="margin-left-10">No records found!</span>'
		$("#_member_search").html(string);
	})
});
$("#_search_stockist_name_form").on('submit', function(e) {
	e.preventDefault();
	keyword = $("#search_stockist_name").val();

	if (!keyword || keyword == '' || keyword == ' ') {
		return false;
	}
	$.ajax({
		url: base_url+'api/v1/stockist/_search_user',
		type: 'GET',
		dataType: 'JSON',
		data: {keyword:keyword}
	})
	.done(function(res) {
		string = '';
		if (res.data.status == 'success') {
			for(var i in res.data.search){
				string+='<a href="#" onclick="searchUserCode(\''+res.data.search[i].user_code+'\',\''+res.data.search[i].name+'\')" class="dropdown-item notify-item"><span id="user_name"> '+res.data.search[i].name+'</span> <span>(#'+res.data.search[i].user_code+')</span></a>'
			}
		}
		else if(res.data.status == 'no_record'){
			string = '<span class="margin-left-10">'+res.data.message+'</span>'
		}
		$("#search_user_dropdown").show()
		$("#_member_search").html(string);
	})
	.fail(function() {
		string = '<span class="margin-left-10">No records found!</span>'
		$("#_member_search").html(string);
	})
});
function searchUserCode(search_user_code, name){
	$("#search_code_name").val('');
	$("#_user_name").val(name);
	$("#_user_code").val(search_user_code)
	$("#search_user_dropdown").hide()
}

function getProductList(){
	$.ajax({
		url: base_url+'api/v1/product/_get_list',
		type: 'GET',
		dataType: 'JSOn',
	})
	.done(function(res) {
		string = '<option disabled="" selected="">Select Product</option>';
		if (res.data.length > 0) {
			for(var i in res.data) {
				string += '<option value="'+res.data[i].p_id+'">'+res.data[i].name+'</option>'
			}
			$("#_select_product").html(string)
			$("#generate_code_modal").modal('show');
			$("#_add_stocks_modal").modal('show');
		}
		else{
			$.NotificationApp.send("Oh, Snap!","Kindly add Product first","top-right","rgba(0,0,0,0.2)","error");
		}
	})
	.fail(function() {
		console.log("error");
	})
}
$("#_add_multi_product").on('click', function(){

	p_id = $("#_select_product").val(); /* user code, the receiver*/
	qty = $("#qty").val();
	_user_code = $("#_user_code").val();

	if (!p_id || p_id == '') {
		$.NotificationApp.send("Oh, snap!","Please choose a product!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	else if (!qty || qty == '' || qty == 0) {
		$.NotificationApp.send("Oh, snap!","Quantity is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}
	else if (!_user_code || _user_code == '') {
		$.NotificationApp.send("Oh, snap!","Stockist is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/stockist/_get_product_details',
		type: 'GET',
		dataType: 'JSON',
		data: {p_id:p_id, qty:qty, user_code:_user_code},
	})
	.done(function(res) {
		data = '';
		$("#_products_tbl").html('');
		for(var i in res.data) {
			if (res.data.length > 0) {
				data +='<tr>'
                    +'<td>'+res.data[i].name+'</td>'
                    +'<td>'+res.data[i].qty+'</td>'
       			+'</tr>'
			}
			else{
				data = '<tr class="text-center"><td colspan="2">List is empty!</td></tr>';
			}
			$('#_products_tbl').html(data);
		}

		showStockistList(1);
		// string ='<tr>'
  //               +'<td><input type="text" class="form-control disabled" value="'+res.data.name+'" name="product_name[]" readonly></td>'
  //              +'<td><input type="text" class="form-control disabled" value="'+qty+'" name="product_qty[]" readonly></td>'
  //      		+'</tr>';
		// $("#_products_tbl").html(string)
		$("#loader").attr('hidden', 'hidden');
	})
	.fail(function() {
		console.log("error");
	})
})
$("#_send_product_code_btn").on('click', function(){
	user_code = $("#_user_code").val(); /* user code, the receiver*/
	qty = $("#qty").val(); /* user code, the receiver*/
	p_id = $("#_select_product").val(); /* user code, the receiver*/

	if (!user_code || user_code == '') {
		$.NotificationApp.send("Oh, snap!","User Code is required!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	if (!p_id || p_id == '') {
		$.NotificationApp.send("Oh, snap!","Please choose a product!","top-right","rgba(0,0,0,0.2)","error");
		return false;
	}

	$("#loader").removeAttr('hidden');
	$.ajax({
		url: base_url+'api/v1/product/_process_walkin_tx',
		type: 'GET',
		dataType: 'JSON',
		data: {user_code:user_code, qty:qty, p_id:p_id},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			$("#search_code_name_form input").val('');
			$("#walkin_buy_modal").modal('hide');
			showWalkinTx(1);
		}
		else{
			$.NotificationApp.send("Oh, snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","error");
		}
		$("#loader").attr('hidden', 'hidden');
	})
	.fail(function() {
		console.log("error");
	})
})
function showWalkinTx(page_no){
	$("#_walkin_tx_tbl").html('<tr class="text-center"><td colspan="6">Loading data...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/product/_get_product_tx_history',
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		$('#_walkin_tx_pagination').html(res.pagination);
		string = '';
		bg_stat = 'info';

		for(var i in res.result) {
			if (res.result[i].status == 'complete') {
				bg_stat = 'success';
			}
			if (parseInt(res.count) > 0) {
				string +='<tr>'
                 	+'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
                    +'</td>'
                    +'<td>#'+res.result[i].ref_no+'</td>'
                    +'<td>'+res.result[i].user_code+'</td>'
                    +'<td>'+res.result[i].name+'</td>'
                    +'<td><span class="badge badge-'+bg_stat+'-lighten text-capitalize">'+res.result[i].status+'</span></td>'
                    +'<td>'+res.result[i].created_at+'</td>'
                    // +'<td class="take-action text-left">'
                    // 	+'<a class="dropdown-item btn-rounded" href="#delete_product" onclick="deleteProductCategory('+res.result[i].pc_id+')"><i class="uil-trash-alt"></i> Delete</a>'
                    // +'</td>'
       			+'</tr>'
			}
			else{
				string = '<tr class="text-center"><td colspan="6">No records found!</td></tr>';
			}
			$('#_walkin_tx_tbl').html(string);
		}
	})
	.fail(function() {
		$("#_walkin_tx_tbl").html('<tr class="text-center"><td colspan="6">No records found!</td></tr>');
	})
}
function editProductCategory(pc_id){
	$("#loader").removeAttr('hidden','hidden');
	$.ajax({
		url: base_url+'api/v1/product/_get_product_category_data',
		type: 'GET',
		dataType: 'JSON',
		data: {pc_id:pc_id}
	})
	.done(function(res) {
		$("#prodct_cat_img_thumbnail").attr('src', res.data.image)
		$("#_edit_pc_id").val(res.data.pc_id)
		$("#_edit_product_cat_name").val(res.data.name)
		$("#update_product_cat_modal").modal('toggle');
		$("#loader").attr('hidden','hidden');
		newCsrfData();
	})
}
$("#_update_product_cat_form").on('submit', function(e) {
	e.preventDefault();
	$("#update_product_cat_btn").attr('disabled','disabled').text('Updating...');
	var formData = new FormData(this);
	var product_cat_image = $("#_edit_product_cat_image").val();

	if (!product_cat_image || product_cat_image == '') {
		$.NotificationApp.send("Oh Snap!","Product image is required!","top-right","rgba(0,0,0,0.2)","warning");
		return false;
	}

	$.ajax({
		url: base_url+'api/v1/product/_update_product_category',
		type: 'POST',
		dataType: 'JSON',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		    403: function() {
		     	$.NotificationApp.send("Oh Snap!","Something went wrong! Refresh this page and try again!","top-right","rgba(0,0,0,0.2)","error");
		    }
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$('#_update_product_cat_form input' ).val('');
			$("#update_product_cat_modal").modal('hide');	
			$.NotificationApp.send("Success!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
			showProductsCategory(1);
		}
		else{
			$.NotificationApp.send("Oh snap!",res.data.message,"top-right","rgba(0,0,0,0.2)","success");
		}
		$("#update_product_cat_btn").removeAttr('disabled').text('Update Product');
	})
	.fail(function(){
		$("#update_product_cat_btn").removeAttr('disabled').text('Update Product');
	})
})
function showStockistList(page_no){
	$("#_stockist_tbl").html('<tr class="text-center"><td colspan="6">Loading data...</td></tr>');
	$.ajax({
		url: base_url+'api/v1/stockist/_get_list', 
		type: 'GET',
		dataType: 'JSON',
		data: {page_no:page_no}
	})
	.done(function(res) {
		$('#_stockist_pagination').html(res.pagination);
		string = '';
		stocks = '';

		for(var i in res.result) {
			if (res.result[i].stocks == null) {
				stocks = 0;
			}
			else{
				stocks = res.result[i].stocks;
			}
			if (parseInt(res.count) > 0) {
				string +='<tr>'
                 	+'<td>'
	                    +'<div class="form-check">'
	                        +'<input type="checkbox" class="form-check-input" id="customCheck2">'
	                        +'<label class="form-check-label" for="customCheck2">&nbsp;</label>'
	                    +'</div>'
                    +'</td>'
                    +'<td>'+res.result[i].name+'</td>'
                    +'<td>'+res.result[i].user_code+'</td>'
                    +'<td>'+res.result[i].sold+'</td>'
                    +'<td>'+res.result[i].total_sales+'</td>'
                    +'<td>'+stocks+'</td>'
                    +'<td>'
                        +'<div class="dropdown">'
						    +'<button class="btn btn-light btn-sm dropdown-toggle font-12" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
						        +'Action'
						    +'</button>'
						    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
						        +'<a class="dropdown-item" target="_blank" href="'+base_url+'user/stockist/'+res.result[i].user_code+'" onclick="">View Statistics</a>'
						    +'</div>'
						+'</div>'
                    +'</td>'
       			+'</tr>'
			}
			else{
				string = '<tr class="text-center"><td colspan="6">No records found!</td></tr>';
			}
			$('#_stockist_tbl').html(string);
		}
	})
	.fail(function() {
		$("#_stockist_tbl").html('<tr class="text-center"><td colspan="6">No records found!</td></tr>');
	})
}