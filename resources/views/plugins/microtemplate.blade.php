<script type="text/javascript">
	/* delete document */
	$('.btn-delete-doc').on('click', function(){bind_delete($(this))});
	$('.btn-add-doc').bind('click', function(e){			
		var template = '';		

		template += '<div class="row"> \
						<div class="col-sm-5"> \
							<div class="form-group"> \
								<label for="field[]" class="control-label">Nama Input</label> \
								<input type="text" class="form-control no-enter" id="field[]" name="field[]"> \
							</div> \
						</div> \
						<div class="col-sm-5"> \
							<div class="form-group"> \
								<label for="" class="control-label">Tipe Input</label> \
								<select id="Type" class="form-control form-control input-md type" name="type[]"> \
									<option value="numeric">Angka</option> \
									<option value="date">Tanggal</option> \
									<option value="string">Teks Singkat</option> \
									<option value="text">Teks Panjang</option> \
								</select> \
							</div> \
						</div> \
						<div class="col-sm-2"> \
							<div class="form-group"> \
								<a href="javascript:;" class="btn-delete-doc" style="color:#666;"><i class="fa fa-minus-circle fa-lg mt-30"></i></a> \
							</div> \
						</div> \
					</div> \
					';	
						
		$("#template").append(template);
		$('#template input, #template select').on("keyup keypress", function(e) {
			var code = e.keyCode || e.which; 
			if (code  == 13) 
			{
				e.preventDefault();
				return false;
			}
		});
		$('.btn-delete-doc').on('click', function(){bind_delete($(this))});			
	});	
		
	function bind_delete(e) {		
		$(e).parent().parent().parent().remove();
		$('.btn-delete-doc').on('click', function(){bind_delete($(this))});		
	}

		// 	console.log(val);
		// 	console.log(val.key);
		// });
	/* delete filter */
	$('.btn-delete-filter').on('click', function(){bind_delete_filter($(this))});
	$('.filter-key').on('change', function(){create_o($(this))});
	function create_o(e)
	{
		var fil = $(e).val().split('_');
		var a 	= new Object();
		var tmp = '';
		
		fil 	= fil[1];
		jQuery.each(x, function(i, val) {
			a[val.key] = val.values;
		});
		// $(e).parent().html('');
		// tmp 	+= '<div class="btn-group ml-10"> \
		// 					<select name="key[]" id="" class="form-control filter-key"> \
		// 			';
		jQuery.each(a[fil], function(i, val) {
			tmp +='<option value="'+val.key+'">'+val.value+'</option>';
		});

		// tmp += '</select></div>';

		$('.filter-value').html(tmp);
		$('.filter-key').on('change', function(){create_o($(this))});
	}


	$('.btn-add-filter').bind('click', function()
	{
		var template = '';
		template += '<div class="btn-group ml-10"> \
							<select name="key[]" id="" class="form-control filter-key"> \
					';
					jQuery.each(x, function(i, val)
					{
						template +='<option value="'+val.prefix+'_'+val.key+'">'+val.value+'</option>';
					});
		template +='</select> \
						</div> \
						<div class="btn-group ml-10"> \
							<select name="value[]" id="" class="form-control filter-value"> \
								<option value=""></option> \
					';

					// for (var i=0; i<x.length; i++)
					// {
					// 	for (var j=0; i<x.length)
					// 	$.each(x.value, function(j, val2)
					// 	{
					// 		template +='<option value="">'+val2.value+'</option>';
					// 	});
					// }

		template +='</select> \
						</div>\
					';
		$('.filter-add').parent().append(template);
		$('.btn-delete-filter').on('click', function(){bind_delete_filter($(this))});
		$('.filter-key').on('change', function(){create_o($(this))});
	});	

	function bind_delete_filter(e) {

	}
</script>