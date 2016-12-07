/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$("#steem-btn-save").click(function() {
   $('#steem_load').show();
  
   client_identy = get_client_identy();
   
   if (getCookie('steemsig')) {
       deleteCookie('steemsig');
   }
   
   var wif =  $('#STEEM').val();
   try{
   var pub_key = convert_to_pub_key_steem(wif);
   
   check_pub_key_steem(pub_key, function steem_callback(err, result){
   
   //check key here
   if (!err){
       put_key_to_cookie('steemsig', wif);
       $('#STEEM').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
       $('#STEEM').prop('disabled', true);
       $("#steem-btn-save").hide();
       $("#steem-btn-edit").show();
      
   }
   else {
       $('#steem_load').hide();
       alert ('Wrong private posting key. Try again.');
   }
   $('#steem_load').hide();
  
   });
} catch(err) {$('#steem_load').hide();
    alert('This is NOT private key');
    }
});
   
   


$("#steem-btn-edit").click(function() {
     deleteCookie('steemsig');
     $('#STEEM').prop('disabled', false);
     $("#steem-btn-save").show();
     $("#steem-btn-edit").hide();
     $('#STEEM').val('');
     
});



$("#golos-btn-save").click(function() {
    $('#golos_load').show();
  
   client_identy = get_client_identy();
   
   if (getCookie('golossig')) {
       deleteCookie('golossig');
   }
   
   var wif =  $('#GOLOS').val();
   //check key here
   try{
   var pub_key = convert_to_pub_key_golos(wif);
   
   check_pub_key_golos(pub_key, function golos_callback(err, result){ 
    
   //check key here
   if (!err){
       put_key_to_cookie('golossig', wif);
       $('#GOLOS').val('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');
       $('#GOLOS').prop('disabled', true);
       $("#golos-btn-save").hide();
       $("#golos-btn-edit").show();
   }
   else {
       alert ('Wrong private posting key. Try again.');
   }
    $('#golos_load').hide();
  
   });
   } catch(err){
        $('#golos_load').hide();
         alert('This is NOT private key');
   }
});



$("#golos-btn-edit").click(function() {
     deleteCookie('golossig');
     $('#GOLOS').prop('disabled', false);
     $("#golos-btn-save").show();
     $("#golos-btn-edit").hide();
     $('#GOLOS').val('');
     
});


function check_pub_key_steem(pub_key, steem_callback){
    
 steem.api.getKeyReferences([pub_key], function(err, result) {
        console.log(err, result);
        steem_callback(err, result);
            
        
    });
}

function check_pub_key_golos(pub_key, golos_callback){
    
 steem.api.getKeyReferences([pub_key], function(err, result) {  //CHANGE TO GOLOS
        console.log(err, result);
        golos_callback(err, result);
            
        
    });
}


function convert_to_pub_key_steem(wif){
 
    return steem.auth.wifToPublic(wif);
    
}


function convert_to_pub_key_golos(wif){
 
    return steem.auth.wifToPublic(wif);
    
}
