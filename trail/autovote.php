<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

date_default_timezone_set ("UTC");
define ("MAIN_DIR", dirname(__FILE__));
include ( MAIN_DIR . '/mysql.php');
include (MAIN_DIR . "/config.php");

$parser = new AUTOVOTE();

    $parser->init();

    
    
class AUTOVOTE{
    
    
    
public function init(){
    global $config;
    global $db;    
    
    if ($config['blockchain']['name'] == 'steem'){
        $node = 'wss://this.piston.rocks';
        
    } elseif ($config['blockchain']['name'] == 'golos') {
        $node = 'wss://ws.mapala.net';
    }
    
    $this->set_node($node);
    
    
    $db = new SafeMysql(array('user' => $config['dbuser'], 'pass' => $config['dbpassword'],'db' => $config['dbname'],'host' => $config['dbhost'], 'charset' => 'utf8mb4'));

    $keys = $db->getAll('SELECT * FROM trail WHERE imported = 1 AND active=1 AND blockchain=?s', $config['blockchain']['name']); 
    
    $arts = $db->getAll('SELECT * FROM need_vote WHERE blockchain =?s AND voted=0', $config['blockchain']['name']);  
    
    foreach ($arts as $art){
        $author = '@' . $art['author'];
        $permlink = $art['permlink'];
        
        foreach ($keys as $key){
            $weight = $key['weight'];
            $voter = $key['user'];
            echo $voter . " \n ";
            
            try{
                $this->vote($author,$permlink, $voter, $weight);
                $db->query("UPDATE need_vote SET voted=1 WHERE author=?s AND permlink=?s", $art['author'], $art['permlink']);
                echo 'success vote for voter =' . $voter . 'art=' . $permlink;
            } catch (Exception $e){

            }

        }
        
        
        
    }
    
    
  
    
    
}     
 

    private function set_node($node){
        $cmd = 'piston set node ' . $node;
        exec($cmd);
        sleep(3);
    }

    private function vote($author, $permlink, $voter, $weight){
        
        
        $cmd = "UNLOCK='Termit_210' piston upvote " . $author . '/' . $permlink . ' --voter ' . $voter . ' --weight ' . $weight;
    
        exec ($cmd);
    }
    
    
}
