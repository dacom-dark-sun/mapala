<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set ("UTC");

include ('mysql.php');
include ("config.php");

$db = new SafeMysql(array('user' => $config['dbuser'], 'pass' => $config['dbpassword'],'db' => $config['dbname'], 'charset' => 'utf8mb4'));

  $cmd = "curl -s http://data-asg.goldprice.org/GetData/RUB-XAU/1";
  $out = shell_exec($cmd);  
  $price = explode(',', $out);
  preg_match_all('/([a-zA-Z-]+)/', $price[0], $currency);
  $price[1]=  floatval($price[1]);
  
  $db->query("UPDATE pricefeed SET currency=?s, price=?s WHERE blockchain=?s", $currency[0][0], $price[1], $config['blockchain']['name']);
               