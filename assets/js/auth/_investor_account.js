
if (page == 'investor_dashboard') {
	$("#loader").removeAttr('hidden');
	f = $('#_pp_from').val();
	t = $('#_pp_to').val();

	getTotalROI()
	getProductPurchase(1, f, t)
}
$("#_sort_btn").on('click', function() {
	$("#_sales_chart").html('');
	f = $('#_from').val();
	t = $('#_to').val();

	$("#_sort_btn").text('Getting data...').attr('disabled','disabled');
	$.ajax({
		url: base_url+'api/v1/stat/investor/_sort_roi_by_date', type: 'GET', dataType: 'JSON', data: {f:f,t,t}
	})
	.done(function(res) {
		_title = 'Profit';
		_salesAreaChart(res.data.roi, _title)
		$("#_sort_btn").text('Sort').removeAttr('disabled');

	})
	.fail(function() {
		
	})
})
function sortMonthROI(m, F){
	$("#_monthly_sales").text('Loading...')
	$("#_month").text('...')

	$.ajax({
		url: base_url+'api/v1/stat/investor/_sort_monthly_roi', type: 'GET', dataType: 'JSON', data: {m:m,F,F}
	})
	.done(function(res) {
		$("#_monthly_sales").text(res.data.roi)
		$("#_month").text(F)
	})
	.fail(function() {
		
	})
}
function getTotalROI(){
	_title = '3 Month Profit';
	$.ajax({
		url: base_url+'api/v1/stat/investor/_total_roi', type: 'GET', dataType: 'JSON', data: {range:_title}
	})
	.done(function(res) {
		$("#_investment").text(res.data.investment)
		$("#_total_sales").text(res.data.total_sales)
		$("#_monthly_sales").text(res.data.monthly_sales)
		$("#_month").text(res.data.month_name)
		_salesAreaChart(res.data.roi, _title)
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		
	})
}
function _salesAreaChart(data, _title){
	date = [];
	amount = [];
	for(var i in data){
        date.push(data[i].date);
        amount.push(data[i].amount);
    }
	var options = {
        	series: [{
        	name: "Profit",
        	data: amount
      	}],
        chart: {
          	type: 'area',
          	height: 238,
          	zoom: {
            	enabled: false
          	}
        },
       	colors: ['#0acf97'],
        dataLabels: {
          	enabled: false
        },
        stroke: {
          	curve: 'smooth'
        },
        
        title: {
          	text: _title,
          	align: 'left',
          	colors: '#98a6ad',
        },
        subtitle: {
          	text: '',
          	align: 'left'
        },
        labels: date,
        xaxis: {
          	type: 'datetime',
        },
        yaxis: {
          	opposite: true
        },
        legend: {
          	horizontalAlign: 'left'
        }
    };

    var chart = new ApexCharts(document.querySelector("#_sales_chart"), options);
    chart.render();
}
function getProductPurchase(page, f, t){
	$("#_product_purchase_tbl").html('<tr class="text-center"><td colspan="4">Getting product purchase...</td></tr>');
	$('#_product_purchase_pagination').html('');
	$("#_product_puchase_count").text('0')


	$.ajax({
		url: base_url+'api/v1/stat/investor/_product_purchase', type: 'GET', dataType: 'JSON', data: {page:page, f:f, t:t}
	})
	.done(function(res) {
		result = res.result;
		string = '';
		$("#_product_puchase_count").text(res.count)
		$('#_product_purchase_pagination').html(res.pagination);

		for(var i in result) {
			string += '<tr>'
               	+'<td class="table-user">'
                   	+'<a href="javascript:void(0);" class="text-body"">'+result[i].ordered_date+'</a>'
               	+'</td>'
               	+'<td>'
                   	+'<span class=""><a href="'+result[i].product_url+'" target="_blank">'+result[i].product_name+'</a></span>'
               	+'</td>'
               	+'<td>'
                   	+'<span class=""><a href="'+result[i].category_url+'" target="_blank">'+result[i].category+'</a></span>'
               	+'</td>'
               	+'<td>'
                   	+'<span class="">'+result[i].earned+'</span>'
               +'</td>'
           	+'</tr>'
		}
		$("#_product_purchase_tbl").html(string);
		$("#loader").attr('hidden','hidden');
	})
	.fail(function() {
		
	})
}
$('#_product_purchase_pagination').on('click','a',function(e){
    e.preventDefault(); 
    f = $('#_pp_from').val();
	t = $('#_pp_to').val();

    var page = $(this).attr('data-ci-pagination-page');
    getProductPurchase(page, f, t);
});
$('#_sort_purchase_btn').on('click', function(e){
    e.preventDefault(); 
    f = $('#_pp_from').val();
	t = $('#_pp_to').val();

    getProductPurchase(1, f, t);
});
$('#_refresh_purchase').on('click', function(e){
    e.preventDefault(); 
    f = $('#_pp_from').val();
	t = $('#_pp_to').val();

    getProductPurchase(1, f, t);
});