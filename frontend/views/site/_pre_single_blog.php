<?php
use common\models\BlockChain;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script>
var blockchain = '<?php echo BlockChain::get_blockchain_from_locale() ?>';
var account = blockchain.toLowerCase() + 'ac';
    account = getCookie(account);
    document.location.href='index/' + account;
    


</script>