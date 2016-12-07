<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace common\models;
use Yii;
use common\models\CurrentBlock;
use common\models\ArtRaw;
use common\models\UsersRaw;
use common\models\VotesRaw;


class Parsing extends \yii\db\ActiveRecord
{
   
    static function get_num_current_block() {
        
        $param = '{"jsonrpc": "2.0", "method": "call", "params": [0,"get_state",[""]], "id": 2}';
        $node = 'http://node.steem.ws:80/rpc';
        $cmd = "curl --data" . " " . "'" . $param . "'" . " " . $node;
        $out = shell_exec($cmd);  
        $out = json_decode($out, true);
        $result= $out['result']['props']['head_block_number'];
        
        return $result;
        
    }
    
    
    
    static function get_num_current_block_from_sql(){
       
        $block_in_art = ArtRaw::find()->orderBy(['id' => SORT_DESC])->asArray()->one();
        $block_in_users = UsersRaw::find()->orderBy(['id' => SORT_DESC])->asArray()->one();
        $block_in_votes = VotesRaw::find()->orderBy(['id' => SORT_DESC])->asArray()->one();
        $block_in_art = $block_in_art['id'];
        $block_in_users = $block_in_users['id'];
        $block_in_votes = $block_in_votes['id'];
       
        return max([$block_in_art,$block_in_users,$block_in_votes]);
        
        }
    
    
    static function get_content_from_block($block = null){
        
        
        $param = '{"jsonrpc": "2.0", "method": "call", "params": [0,"get_block",[' . $block . ']], "id": 4}';
        $node = 'http://node.steem.ws:80/rpc';
        $cmd = "curl --data" . " " . "'" . $param . "'" . " " . $node;
        $out = shell_exec($cmd);  
        $out = json_decode($out, true);
        $result = $out['result']['transactions'];
        
        return $result;
        
    }
    
    
    
    
    static function process(){
    $num_in_sql = Parsing::get_num_current_block_from_sql();
    $num_in_blockchain = Parsing::get_num_current_block();
          for ($num_in_sql; $num_in_blockchain; $num_in_sql<$num_in_blockchain){
                $transactions = Parsing::get_content_from_block($num_in_sql);
                if (empty($transactions)){
                    $num_in_sql++;
                    echo $num_in_sql;
                    continue;
              }
          foreach ($transactions as $tr){
             foreach ($tr['operations'] as $action){
                if ($action[0] == "vote"){ 
                    $votes_sql->voter = $action[1]['voter'];
                    $votes_sql->author = $action[1]['author'];
                    $votes_sql->permlink = $action[1]['permlink'];
                    $votes_sql->save();
                    $shift = 0;
                 }
                 else if ($action[0]== "create_account"){
                    $users_sql->new_account_name = $action[1]['new_account_name'];
                    $users_sql->save();
                    $shift=0;
                 }
                 else if ($action[0]== "comment"){
                     //Include check for Mapala tag;
                    $comments_sql->$action[1]['parent_author'];
                    $comments_sql->$action[1]['parent_permlink'];
                    $comments_sql->$action[1]['author'];
                    $comments_sql->$action[1]['permlink'];
                    $comments_sql->$action[1]['title'];
                    $comments_sql->$action[1]['body'];
                    $comments_sql->$action[1]['json_metadata'];
                    $comments_sql->save();
                    $shift = 0;
                 }
                
             }
            
          }
        echo $num_in_sql;  
        }   
     return $num_in_sql;
          
          
    }
    
    
}
