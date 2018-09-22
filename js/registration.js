$(document).ready(function()
{

	$("#friendemailfrm").submit(function()
    {       
		var pid = $("#emailtofriendpid").val();
		var size = $("#emailtofriendpsize").val();
		var email = $('#friendemail').val();
		if(email==""){
			alert("Email is required");
			return false;
		}
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var result = email.split(",");
		 for(var i = 0;i < result.length;i++){
				if(pattern.test(result[i])){
			}else{
				alert("Email is not valid ("+result[i]+")");
				return false;
			}
		}
		
	   $.post("emailtofriend.php",{ email:email,pid:pid,size:size,rand:Math.random() } ,function(data)
        {
          alert(data);
        });
        return false; //not to post the  form physically
    });


	$('#wishlist').on("click",function(){
		var productId = $(this).attr("wishlist");
		$.post("wishlist.php",{productid:productId,rand:Math.random()}, function(data){
			if(data){
				alert(data);
			}
		});
	});
	
	$('a[id^="notyfyme"]').on("click",function(){
            var productId = $(this).attr("rel_notifyme");
			$("#notifypid").val(productId);
			return true;
	});
	
	$("#notyfymefrm").submit(function()
    {       
		var pid = $("#notifypid").val();
		var email = $('#notifyemail').val();
		var contact = $('#notifycontact').val();
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(pattern.test(email)){
		}else{
			alert("Email is not valid");
			return false;
		}
		
		var pureNumber = contact.replace(/\D/g, "");
		var isValid = pureNumber.length >= 10 && contact.match(/^[\(\)\s\-\+\d]{10,17}$/);
		if(isValid){}else{
			alert("Contact number is not valid");
			return false;
		}
	   $.post("notifyme.php",{ contact:$('#notifycontact').val(),email:$('#notifyemail').val(),description:$('#notifydescription').val(),pid:pid,rand:Math.random() } ,function(data)
        {
          if(data=='yes') //if correct login detail
          {
            $("#notifymemsg").fadeTo(200,0.1,function()  //start fading the messagebox
            { 
              //add message and change the class of the box and start fading
              $(this).html('Thank you for choosing G N S Audios. We will inform you once this product is available.Sorry for the inconvenience.').addClass('messageboxsuccess').fadeTo(900,1,
              
               function()
               { 
				//$("#notyfymefrm").hide();
                 $('#notifycontact').val("");
                  $('#notifyemail').val("");
                   $('#notifydescription').val("");
				  $(this).fadeOut(10000);
                           
              });
              
            });
          }else{
            $("#notifymemsg").fadeTo(200,0.1,function() //start fading the messagebox
            { 
              //add message and change the class of the box and start fading
              $(this).html('Your notify me detail sucks...Try Again!').addClass('messageboxerror').fadeTo(900,1);
            });     
          }
                
        });
        return false; //not to post the  form physically
    });
	
	$("#enquiryfrm").submit(function()
    {       
		var email = $('#enquiryemail').val();
		var contact = $('#enquirycontact').val();
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(pattern.test(email)){
		}else{
			alert("Email is not valid");
			return false;
		}
		
		var pureNumber = contact.replace(/\D/g, "");
		var isValid = pureNumber.length >= 10 && contact.match(/^[\(\)\s\-\+\d]{10,17}$/);
		if(isValid){}else{
			alert("Contact number is not valid");
			return false;
		}
	   $.post("enquiry.php",{ contact:$('#enquirycontact').val(),email:$('#enquiryemail').val(),description:$('#enquirydescription').val(),pid:$("#enquirypid").val(),rand:Math.random() } ,function(data)
        {
          if(data=='yes') //if correct login detail
          {
            $("#enquirymsg").fadeTo(200,0.1,function()  //start fading the messagebox
            { 
              //add message and change the class of the box and start fading
              $(this).html('Thank you for choosing G N S Audios. We will inform you once about your information.').addClass('messageboxsuccess').fadeTo(900,1,
              
               function()
               { 
		$("#enquiryfrm").hide();
                 $('#enquiryname').val("");
                  $('#enquiryemail').val("");
                   $('#enquirydescription').val("");
                           
              });
              
            });
          }else{
            $("#enquirymsg").fadeTo(200,0.1,function() //start fading the messagebox
            { 
              //add message and change the class of the box and start fading
              $(this).html('Your enquiry detail sucks...Try Again!').addClass('messageboxerror').fadeTo(900,1);
            });     
          }
                
        });
        return false; //not to post the  form physically
    });
    
    $("#registrationfrm").submit(function()
    {
        alert($('#password').val());
        alert($('#cnfpassword').val());
        if($('#password').val()!=$('#cnfpassword').val()){
             $("#msgboxr").fadeTo(200,0.1,function(){ 
              
                  $(this).html('Your password and confirm password are not matching!').addClass('messageboxerror').fadeTo(900,1);                 
                  return false;
            });     
          }          
        
        //remove all the class add the messagebox classes and start fading
        $("#msgboxr").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
        //check the username exists or not from ajax
        $.post("registration.php",{ user_name:$('#name').val(),email:$('#email').val(),password:$('#password').val(),cnfpassword:$('#cnfpassword').val(),rand:Math.random() } ,function(data)
        {
          if(data=='yes') //if correct login detail
          {
            $("#msgboxr").fadeTo(200,0.1,function()  //start fading the messagebox
            { 
              //add message and change the class of the box and start fading
              $(this).html('Sign up has been successful').addClass('messageboxsuccess').fadeTo(900,1,
              
               function()
               { 
                 $('#name').val("");
                  $('#email').val("");
                   $('#password').val("");
                    
                // $('.poplogin_form').modal('hide');
                 //redirect to secure page
                // $(this).html('Sign up is successfull').addClass('messageboxsuccess').fadeTo(900,1);
                 
              });
              
            });
          }else{
            $("#msgboxr").fadeTo(200,0.1,function() //start fading the messagebox
            { 
              if(data=='pno'){
                  $(this).html('Your password and confirm password are not matching!').addClass('messageboxerror').fadeTo(900,1);
                  return false;
              }
              //add message and change the class of the box and start fading
              $(this).html('Your sign up detail sucks...Try Again!').addClass('messageboxerror').fadeTo(900,1);
            });     
          }
                
        });
        return false; //not to post the  form physically
    });
    //now call the ajax also focus move from 
   // $("#password").blur(function()
   // {
       // $("#registrationfrm").trigger('submit');
   /// });

$("#loginfrm").submit(function()
    {
        
        //remove all the class add the messagebox classes and start fading
        $("#msgboxl").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
        //check the username exists or not from ajax
        $.post("login.php",{ email:$('#uemail').val(),password:$('#upassword').val(),rand:Math.random() } ,function(data)
        {
          if(data=='yes') //if correct login detail
          {
            $("#msgboxl").fadeTo(200,0.1,function()  //start fading the messagebox
            { 
              //add message and change the class of the box and start fading
              $(this).html('You have logged in now').addClass('messageboxsuccess').fadeTo(1500,1,
              
               function()
               { 
                 
                  $('#uemail').val("");
                   $('#upassword').val("");
                     document.location='index.php';
                // $('.poplogin_form').modal('hide');
                 //redirect to secure page
                // $(this).html('Sign up is successfull').addClass('messageboxsuccess').fadeTo(900,1);
                 
              });
              
            });
          }else{
            $("#msgboxl").fadeTo(200,0.1,function() //start fading the messagebox
            { 
              //add message and change the class of the box and start fading
              $(this).html('Your sign in detail sucks...Try Again!').addClass('messageboxerror').fadeTo(900,1);
            });     
          }
                
        });
        return false; //not to post the  form physically
    });
});