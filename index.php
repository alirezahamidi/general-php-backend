<?php
    if(file_exists('./env.php')) {
        include './env.php';
    }
    
    include './app/resource/config.php';
    include './app/helpers/db/mysql/index.php';
    
    $module_address='./app/modules/'.$_POST["request"].'/index.php';
    // _d______o($_POST["request"]);
    include $module_address;
?>