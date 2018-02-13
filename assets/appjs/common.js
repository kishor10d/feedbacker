/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	var windowURL = window.location.href;
    pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
    var x= $('a[href="'+pageURL+'"]');
        x.addClass('active');
        x.parent().addClass('active');
    var y= $('a[href="'+windowURL+'"]');
        y.addClass('active');
        y.parent().addClass('active');
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	$.fn.editable.defaults.mode = 'inline';

    $('#rAltEmail').editable({
        type: 'text',
        pk: $("#customerId").val(),
        url: baseURL+'updateAlternateEmail',
        title: 'Enter email',
        emptytext : "Ask alternate email",
        toggle : 'dblclick'
    });
	
	$('#rAltPhone').editable({
        type: 'text',
        pk: $("#customerId").val(),
        url: baseURL+'updateAlternatePhone',
        title: 'Enter phone',
        emptytext : "Ask alternate phone",
        toggle : 'dblclick'
    });
	
	$(".statusAnchor").click(function(e){
		e.preventDefault();
		$(this).closest("form").submit();
	});
	
	var now = new Date(),
		offset = now.getTimezoneOffset();
	
	$("#refresh").click(function(e){
		var domainName = $(this).data("domainname"),
			custId = $(this).data("custid");
		$("#refreshSpinner").addClass("fa-spin");
		$.ajax({
			url : baseURL + "refreshDomainData",
			type : "POST",
			dataType : "json",
			data : { "custId": custId, "domainName" : domainName }
		}).done(function(res){
			$("#refreshSpinner").removeClass("fa-spin");
			var blink = baseURL + "uploads/captures/browser/" + res.image,
				mlink = baseURL + "uploads/captures/mobile/" + res.image;
			$("#browserImgHref").attr("href", blink);
			$("#mobileImgHref").attr("href", mlink );
			$("#browserImg").attr("src", blink );
			$("#mobileImg").attr("src", mlink );
		});		
	});
	
	$(".refreshIt").click(function(e){
		e.preventDefault();
		var domainName = $(this).data("domainname"),
		custId = $(this).data("custid");
		$("#refreshSpinner_"+custId).addClass("fa-spin");
		$.ajax({
			url : baseURL + "refreshDomainData",
			type : "POST",
			dataType : "json",
			data : { "custId": custId, "domainName" : domainName }
		}).done(function(res){
			$("#refreshSpinner_"+custId).removeClass("fa-spin");
			var blink = baseURL + "uploads/captures/browser/" + res.image,
				mlink = baseURL + "uploads/captures/mobile/" + res.image;
			$("#browserImgHref_"+custId).attr("href", blink);
			$("#mobileImgHref_"+custId).attr("href", mlink );
			$("#browserImg_"+custId).attr("src", blink );
			$("#mobileImg_"+custId).attr("src", mlink );
		});	
	});
	
	
	
	$(".delCache").click(function(e){
		e.preventDefault();
		var path = $(this).data("path"),
			spinnerId = $(this).data("spinner");
		$("#refreshSpinner_"+spinnerId).addClass("fa-spin");
		$.ajax({
			url : baseURL + "deleteCache",
			type : "POST",
			dataType : "json",
			data : { "path": path }
		}).done(function(res){
			$("#refreshSpinner_"+spinnerId).removeClass("fa-spin");
		});	
	});
	
	$("#deleteAllCache").click(function(e){
		e.preventDefault();
		$(".deleteAllCache").addClass("fa-spin");
		$.ajax({
			url : baseURL + "deleteAllCache",
			type : "POST",
			dataType : "json"
		}).done(function(res){
			$(".deleteAllCache").removeClass("fa-spin");
		});	
	});
});
