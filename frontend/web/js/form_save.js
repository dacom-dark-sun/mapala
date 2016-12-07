/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

     
$(document).on("beforeSubmit", "#add-form", function () {
    // send data by ajax request.
    var form = $(this);
   
       $.ajax({
            url    : form.attr('action'),
            type   : 'post',
            data   : form.serialize(),
            success: function (data) 
            {
                console.log(data);
           //     comment(data);
            },
            error  : function () 
            {
                console.log('internal server error');
            }
            });
   
    return false; // Cancel form submitting.
});
     
     