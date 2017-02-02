/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    //SET LOCAL USER BROWSER DATE TO Date, came from our server
  



function vote(current_blockchain, author, permlink, weight){

current_blockchain = current_blockchain.toLowerCase();
current_blockchain = current_blockchain + 'sig';



var wif = get_wif(current_blockchain);

if (wif.status  ==  'success'){
try{
    $('#icon_' + permlink).addClass('vote-process'); 
    pub_key = convert_to_pub_key_steem(wif.plaintext);

    check_pub_key_steem(pub_key, function steem_callback(err, result){ 
    if (!err){
        var voter = result[0][0];
        steem.broadcast.vote(wif.plaintext, voter, author, permlink, weight, function(err, result) {
            if (err) {
                $('#icon_' + permlink).removeClass('vote-process'); 
                alert (err);

            } else {
                 $('#icon_' + permlink).removeClass('vote-process'); 
                 $("#" + permlink).css('z-index', 10);

            };
            
        console.log(err, result);
        });
      
        
        
    }
    else {
        alert(err);
        $('#icon_' + permlink).removeClass('vote-process'); 

    }
  
   });
  
} catch(err){ alert('Key Error. Check your keys');}
} else alert('Key Error. Check your keys');
  
    
}




function down_vote(current_blockchain, author, permlink, weight){
    
current_blockchain = current_blockchain.toLowerCase();
current_blockchain = current_blockchain + 'sig';

var wif = get_wif(current_blockchain);

if (wif.status  ==  'success'){
try{
    $('#icon_' + permlink).addClass('vote-process'); 
    pub_key = convert_to_pub_key_steem(wif.plaintext);

 check_pub_key_steem(pub_key, function steem_callback(err, result){ 
    if (!err){
        var voter = result[0][0];
        steem.broadcast.downvote(wif.plaintext, voter, author, permlink, weight, function(err, result) {
            if (err) {
                alert (err);
                $('#icon_' + permlink).removeClass('vote-process');    
     
            } else {
                 $('#icon_' + permlink).removeClass('vote-process');    
                 $("#" + permlink).css('z-index', -1);

            };
            
        console.log(err, result);
        });
         
        
        
    }
    else {alert(err);
        $('#icon_' + permlink).removeClass('vote-process');    

    }
  
   });
  
} catch(err){ alert('Key Error. Check your keys');}
} else alert('Key Error. Check your keys');
  
}




function comment (data, callback){
    var trx = new Array();
    data = JSON.parse(data);
    var blockchain = data.blockchain.toLowerCase() + 'sig';
    
    var wif = get_wif(blockchain);
    
    if (wif.status  ==  'success')
    try{
        pub_key = convert_to_pub_key_steem(wif.plaintext);
        
        check_pub_key_steem(pub_key, function steem_callback(err, result){ 
        
        if (!err){
            trx['parentAuthor'] = data.parentAuthor;
            trx['parentPermlink'] = data.parentPermlink;
            trx['author'] = result[0][0];
            trx['permlink'] = data.permlink;
            trx['title'] = data.title;
            trx['body'] = data.body;
            trx['metadata'] = data.metadata;
            
            //jsonMetadata = JSON.parse(trx['metadata']);
                
            console.log(trx);
            
                
            $.get( "/api/v1/site/get_time", {} )
             .done(function( data ) {
               alert( "Data Loaded: " + data );
               t=data;
            });
                    TimeShift.setTimezoneOffset(0);

            console.log('t is ok', t);
            if (Date) {
                try {
                    Date = null;
                    Date = TimeShift.Date;                      // Overwrite Date object
                    //new Date().toString();
                    // console.log('>>>',window.servertimestamp)
                    TimeShift.setTime(t);           // Set the time to 2012-02-03
                    console.log('Date Chanded toss', new Date().toString())

                    //$.get( "http://144.217.94.119:8090", {"jsonrpc":"2.0","id":"25","method":"get_dynamic_global_properties","params": [""]} )
                    //  .done(function( data ) {
                    //    alert( "Data Loaded: " + data );
                    // });
                    //Сходим за нормальным временем
                } catch (exeption) {
                    console.log("Couldn't override Date object.");
                }
            }
            
            
            doit = function(){
                steem.broadcast.comment(wif.plaintext, 
                trx['parentAuthor'], 
                trx['parentPermlink'], 
                trx['author'], 
                trx['permlink'], 
                trx['title'], 
                trx['body'], 
                trx['metadata'], 
                function(err, result) {
                    console.log(err, result);

                    if (err == null){
                        setTimeout(redirect, 6000);
                        return err
                    } 
                    else alert(err);
                });
            }
            function sleep(microseconds) {
                var request = new XMLHttpRequest();
                request.open("GET", "sleep.php?time=" + microseconds, false);
                request.send();
            }
            for (i=0 ;i< 1000;i++){
                   d=doit();
                if (d == null){
                    break
                }
                else {
                    sleep(2000)
                    console.log('try',i,d);
                }
            } 
                 
           
        
        } else alert(err);
  
        });
  
    } catch(err){ alert('Key Error. Check your keys');}
    
  
    
}
    
function redirect(){
    document.location.href = '/site/show_single_blog';
}
    
    


function reply (data, callback){
    
    var trx = new Array();
    data = JSON.parse(data);
    var blockchain = data.blockchain.toLowerCase() + 'sig';
    
    var wif = get_wif(blockchain);
    
    if (wif.status  ==  'success')
    try{
        pub_key = convert_to_pub_key_steem(wif.plaintext);
        
        check_pub_key_steem(pub_key, function steem_callback(err, result){ 
        
        if (!err){
            
            trx['parentAuthor'] = data.parentAuthor;
            trx['parentPermlink'] = data.parentPermlink;
            trx['author'] = result[0][0];
            trx['permlink'] = 're-' + trx['author'] + '-' + data.permlink;
            trx['permlink'] = trx['permlink'].replace(".","");
            trx['title'] = data.title;
            trx['body'] = data.body;
            trx['metadata'] = data.metadata;
            
            //jsonMetadata = JSON.parse(trx['metadata']);
            console.log(trx);    
                
              steem.broadcast.comment(wif.plaintext, 
                trx['parentAuthor'], 
                trx['parentPermlink'], 
                trx['author'], 
                trx['permlink'], 
                trx['title'], 
                trx['body'], 
                trx['metadata'], 
                function(err, result) {
                    callback(result);
                    console.log(err, result);
            });
        
        } else alert(err);
  
        });
  
    } catch(err){ alert('Key Error. Check your keys');}
    
  
    
}
    