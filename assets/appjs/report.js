/**
 * File : report.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('#reportDate').datepicker({
        autoclose: true,
        todayHighlight : true,
        format: 'dd/mm/yyyy',
        endDate : today
    });

    $("#reportDate").attr("value", null);
    
    var employeeReportForm = $("#employeeReportForm");
	
	var employeeReportFormValidator = employeeReportForm.validate({
		rules:{
			employees : { required : true }
		}
	});
});