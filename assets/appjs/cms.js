/**
 * @author Kishor Mali
 */

jQuery(document).ready(function(){
	
	tinymce.init({
        selector:'#emailTemplate',
        toolbar_items_size: 'small',
        theme: 'modern',
        menubar: true,
        statusbar: true,
        height : 500,
        plugins: [
                  'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                  'searchreplace wordcount visualblocks visualchars code fullscreen',
                  'insertdatetime media nonbreaking save table contextmenu directionality',
                  'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        onchange_callback: function(editor) {
            tinyMCE.triggerSave();            
            $("#" + editor.id).valid();
        }
    });
	
	
	var editAttach = $("#editAttachment");
	
	var editAttachValidator = editAttach.validate({
		rules:{
			attFile :{ extension : "pdf" }
		},
		messages:{
			attFile :{ extension : "Select files with extension PDF only"}
		}
	});
	
	var addAttach = $("#addAttachment");
	
	var addAttachValidator = addAttach.validate({
		rules:{
			attFile :{ required : true,  extension : "pdf" }
		},
		messages:{
			attFile :{ required : "You must select a file to upload", extension : "Select files with extension PDF only"}
		}
	});

	tinymce.init({
        selector:'#emailHTML',
        toolbar_items_size: 'small',
        theme: 'modern',
        menubar: false,
        statusbar: true,
        height : 150,
        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        onchange_callback: function(editor) {
            tinyMCE.triggerSave();            
            $("#" + editor.id).valid();
        }
    });
	
	$("#companyList").on("change", function(){
		jQuery.ajax({
			type : "POST",
			url : baseURL + "getTemplateByCompId",
			data : {companyId : $(this).val() },
			dataType : "json",
			async : true
		}).done(function(res){
			if(res.status == true){
				$("#emailHTML").html(res.data[0].temp_html);
				tinyMCE.get('emailHTML').setContent(res.data[0].temp_html);
			}
			else{
				$("#emailHTML").html("");
				tinyMCE.get('emailHTML').setContent("");
			}
		});
	});
	
	var emailPortfolioForm = $("#emailPortfolioForm");
	
	var emailPortfolioFormValidator = emailPortfolioForm.submit(function(){
        $("#emailHTML").addClass('textnothide');
        tinyMCE.triggerSave();
	}).validate({
		ignore: "",
		rules:{
			companyList : {required:true},
			typeList : {required:true},
			email : {required : true, email : true},
			subject : {required : true },
			emailHTML : { required : true},
			extraAttFile :{ extension : "pdf" }
		},
		messages:{
			extraAttFile :{ extension : "Select files with extension PDF only"}
		}
	});
	
	$("#emailSendSubmit").click(function(){
		if(emailPortfolioForm.valid()){
			var yes = confirm("Do you want to send email?");
			if(yes){
				var loadingHTML = "<i class='fa fa-spinner' aria-hidden='true'></i> Sending Email";
				$(this).html(loadingHTML);
				$(this).prop("disabled",true);
				emailPortfolioForm.submit();
			}
		}
	});
	
});