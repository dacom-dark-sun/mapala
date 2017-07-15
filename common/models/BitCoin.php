<?php
namespace common\models;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Configuration;
use yii\base\Model;
use Yii;
use yii\data\ArrayDataProvider;
use common\models\User;
use common\models\Gbg;
use common\models\Ico;
use common\models\Team;
use common\models\Lots;
use common\models\Withdraw;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BitCoin extends Model
{
    static function add_refferal($r){

            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'ref',
                'value' => $r
            ]));
          
    }
    
    static function add_ref_to_database($user){
       $ref = Yii::$app->request->cookies['ref'];
        Yii::$app->db->createCommand()
             ->update('user', [
                 'ref' => $ref, 
                ],['username' => $user])
             ->execute();
        
    }
    
     static function create_direct_address($user){
        $apiKey = env('APIKEY');
        $apiSecret = env('APISECRET');
        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);
        $account = $client->getAccount(env('BTC_ACCOUNT_DIRECT'));
       
        $address = new Address([
            'name' => $user,
        ]);
        $client->createAccountAddress($account, $address);
        $address = $client->decodeLastResponse();
        
        
        Yii::$app->db->createCommand()
             ->update('user', [
                 'btc_wallet_direct' => $address['data']['address'], 
                ],['username' => $user])
             ->execute();
        
        return true;
        
        
    }
    
    
    
    static function create_address($user){
        $apiKey = env('APIKEY');
        $apiSecret = env('APISECRET');
        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);
        $account = $client->getAccount(env('BTC_ACCOUNT'));
       
        $address = new Address([
            'name' => $user,
        ]);
        $client->createAccountAddress($account, $address);
        $address = $client->decodeLastResponse();
        
        
        Yii::$app->db->createCommand()
             ->update('user', [
                 'btc_wallet' => $address['data']['address'], 
                ],['username' => $user])
             ->execute();
        
        return true;
        
        
    }
    
   
    
    static function get_data($interval){
       
   
    $players = ICO::find()->where('created_at >=' . "'" .   $interval['date_start'] . "'")->andwhere('created_at <=' . "'" .   $interval['date_end'] . "'")->andWhere(['direct'=>0])->asArray()->all();
    $total_amount = 0;
        
    foreach ($players as $player){
        if ($player['bonuse'] != 0){
            $total_amount = $total_amount + $player['amount']*($player['bonuse']/100 + 1);
        } else {
            $total_amount = $total_amount + $player['amount'];
            }
     }
    
    foreach ($players as &$player){
        if ($player['bonuse'] != 0){
            $player['tokens'] = round(810000 / $total_amount * $player['amount'] * ($player['bonuse']/100 +1), 4);
            
        } else {
            $player['tokens'] = round(810000 / $total_amount * $player['amount'], 4);
    
        }
        $player['stake'] = round($player['tokens']/810000 * 100,4);
        $player['forecast'] = 2.98 * $player['tokens'];
        
    }
    unset($player);
   
    
    return $players;
        
        
    }
    
    static function get_rate(){
        $interval = Bitcoin::get_interval(); 
        $prev_id = $interval['id'] - 1;
        
        $prev_interval = Calendar::find()->where('id=' . $prev_id)->asArray()->one();
        return $prev_interval['rate'];
    }
    
    static function get_prev_interval(){
        $interval = Bitcoin::get_interval(); 
        $prev_id = $interval['id'] - 1;
        
        $prev_interval = Calendar::find()->where('id=' . $prev_id)->asArray()->one();
        return $prev_interval;
        
    }
    
    
    
    
    static function check_distribution(){
        $interval = Bitcoin::get_interval(); 
        $prev_id = $interval['id'] - 1;
        
        $prev_interval = Calendar::find()->where('id=' . $prev_id)->asArray()->one();
       
        if ($prev_interval['finished'] == 0){
             $players = BitCoin::get_data($prev_interval);
             $total_investments = 0;
            foreach ($players as $player){
                $total_investments = $total_investments + $player['amount'];
                Yii::$app->db->createCommand("UPDATE user SET tokens = tokens + " . $player['tokens'] . " WHERE username =" . "'". $player['name'] . "'")->execute(); 
                
                Yii::$app->db->createCommand("UPDATE ico SET tokens=" . $player['tokens'] . " WHERE hash=" . "'" . $player['hash'] . "'")->execute(); 
                
                
            }
                
                $total_btc_per_week = BitCoin::get_weekly_btc($players);
                $total_gbg_per_week = Bitcoin::get_weekly_gbg($players);
                
                $total_invest_by_user = BitCoin::get_all_investors();
                $total_amount_btc = BitCoin::get_total_amount($total_invest_by_user);

                $total_tokens = Bitcoin::get_all_tokens();
                $rate = $total_amount_btc / $total_tokens;
                $weekly_rate = Bitcoin::get_weekly_rate($total_investments);
                
                Yii::$app->db->createCommand()
                 ->update('calendar', [
                 'finished' => 1, 
                 'rate' => $rate,
                 'weekly_rate' => $weekly_rate,
                 'week_investments' => $total_investments,
                 'btc_per_week' => $total_btc_per_week,
                 'gbg_per_week' => $total_gbg_per_week, 
                ],['id' => $interval['id'] - 1 
                ]) ->execute();
          
             $weekly_rate = Bitcoin::create_weekly_rate();   
             $max_rate = Bitcoin::get_max_rate();
             
                   
            echo $prev_interval['date_start'] . '-' . $prev_interval['date_end'] . '  SUCCESS DISTRIBUTED' . 'WEEKLY_RATE: ' . $weekly_rate . ' MAX_RATE: ' . $max_rate . " \n";
            
        }
        
    }
    
    static function get_weekly_rate($total_investments){
       
       $rate = $total_investments/810000;
       $rate = number_format($rate, 10);
      return $rate;  
    }
    
    
    static function create_weekly_rate(){
        $calendar = Bitcoin::get_calendar();
       foreach ($calendar as $row){
          $weekly_rate = BitCoin::get_weekly_rate($row['week_investments']);
          
            Yii::$app->db->createCommand()
                 ->update('calendar', [
                 'weekly_rate' => $weekly_rate, 
                ],['id' => $row['id'], 
                ]) ->execute();
           
           
       }
       
        
    }
    
    static function get_max_rate(){
        $max = Calendar::find()->max('weekly_rate');
    //    var_dump($max);
        return $max;
        
    }
    
    static function get_interval(){
       
         $interval = Calendar::find()->where('date_start <= CURDATE()')->andWhere('date_end >= CURDATE()')->asArray()->one(); 
         
         return $interval;
    }
    
    
    
    /*static function get_tokens($user = null){
        if ($user == null)
           $user = Yii::$app->user->identity->username;
      
         $tokens =  User::find()->where(['username' => $user])->asArray()->one();
    
         return $tokens['tokens'];
    }*/
    
    static function get_personal_tokens ($user = null){
        if ($user == null)
             $user = Yii::$app->user->identity->username;
        $tokens = Ico::find()->where(['name' => $user])->asArray()->all();
        $personal_tokens = 0;
        foreach ($tokens as $t){
            $personal_tokens = $personal_tokens + $t['tokens'];
        }
        return $personal_tokens;
    }
    
   
    static function get_personal_gbg($user = null){
        if ($user == null)
        $user = Yii::$app->user->identity->username;
        $gbg = Ico::find()->where(['name' => $user])->andwhere(['symbol' => 'GBG'])->asArray()->all();
        $total_gbg = 0;
        foreach ($gbg as $g){
            $total_gbg = $total_gbg + $g['amount'];
        }
        return $total_gbg;
    }
    
    static function get_personal_btc($user = null){
        if ($user == null)
        $user = Yii::$app->user->identity->username;
        $btc = Ico::find()->where(['name' => $user])->andwhere(['symbol' => 'BTC'])->asArray()->all();
        $total_btc = 0;
        foreach ($btc as $b){
            $total_btc = $total_btc + $b['amount'];
        }
        return $total_btc;
        
        
    }
    
    static function get_weekly_btc($data){
        $total_weekly_btc = 0;
        foreach ($data as $d){
            if ($d['symbol'] == 'BTC')
                $total_weekly_btc = $total_weekly_btc + $d['amount'];
        }
            return $total_weekly_btc;
        
    }
    
    
    static function get_weekly_gbg($data){
        $total_weekly_gbg = 0;
        foreach ($data as $d){
            if ($d['symbol'] == 'GBG'){
                $gbg = Gbg::find ()->where(['hash' => $d['hash']])->asArray()->one();
                if ($gbg){
                $total_weekly_gbg = $total_weekly_gbg + $gbg['amount'];
                };
            }
        }
                return $total_weekly_gbg;
        
    }
    
     static function get_weekly_btc_gbg($data){
        $total_weekly_gbg = 0;
        foreach ($data as $d){
            if ($d['symbol'] == 'GBG'){
                $gbg = Gbg::find ()->where(['hash' => $d['hash']])->asArray()->one();
                if ($gbg){
                $total_weekly_gbg = $total_weekly_gbg + $gbg['amount'];
                };
            }
        }
        
                return $total_weekly_gbg;
        
    }
    
    
    static function get_bonuse_today(){
    
        $day = date('l',  time());
                                
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
                                
    return $data['bonuse'];
    }
    
    
     static function get_all_btc(){
    $btc =  ICO::find()->asArray()->all();
    $total = 0;
    foreach ($btc as $b){
            $total = $total + $b['amount'];
        };
    
    return $total;
        
        
    }
    
    static function get_all_tokens(){
    $btc =  ICO::find()->asArray()->all();
    $total = 0;
    foreach ($btc as $b){
            $total = $total + $b['tokens'];
        };
    
    return $total;
        
         
        
    }
    
    
    static function get_all_investors(){
    $investors =  ICO::find()->asArray()->all();
        return $investors;
        
    }
    
    
    
    static function get_block_from_gbg_table($hash){
       $block = Gbg::find()->where(['hash' => $hash])->asArray()->one();
        return $block['block'];
        
    }
    
    
    static function get_all_team_tokens(){
    
       $team = Team::find()->where(['zeroteam' => 0])->asArray()->all();
       
       return $team;
        
    }
    
    

    static function get_all_wd(){
      $wd =  Withdraw::find()->asArray()->all();
        return $wd;
    }

    static function add_wd($model){
        $user = User::find()->where(['username' => Yii::$app->user->identity->username])->one();
        $model->name = $user->username;
       
        $model->status = 'pending';
        $model->created_at = date("Y-m-d H:i:s");
        $model->rate = BitCoin::get_rate();
        $model->tokens = $model->btc / $model->rate;
         
       // if ($model->tokens <= $user->team_tokens) { --munus
            Yii::$app->db->createCommand()
             ->update('user', [
                 'team_tokens' => $user->team_tokens - $model->tokens, 
                ],['username' => Yii::$app->user->identity->username])
             ->execute();
            
           $model->save();
  
       // }
    }
       
    static function get_personal_team_tokens(){
         $user = User::find()->where(['username' => Yii::$app->user->identity->username])->one();
       return $user->team_tokens;
    }
    
    
    static function calculate_personal_team_tokens(){
        $user = User::find()->where(['username' => Yii::$app->user->identity->username])->one();
       
        $team_tokens = Team::find()->where(['name' => $user])->asArray()->all();
        $personal_team_tokens = 0;
        $interval = Bitcoin::get_interval(); 
         
        
        $prev_id = $interval['id'] - 1;
        $prev_interval = Calendar::find()->where('id=' . $prev_id)->asArray()->one();
        if ($prev_interval['destributed'] == 0){
             $players = BitCoin::get_data($prev_interval);
            foreach ($players as $player){
                Yii::$app->db->createCommand("UPDATE user SET tokens = tokens + " . $player['tokens'] . " WHERE username =" . "'". $player['name'] . "'")->execute(); 
                
                Yii::$app->db->createCommand("UPDATE ico SET tokens=" . $player['tokens'] . " WHERE hash=" . "'" . $player['hash'] . "'")->execute(); 
                
                
                Yii::$app->db->createCommand()
                 ->update('calendar', [
                 'finished' => 1, 
                ],['id' => $interval['id'] - 1 
                ]) ->execute();
          
                }
            echo $prev_interval['date_start'] . '-' . $prev_interval['date_end'] . '  SUCCESS DISTRIBUTED' . " \n";
            
         
        foreach ($team_tokens as $tt){
            $personal_team_tokens = $personal_team_tokens + $tt['tokens']; 
            
        }
        return $personal_team_tokens;
    }
    
        }
    
    static function get_total_amount($btc){
 
        $amount = 0;
        foreach ($btc as $b){
            $amount = $amount + $b['amount'];
        }
        return $amount;
    }
    
    static function get_user_btc_investments($user = null){
        if (!$user) $user = Yii::$app->user->identity->username;
        $btc = ICO::find()->where(['name' => $user])->asArray()->all();
        return $btc;
    }
    
   
    
    
    static function get_user_wallet($user = null){
       if (!$user) $user = Yii::$app->user->identity->username;
       return User::find()->where(['username' => $user])->asArray()->one();
    }
    
    static function get_calendar(){
      $calendar =  Calendar::find()->where(['not', ['rate' => null]])->asArray()->all();
        return $calendar;
    }
    
    
    static function get_xaxis(){
     $calendar =  Calendar::find()->asArray()->all();
     foreach ($calendar as $c){
         $xaxis[] = $c['date_end'];
     }
        return $xaxis;
    }
    
    
    static function get_yaxis(){
     $calendar =  Calendar::find()->asArray()->all();
     foreach ($calendar as $c){
         if ($c['rate'] == null) break;
         $yaxis[] = $c['rate'] * 1000000;
     }
        return $yaxis;
    }
    
    
     static function get_fast_yaxis(){
     $calendar =  Calendar::find()->asArray()->all();
     foreach ($calendar as $c){
         if ($c['week_investments'] == null) break;
         $yaxis[] = $c['weekly_rate'] * 1000000;
     }
        return $yaxis;
    }
    
    
    
    static function get_bounty($user = null){
        if (!$user) $user = Yii::$app->user->identity->username;
        $bounty = Bounty::find()->where(['name' => $user])->asArray()->all();
        $money =0;
        foreach ($bounty as $b){
            $money +=$b['tokens'];
        }
        return $money;
    }
    
    
    
    
    
    
    
    //ARRAY DATA PROVIDER FOR DISPLAY LOTS
    static function get_lots(){
       $lots = Lots::find()->asArray()->all();
       
       foreach ($lots as &$l){
            $l['total_amount_in_usd'] = Bitcoin::btc_to_usd($l['total_amount']);
            $l['discount'] = round ($l['discount'], 1);
            $direct_sales = ICO::find()->where(['direct' => 1])->andWhere(['lot' => $l['id']])->asArray()->all();
            $l['solded'] = 0;
            foreach ($direct_sales as $ds){
                if ($l['id'] == $ds['lot']){
                  $l['solded'] += $ds['amount'];
                }
            }
            $l['solded'] = round($l['solded'] / $l['total_amount'] * 100, 2);
       }

        $lots_array = new ArrayDataProvider([
                'allModels' => $lots,
                'sort' => [
                    'attributes' => ['id', 'total_amount', 'total_amount_in_usd', 'finished', 'discount', 'solded'],
                ],
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
        return $lots_array;
      
        
    }
        
    
    static function get_amount_access_refs($user = null){
       if (!$user) $user = Yii::$app->user->identity->username;
       
        $ref_money = Ref::find()->where(['referer' => $user])->asArray()->All();
        $r_money = 0;
        foreach ($ref_money as $rf){
            $r_money += $rf['amount_to_ref'];
        }
        return $r_money;
    }
    
    
    static function get_amount_wd_refs($user = null){
       if (!$user) $user = Yii::$app->user->identity->username;
        $ref_money = Withdraw_ref::find()->where(['username' => $user])->asArray()->All();
        $wd_ref_money = 0;
        foreach ($ref_money as $rf){
            $wd_ref_money += $rf['amount'];
        }
        return $wd_ref_money;
        
        
    }
    
     static function get_refs_provider(){
       $refs = Ref::find()->asArray()->all();
       
        $refs_array = new ArrayDataProvider([
                'allModels' => $refs,
                'sort' => [
                    'attributes' => ['referer', 'created_at', 'amount_to_ref'],
                ],
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
        return $refs_array;
      
        
    }
    
    static function get_refs_wd_provider(){
        $user = Yii::$app->user->identity->username;
       $refs = Withdraw_ref::find()->asArray()->where(['username' => $user])->all();
       
        $refs_array = new ArrayDataProvider([
                'allModels' => $refs,
                'sort' => [
                    'attributes' => ['amount', 'created_at', 'status'],
                ],
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
        return $refs_array;
      
        
    }
       
    
    static function get_all_direct_investors(){
       return ICO::find()->where(['direct' => 1])-> asArray()->all();
    }
    
    
    
    /*
     * CONVERTER GBG to BTC and USD
     */
    
    static function btc_to_usd($btc){
        $btc_usd_rate = Bitcoin::get_btc_rate();
        $usd = $btc * $btc_usd_rate;
        return $usd;
    }
    
    
    static function gbg_to_usd($gbg = 0){
        $gbg_usd_rate = Bitcoin::get_xao_rate();
        $btc_usd_rate = Bitcoin::get_btc_rate();
        $gbg_btc_rate = $gbg_usd_rate / $btc_usd_rate;
        $gbg_in_btc = $gbg_btc_rate * $gbg;
        $gbg_in_usd = Bitcoin::btc_to_usd($gbg_in_btc);
        return $gbg_in_usd;
    }
    
    
    static function get_xao_rate(){
        
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
    
    
    static function get_btc_rate(){
        
      //  $jsnsrc = "https://blockchain.info/ticker";
     //   $json = file_get_contents($jsnsrc);
     //   $json = json_decode($json);
     //   $btc_rate = $json->USD->last;
        $jsnsrc = "https://bittrex.com/api/v1.1/public/getmarketsummary?market=usdt-btc";
        $json = file_get_contents($jsnsrc);
        $json = json_decode($json, true);
       
        return $json['result'][0]['Last'];
        
       // return $btc_rate;

    }
    
    
    static function get_icosumm(){
        $invs = Ico::find()->asArray()->all();
        
        $inv_summ = Array();

        foreach ($invs as $inv){
            if (in_array($inv['name'], $inv_summ)){
                
            } else {
                $unique_investors[$inv['name']] = $inv['name'];
            }
        }
        $array = Array();
          
        foreach ($unique_investors as &$ui){
             $invs = Ico::find()->where(['name' => $ui]) -> asArray()->all();
             $tokens = 0;
             $amount = 0;
             foreach ($invs as $inv){
                 $tokens = $tokens + $inv['tokens'];
                 $amount = $amount + $inv['amount'];
             } 
             
            
             $array[] = ['name' => $ui, 'amount' => $amount,'tokens' => $tokens]; 
           
            }
          
        
        return $array;
    
    }
     static function get_team(){
        $invs = team::find()->asArray()->all();
        
        $inv_summ = Array();

        foreach ($invs as $inv){
            if (in_array($inv['name'], $inv_summ)){
                
            } else {
                $unique_investors[$inv['name']] = $inv['name'];
            }
        }
        $array = Array();
          
        foreach ($unique_investors as &$ui){
             $invs = Team::find()->where(['name' => $ui]) -> asArray()->all();
             $tokens = 0;
             $amount = 0;
             $description = '';
             foreach ($invs as $inv){
                 $tokens = $tokens + $inv['tokens'];
                 $description = ' ' . $description . $inv['description'] . ';';
             } 
             
            
             $array[] = ['name' => $ui, 'amount' => $amount,'tokens' => $tokens, 'description' => $description]; 
           
            }
          
        
        return $array;
    
    }
    /*
     * CONVERTER FINISHED
     */
    
    
    
    
    
}