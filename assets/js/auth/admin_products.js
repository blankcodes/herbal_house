var base_url;
var page;


if (page == 'admin_products') {
	showProducts(1);
}
else if (page == 'admin_products_category') {
	showProductsCategory(1);
}

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
$('#product_category_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    showProductsCategory(page_no);
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
					    	+'<button class="btn btn-light dropdown-toggle btn-md" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
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
			$.NotificationApp.send("Success!","New Product Category Added!","top-right","rgba(0,0,0,0.2)","success");
			showProductsCategory(1);
		}
		else{
			$.NotificationApp.send("Oh snap!","Something went wrong! Try again!","top-right","rgba(0,0,0,0.2)","success");
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
                    +'<td class="take-action text-left">'
                    	+'<a class="dropdown-item btn-rounded" href="#delete_product" onclick="deleteProductCategory('+res.result[i].pc_id+')"><i class="uil-trash-alt"></i> Delete</a>'
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
		$("#_edit_points").val(res.data.points)
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