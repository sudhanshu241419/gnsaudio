$(document).ready(function()
{
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
    //now call the ajax also focus move from 
   // $("#password").blur(function()
   // {
       // $("#registrationfrm").trigger('submit');
   /// });
});