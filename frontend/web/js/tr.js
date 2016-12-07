/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function vote(current_blockchain, author, permlink, weight){
    
current_blockchain = current_blockchain.toLowerCase();
current_blockchain = current_blockchain + 'sig';

var wif = get_wif(current_blockchain);

if (wif.status  ==  'success')
try{
    pub_key = convert_to_pub_key_steem(wif.plaintext);

 check_pub_key_steem(pub_key, function steem_callback(err, result){ 
    if (!err){
        var voter = result[0][0];
        steem.broadcast.vote(wif.plaintext, voter, author, permlink, weight, function(err, result) {
            if (err) alert (err);
            
        console.log(err, result);
        });
         
        
        
    }
    else alert(err);
  
   });
  
} catch(err){ alert('Key Error. Check your keys');}
    
  
    
}




function comment (current_blockchain, data){
    
    trx = JSON.parse(data);
    console.log(trx);
    
    current_blockchain = current_blockchain.toLowerCase();
    current_blockchain = current_blockchain + 'sig';

    var wif = get_wif(current_blockchain);

    if (wif.status  ==  'success')
    try{
        pub_key = convert_to_pub_key_steem(wif.plaintext);
        
        check_pub_key_steem(pub_key, function steem_callback(err, result){ 
        
        if (!err){
            parentAuthor = '';
            author = result[0][0];
            permlink = trx['permlink'];
            parentPermlink = trx['parentPermlink'];
            title = trx['title'];
            body = trx['body'];
            jsonMetadata = JSON.parse(trx['metadata']);
                
                console.log(trx);
                console.log(wif);
                
                
                
                steem.broadcast.comment(wif.plaintext, parentAuthor, parentPermlink, author, permlink, title, body, jsonMetadata, function(err, result) {
    console.log(err, result);
            
                console.log(err, result);
            });
         
        } else alert(err);
  
        });
  
    } catch(err){ alert('Key Error. Check your keys');}
    
  
    
}
    