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

$parser = new SBD();

    $parser->init();

    
    
class SBD{
    
public function init(){
    global $config;
    global $db;    

           
$xao_rate = $this->get_xao_rate();

    
    
    $db = new SafeMysql(array('user' => $config['dbuser'], 'pass' => $config['dbpassword'],'db' => $config['dbname'],'host' => $config['dbhost'], 'charset' => 'utf8mb4'));



                    $transactions = $this->get_account_history();
                   
              foreach ($transactions as $action_full){
                  $action = $action_full[1];
                  
                    if ($action['op'][0] == "transfer") {
                        $action = $action['op'];
                        $from = $action[1]['from'];
                        $to = $action[1]['to'];
                        $amount = $action[1]['amount'];
                        $memo = $action[1]['memo'];
                        
                        if ($from == 'mention.bot'){
                            continue;
                        }
                        
                        $memo = str_replace('@', '', $memo);
                        
                        $user_exist = $db->getRow('SELECT * FROM user WHERE username=?s', $memo);
                        
                        if ($user_exist){
                            $trx_exist = $db->getRow('SELECT * FROM sbd WHERE hash=?s', $action_full[1]['trx_id']);
                            if (!$trx_exist){
                                $data['created_at'] = str_replace('T', ' ', $action_full[1]['timestamp']);
                                $data['updated_at'] = str_replace('T', ' ', $action_full[1]['timestamp']);
                                $data['block'] = $action_full[1]['block'];
                                $data['hash'] = $action_full[1]['trx_id'];
                                $data['currency'] = 'SBD';
                                $data['name'] = $memo;
                                
                                $data['amount'] = str_replace(' SBD', '', $amount);
                                $data['status'] = 'completed';

                                   $day = date('l',  strtotime($data['created_at']));
                                
                                if ($day == 'Monday'){
                                    $data['bonuse'] = 4;
                                };
                                if ($day == 'Tuesday'){
                                    $data['bonuse'] = 3;
                                };
                                if ($day == 'Wednesday'){
                                    $data['bonuse'] = 2;
                                };
                                if ($day == 'Thursday'){
                                    $data['bonuse'] = 1;
                                };
                                if ($day == 'Friday'){
                                    $data['bonuse'] = 0;
                                };
                                if ($day == 'Saturday'){
                                    $data['bonuse'] = 6;
                                };
                                if ($day == 'Sunday'){
                                    $data['bonuse'] = 5;
                                };
                                
                                
                                
                                $db->query("INSERT INTO sbd SET ?u", $data);
                                unset ($data['block']);
                                
                                
                                $data['symbol'] = 'SBD';
                                $data['currency'] = 'BTC';
                                $btc_usd_rate = $this->get_btc_rate();
                                echo $btc_usd_rate;
                                echo $amount;
                                
                                $data['amount'] = $amount / $btc_usd_rate;
                                $db->query("INSERT INTO ico SET ?u", $data);
                                echo $data['created_at'] . ' ' . $data['name'] . ' ' . $data['amount'] . $data['currency'] . " \n";
                               
                            }
                        }
                        
                        
                        
                    }




              }
       

}     
 



    private function get_account_history(){
        global $config;
        
        $param = '{"jsonrpc": "2.0", "method": "call", "params": [0,"get_account_history",["mapala.ico", "-1", "2000"]], "id": 20}';
        $cmd = "curl -s --data" . " " . "'" . $param . "'" . " " . $config['blockchain']['node'];

        $out = shell_exec($cmd);  
        
        $out = json_decode($out, true);
        $result = $out['result']; //Отливливать ошибки здесь
        
        return $result;
        
        
    }
    
    
    private function get_xao_rate(){
        
        $cmd = "curl -s 'http://data-asg.goldprice.org/GetData/USD-XAU/1'";
        $out = shell_exec($cmd);  
        $out = json_decode($out, true);
        
        $result = $out[0]; 
        $result = substr($result, 8);
        $XAUOZ = floatval($result);
        $GRAMM_IN_OZ=31.1034768;
        $XAUMG = $XAUOZ / $GRAMM_IN_OZ / 1000;
        
        
        
        return $XAUMG;
        
        
    }
    
    
    private function get_btc_rate(){
        
        $jsnsrc = "https://blockchain.info/ticker";
        $json = file_get_contents($jsnsrc);
        $json = json_decode($json);
        $btc_rate = $json->USD->last;
        
        return $btc_rate;

    }
    
    

}
