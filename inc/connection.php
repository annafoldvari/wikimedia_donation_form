<?php

require_once DIRNAME(__FILE__) . '/../config.php';


try {
  global $config;
  $db = new PDO("mysql:host=".$config['server-name'].";dbname=".$config['dbname'], $config['user-name'], $config['password']);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Unable to connect to database.";
  echo $e->getMessage();
  exit;
}
