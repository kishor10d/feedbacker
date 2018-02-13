/**
 * File : followUp.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var followUp = $("#followUp");
	
	var followUpValidator = followUp.submit(function(){
        $("#callSummary").addClass('textnothide');
        tinyMCE.triggerSave();
    })
    .validate({
		ignore: "",
		rules:{
			callSummary : { required : true},
			fbType : {required : true},

		},
        errorPlacement: function(label, element) {
            // position error label after generated textarea
            if (element.is("textarea")) {
                label.insertAfter(element);
            } else {
                label.insertAfter(element);
            }
        }
	});

    /*followUpValidator.focusInvalid = function() {
        // put focus on tinymce on submit validation
        if (this.settings.focusInvalid) {
            try {
                var toFocus = $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []);
                if (toFocus.is("textarea")) {
                    tinyMCE.get(toFocus.attr("id")).focus();
                } else {
                    toFocus.filter(":visible").focus();
                }
            } catch (e) {
                // ignore IE throwing errors when focusing hidden elements
            }
        }
    };*/

    tinymce.init({
        selector:'#callSummary',
        toolbar_items_size: 'small',
        theme: 'modern',
        menubar: false,
        statusbar: false,
        height : "150",
        toolbar : "styleselect | bold italic | bullist numlist outdent indent",
        onchange_callback: function(editor) {
            tinyMCE.triggerSave();            
            $("#" + editor.id).valid();
        }
    });

    tinymce.init({
        selector:'#reqSummary',
        toolbar_items_size: 'small',
        theme: 'modern',
        menubar: false,
        statusbar: true,
        height : "250"
    });

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('#nextCallDate').datepicker({
        autoclose: true,
        todayHighlight : true,
        format: 'dd/mm/yyyy',
        startDate : today
    });

    $('#nextCallTime').timepicker();

    $("#nextCallDate").attr("value", null);
    $('#nextCallTime').val(null);
    
    $('#toDate').datepicker({
        autoclose: true,
        todayHighlight : true,
        format: 'dd/mm/yyyy',
        startDate : today
    });

    var recRem = $("#recRem");

    var recRemValidator = recRem.submit(function(){
        $("#reqSummary").addClass('textnothide');
        tinyMCE.triggerSave();
    })
    .validate({
        ignore: "",
        rules:{
            reqSummary : { required : true},
            estimatedCost : {maxlength : 20 },
            custCost : {maxlength : 20 }

        },
        errorPlacement: function(label, element) {
            // position error label after generated textarea
            if (element.is("textarea")) {
                label.insertAfter(element);
            } else {
                label.insertAfter(element);
            }
        }
    });

    $("#exportPDF").click(function(e){

        e.preventDefault();

        $.ajax({
            url : baseURL + "reqExportAsPDF",
            data : { custId : $("#customerId").val() },
            type : "POST",
            dataType : "json"
        }).done(function(data){
            console.log("success");
        })
    });
    
    $('#conversionDate').datepicker({
        autoclose: true,
        todayHighlight : true,
        format: 'dd/mm/yyyy',
        startDate : today
    });
    
    $('.forceOpenPicker').click(function(e){
    	$(this).next().datepicker('show');
    });
    
    $('#conversionTime').timepicker({
    	showMeridian : false
    });
    
    $('.forceOpenTimePicker').click(function(e){
    	$(this).next().trigger('focus');
    });
    
    var timezoneConversion = function(){    
    	var dateArray = $("#conversionDate").val().split("/");
    	var timeArray = $("#conversionTime").val().split(":");
    	var getDate = new Date( parseInt(dateArray[2]), parseInt(dateArray[1])-1, parseInt(dateArray[0]), parseInt(timeArray[0]), parseInt(timeArray[1]));    	
    	var theirsDTM = new Date( getDate.getTime() + offset * 1000 + parseInt(dstOffset)).toUTCString().replace( / GMT$/, "" );
    	var splitter = theirsDTM.split(" "),
			theirsDate = splitter[1]+" "+splitter[2]+" "+splitter[3],
			theirsTime = splitter[4];
    	$("#convertedDate").html(theirsDate);
		$("#convertedTime").html(theirsTime);
    };
    
    $("#conversionDate").on("change",timezoneConversion);
    $("#conversionTime").on("change",timezoneConversion);
        
    $("#btnTimeConversion").click(function(e){
    	e.preventDefault();
    	$("#btnTimeConversionDiv").addClass("displayNone");
    	$(".timeConversionDiv").removeClass("displayNone");
    });
    
    $("#btnTimeConversionComplete").click(function(e){
    	e.preventDefault();
    	$(".timeConversionDiv").addClass("displayNone");
    	$("#btnTimeConversionDiv").removeClass("displayNone");
    });
});