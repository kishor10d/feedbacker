/**
 * File : assignCustomer.js 
 * 
 * This file contain the validation of assign customers to executives form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	$("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

	var assignCustomersForm = $("#assignCustomers");
	
	var assignCustomersFormValidator = assignCustomersForm.validate({
		
		rules:{
			'isChecked[]' :{ required : true },
			executive : { required : true }
		},
		messages:{
			'isChecked[]' :{ required : "Select atleast one record"}
		}
	});
});