<?php
  $variables = [
      'db_username' => 'alireza',
      'db_password' => '123456',
      'db_server'=>'localhost:3306'
  ];

  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
?>