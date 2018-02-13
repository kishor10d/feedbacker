/**
 * @author Kishor Mali
 */


$(document).ready(function(){
	
   jQuery.validator.addMethod("selected", function(value, element){
	   if(value == 0) { return false; }
       else { return true; }
   },"This field is required.");

   jQuery.validator.addMethod("acceptImgExtension", function(value, element){
       if(value == ""){
           return true;
       } else {
           var extension = (value.substring(value.lastIndexOf('.') + 1)).toLowerCase();
           if(extension == 'jpg'|| extension=='png' || extension == "jpeg" || extension == "gif"){ return true; }
           else{ return false; }
       }
   }, "");
   
   jQuery.validator.addMethod("acceptDocExtension", function(value, element){
       if(value == ""){
           return true;
       } else {
    	   var extension = (value.substring(value.lastIndexOf('.') + 1)).toLowerCase();
           if(extension == 'jpg'|| extension=='png' || extension == "jpeg" || extension == "gif"){ return true; }
           else{ return false; } 
       }
   }, "");
   
   jQuery.validator.addMethod("checkEmailExist", function(value, element){
       var response = false;
       var post_url_check_email = baseurl +"user/checkEmailExist/";
       $.ajax({
              type: "POST",
              url: post_url_check_email,
              data: {email : value},
              dataType: "json",
              async: false
       }).done(function(result){
            if(result.status == true){response = false;}
            else{response = true;}
       });
       return response;
   }, "Email already taken.");
   
   jQuery.validator.addMethod('checkDateFormat', function(value, element){
       var stringPattern = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/gm;           
       if(stringPattern.test(value)){return true;}
       else{return false;}
   },"Please enter correct date.");
   
   jQuery.validator.addMethod('checkWhiteSpaces', function(value, element){    
       var stringPattern = /\s/;           
       if(stringPattern.test(value)) { return false; }
       else { return true; }
   },"Spaces are not allowed in username.");
   
});
