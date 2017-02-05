/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    //SET LOCAL USER BROWSER DATE TO Date, came from our server
  
       window.override_local_time=function(){
                 $.get( "/api/v1/site/get_time", {} )
             .done(function( data ) {
               //alert( "Data Loaded: " + data );
               t=parseInt(data);
                console.log('t is ok', t);
                if (Date) {
                    try {
                        Date = null;
                        Date = TimeShift.Date;                      // Overwrite Date object
                        TimeShift.setTime(t);           // Set the time to 2012-02-03
                        console.log('Date Chanded toss', new Date().toString())
                    } catch (exeption) {
                        console.log("Couldn't override Date object.");
                    }
                }
            });
            TimeShift.setTimezoneOffset(0);
            };
  



function vote(current_blockchain, author, permlink, weight){
    window.override_local_time();

current_blockchain = current_blockchain.toLowerCase();
var voter = current_blockchain + 'ac';
    voter = getCookie(voter);
    
current_blockchain = current_blockchain + 'sig';



var wif = get_wif(current_blockchain);

if (wif.status  ==  'success'){
try{
    $('#icon_' + permlink).addClass('vote-process'); 
    pub_key = convert_to_pub_key_steem(wif.plaintext);
      
    check_pub_key_steem(pub_key, function steem_callback(err, result){ 
    if (!err){
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
           if (err['message'] != 'The WS connection was closed before this operation was made') {  
                   alert(err);
          }  
           console.log(err['message']);
           $('#icon_' + permlink).removeClass('vote-process'); 

    }
  
   });
} catch(err){ alert('Key Error. Check your keys');}
} else alert('Key Error. Check your keys');
  
    
}




function down_vote(current_blockchain, author, permlink, weight){
          window.override_local_time();

current_blockchain = current_blockchain.toLowerCase();
var author = current_blockchain + 'ac';
    author = getCookie(author);

current_blockchain = current_blockchain + 'sig';
    
var wif = get_wif(current_blockchain);

if (wif.status  ==  'success'){
try{
    $('#icon_' + permlink).addClass('vote-process'); 
    pub_key = convert_to_pub_key_steem(wif.plaintext);
    
          
    check_pub_key_steem(pub_key, function steem_callback(err, result){ 
    if (!err){
        var voter = author;
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
    else {
        {
           if (err['message'] != 'The WS connection was closed before this operation was made') {  
                   alert(err);
          }  
           console.log(err['message']);
        $('#icon_' + permlink).removeClass('vote-process'); 

    }
    }
  
   });
  
} catch(err){ alert('Key Error. Check your keys');}
} else alert('Key Error. Check your keys');
  
}




function comment (data, callback){
    window.override_local_time();

    var trx = new Array();
    data = JSON.parse(data);
    var blockchain = data.blockchain.toLowerCase() + 'sig';
    var author = data.blockchain.toLowerCase() + 'ac';
    author = getCookie(author);
    var wif = get_wif(blockchain);
    
    if (wif.status  ==  'success')
    try{
        pub_key = convert_to_pub_key_steem(wif.plaintext);
        
        
        check_pub_key_steem(pub_key, function steem_callback(err, result){ 
        
        if (!err){
            trx['parentAuthor'] = data.parentAuthor;
            trx['parentPermlink'] = data.parentPermlink;
            trx['author'] = author;
            trx['permlink'] = data.permlink;
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
                    console.log(err, result);

                    if (err == null){
                        setTimeout(redirect, 6000);
                    } 
                     else alert(err);
                });
            
        } else {
            {
            if (err['message'] != 'The WS connection was closed before this operation was made') {  
                   alert(err);
            }  
            console.log(err['message']);
            $('#icon_' + permlink).removeClass('vote-process'); 

            }
            
        }
  
    });
        
  
    } catch(err){ alert('Key Error. Check your keys');}
    
  
    
}
    
function redirect(){
    document.location.href = '/site/show_single_blog';
}
    
    function sleep(microseconds) {
                var request = new XMLHttpRequest();
                request.open("GET", "sleep.php?time=" + microseconds, false);
                request.send();
            };
            
function ReloadScripts(work_continue) {

    var scriptTag = document.getElementsByTagName('script');
    var src;

    for (var i = 0; i < scriptTag.length; i++) {
        src = scriptTag[i].src;
        scriptTag[i].parentNode.removeChild(scriptTag[i]);

        try {
            var x = document.createElement('script');
            x.type = 'text/javascript';
            x.src = src;
            //console.log(x)
            document.getElementsByTagName('head')[0].appendChild(x);
        }
        catch (e) {console.log(e)}
    }
work_continue();
};

function reply (data, callback){
          window.override_local_time();

    var trx = new Array();
    data = JSON.parse(data);
    var blockchain = data.blockchain.toLowerCase() + 'sig';
    var author = data.blockchain.toLoweCase() + 'ac';
    author = getCookie(author);
    
    var wif = get_wif(blockchain);
    
    if (wif.status  ==  'success')
    try{
        pub_key = convert_to_pub_key_steem(wif.plaintext);
           
        check_pub_key_steem(pub_key, function steem_callback(err, result){ 
        
        if (!err){
            
            trx['parentAuthor'] = data.parentAuthor;
            trx['parentPermlink'] = data.parentPermlink;
            trx['author'] = author;
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
        
        } else {
            {
                if (err['message'] != 'The WS connection was closed before this operation was made') {  
                   alert(err);
                }  
                console.log(err['message']);
  
            }
        }
    });
   
    } catch(err){ alert('Key Error. Check your keys');}
    
  
    
}
    