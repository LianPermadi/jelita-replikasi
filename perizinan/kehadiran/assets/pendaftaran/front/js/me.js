$(document).ready(function(){
	var form1 = $('#form');
	var errorHandler1 = $('.errorHandler', form1);
	var successHandler1 = $('.successHandler', form1);
	$.validator.addMethod("FullDate", function () {
		//if all values are selected
		if ($("#dd").val() != "" && $("#mm").val() != "" && $("#yyyy").val() != "") {
			return true;
		} else {
			return false;
		}
	}, 'Please select a day, month, and year');
	$('#form').validate({
		errorElement: "span", // contain the error msg in a span tag
		errorClass: 'help-block',
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
				error.insertAfter($(element).closest('.form-group').children('div').children().last());
			} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
				error.insertAfter($(element).closest('.form-group').children('div'));
			} else {
				error.insertAfter(element);
				// for other inputs, just perform default behavior
			}
		},
		ignore: "",
		rules: {
			firstname: {
				minlength: 2,
				required: true
			},
			lastname: {
				minlength: 2,
				required: true
			},
			email: {
				required: true,
				email: true
			},
			password: {
				minlength: 6,
				required: true
			},
			password_again: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			yyyy: "FullDate",
			gender: {
				required: true
			},
			zipcode: {
				required: true,
				number: true,
				minlength: 5,
				minlength: 5
			},
			city: {
				required: true
			},
			newsletter: {
				required: true
			}
		},
		messages: {
			firstname: "Please specify your first name",
			lastname: "Please specify your last name",
			email: {
				required: "We need your email address to contact you",
				email: "Your email address must be in the format of name@domain.com"
			},
			gender: "Please check a gender!"
		},
		groups: {
			DateofBirth: "dd mm yyyy",
		},
		invalidHandler: function (event, validator) { //display error alert on form submit
			successHandler1.hide();
			errorHandler1.show();
		},
		highlight: function (element) {
			$(element).closest('.help-block').removeClass('valid');
			// display OK icon
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
			// add the Bootstrap error class to the control group
		},
		unhighlight: function (element) { // revert the change done by hightlight
			$(element).closest('.form-group').removeClass('has-error');
			// set error class to the control group
		},
		success: function (label, element) {
			label.addClass('help-block valid');
			// mark the current input as valid and display OK icon
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
		},
		submitHandler: function (form) {
			successHandler1.show();
			errorHandler1.hide();
			// submit form
			//$('#form').submit();
		}
	});
	
	var oTable = $('#sample_1').dataTable({
            "aoColumnDefs": [{
                "aTargets": [0]
            }],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "aaSorting": [
                [0, 'asc']
            ],
            "aLengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });
        $('#sample_1_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        // modify table search input
        $('#sample_1_wrapper .dataTables_length select').addClass("m-wrap small");
        // modify table per page dropdown
        $('#sample_1_wrapper .dataTables_length select').select2();
        // initialzie select2 dropdown
        $('#sample_1_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
	
});