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

$parser = new IMPORT_KEYS();

    $parser->init();

    
    
class IMPORT_KEYS{
    
public function init(){
    global $config;
    global $db;   
    
    $node = 'wss://this.piston.rocks';
        
    
    $this->set_node($node);
    
    $db = new SafeMysql(array('user' => $config['dbuser'], 'pass' => $config['dbpassword'],'db' => $config['dbname'],'host' => $config['dbhost'], 'charset' => 'utf8mb4'));

    $keys = $db->getAll('SELECT * FROM trail WHERE imported = 0 AND blockchain=?s', $config['blockchain']['name']);
   
    foreach ($keys as $key){
        $this->addkey($key['key']);
        $db->query('UPDATE trail SET imported = 1 WHERE user=?s AND blockchain=?s', $key['user'], $config['blockchain']['name']);
        echo $key['user'] . ' \n';
    }
    
}     
 



    private function addkey($key){
    
        $cmd = "UNLOCK='Termit_210' piston addkey --unsafe-import-key " . $key;
        exec ($cmd);
        
    }
    
     private function set_node($node){
        $cmd = 'piston set node ' . $node;
        exec($cmd);
        sleep(3);
    }
}
