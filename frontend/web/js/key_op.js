/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$("#steem-btn-save").click(function() {
  $('.loader').show();
  
   client_identy = get_client_identy();
   
   if (getCookie('steemsig')) {
       deleteCookie('steemsig');
       deleteCookie('steemac');
   }
   
   var wif =  $('#STEEM').val();
   try{
   var pub_key = convert_to_pub_key_steem(wif);
   
   check_pub_key_steem(pub_key, function steem_callback(err, result){
   
   //check key here
   if (!err){
       if (result[0][0] != null){
       put_key_to_cookie('steemsig', wif);
       setCookie('steemac', result[0][0], {"path": "/", "expires": 31536000});
       $('#STEEM').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
       $('#STEEM').prop('disabled', true);
       $("#steem-btn-save").hide();
       $("#steem-btn-edit").show();
       $('#steem_pass_form').hide();
       } else {
           alert('Sorry, this key not linked to any account');
             $('#STEEM').val('');
         }
   }
   else {
       $('.loader').hide();
       alert ('Wrong private posting key. Try again.');
   }
  
    
  $('.loader').hide();
  
   });
} catch(err) {$('.loader').hide();
    alert('This is NOT private key');
    }
});
   
   
   
$("#steem-btn-save_pass").click(function() {
   $('.loader').show();
  
   client_identy = get_client_identy();
   
   if (getCookie('steemsig')) {
       deleteCookie('steemsig');
       deleteCookie('steemac');
   }
   var username = $('#username').val();
   var password =  $('#STEEM_pass').val();
   try{
   var wif = steem.auth.toWif(username, password, 'posting');
   var pub_key = convert_to_pub_key_steem(wif);
   
   check_pub_key_steem(pub_key, function steem_callback(err, result){
   
   //check key here
   if (!err){
       if (result[0][0] != null){
       put_key_to_cookie('steemsig', wif);
       setCookie('steemac', result[0][0], {"path": "/", "expires": 31536000});
       $('#STEEM').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
       $('#STEEM').prop('disabled', true);
       $("#steem-btn-save").hide();
       $("#steem-btn-edit").show();
       $('#steem_pass_form').hide();
   
       } else {
           alert('Sorry, this key not linked to any account');
             $('#STEEM').val('');
         }
   }
   else {
       $('.loader').hide();
       alert ('Wrong private posting key. Try again.');
   }
   $('.loader').hide();
   
  
   });
} catch(err) {$('.loader').hide();
    alert('This is NOT private key');
    }
});
   
   
   
$("#golos-btn-save_pass").click(function() {
    $('.loader').show();
  
   client_identy = get_client_identy();
   
   if (getCookie('golossig')) {
       deleteCookie('golossig');
       deleteCookie('golosac');
   }
   var username = $('#username').val();
   var password =  $('#GOLOS_pass').val();
   //check key here
   
   try{
       var wif = steem.auth.toWif(username, password, 'posting');
       var pub_key = convert_to_pub_key_golos(wif);

   check_pub_key_golos(pub_key, function golos_callback(err, result){ 
    
   //check key here
   if (!err){
       if (result[0][0] != null){
       put_key_to_cookie('golossig', wif);
       setCookie('golosac', result[0][0], {"path": "/", "expires": 31536000});
       $('#GOLOS').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
       $('#GOLOS').prop('disabled', true);
       $("#golos-btn-save").hide();
       $("#golos-btn-edit").show();
       $('#golos_pass_form').hide();
       } else {
           alert('Sorry, this key not linked to any account');
             $('#GOLOS').val('');
         }

   }
   else {
       alert ('Wrong private posting key. Try again.');
   }
    $('.loader').hide();
  
  
   });
   } catch(err){
        $('.loader').hide();
         alert('This is NOT private key');
   }
});

   


$("#steem-btn-edit").click(function() {
     deleteCookie('steemsig');
     deleteCookie('steemac');
     $('#STEEM').prop('disabled', false);
     $("#steem-btn-save").show();
     $("#steem-btn-edit").hide();
     $('#STEEM').val('');
     $('#STEEM_pass').val('');
     $('#steem_pass_form').show();
     $('.loader').hide();
     
});



$("#golos-btn-save").click(function() {
    $('.loader').show();
  
   client_identy = get_client_identy();
   
   if (getCookie('golossig')) {
       deleteCookie('golossig');
       deleteCookie('golosac');
   }
   
   var wif =  $('#GOLOS').val();
   //check key here
   try{
   var pub_key = convert_to_pub_key_golos(wif);
   
   check_pub_key_golos(pub_key, function golos_callback(err, result){ 
    
   //check key here
   if (!err){
       if (result[0][0] != null){
       put_key_to_cookie('golossig', wif);
       setCookie('golosac', result[0][0], {"path": "/", "expires": 31536000});
       $('#GOLOS').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
       $('#GOLOS').prop('disabled', true);
       $("#golos-btn-save").hide();
       $("#golos-btn-edit").show();
       $('#golos_pass_form').hide();
       } else {
           alert('Sorry, this key not linked to any account');
             $('#GOLOS').val('');
         }

   }
   else {
       alert ('Wrong private posting key. Try again.');
   }
    
    $('.loader').hide();
  
   });
   } catch(err){
        $('.loader').hide();
         alert('This is NOT private key');
   }
});



$("#golos-btn-edit").click(function() {
     deleteCookie('golossig');
     deleteCookie('golosac');
     $('#GOLOS').prop('disabled', false);
     $("#golos-btn-save").show();
     $("#golos-btn-edit").hide();
     $('#GOLOS').val('');
     $('#GOLOS_pass').val('');
     $('#golos_pass_form').show();
     $('.loader').hide();
     
});


function check_pub_key_steem(pub_key, steem_callback){
    
 steem.api.getKeyReferences([pub_key], function(err, result) {
        steem_callback(err, result);
            
        
    });
}

function check_pub_key_golos(pub_key, golos_callback){
    
 steem.api.getKeyReferences([pub_key], function(err, result) {  //CHANGE TO GOLOS
        golos_callback(err, result);
            
        
    });
}


function convert_to_pub_key_steem(wif){
 
    return steem.auth.wifToPublic(wif);
    
}


function convert_to_pub_key_golos(wif){
 
    return steem.auth.wifToPublic(wif);
    
}
