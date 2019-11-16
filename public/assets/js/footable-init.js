
$(window).on('load', function() {

	$('.demo-pagination').footable();
	
	

	
	// $('#demo-input-search2').on('input', function (e) {
	// 	e.preventDefault();
	// 	addrow.trigger('footable_filter', {filter: $(this).val()});
	// });
	$('#demo-input-search2').on('input', function (e) {
		e.preventDefault();
		addrow.trigger('footable_filter', {filter: $(this).val()});
	});
	$('.demo-input-search').on('input', function (e) {
		e.preventDefault();
		addrow.trigger('footable_filter', {filter: $(this).val()});
	});
	
	
 //    var addrow = $('table.demo-pagination');
	// addrow.footable().on('click', '.delete-row-btn', function() {

	// 	//get the footable object
	// 	var footable = addrow.data('footable');

	// 	//get the row we are wanting to delete
	// 	var row = $(this).parents('tr:first');

	// 	//delete the row
	// 	footable.removeRow(row);
	// });
	 var addrow = $('#demo-foo-pagination');
	addrow.footable().on('click', '.delete-row-btn', function() {

		//get the footable object
		var footable = addrow.data('footable');

		//get the row we are wanting to delete
		var row = $(this).parents('tr:first');

		//delete the row
		footable.removeRow(row);
	});
	// Add Row Button
	
});
