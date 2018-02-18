<?php
//Change host name, database type, database, username, password appropriately in the configs file

$configs = parse_ini_file(WPATH . "core/configs.ini");
require "Database.php";
Database::setUp(array(
    'dsn' => 'mysql:host=' . $configs["host_name"] . ';dbname=' . $configs["db_name"] . ';',
    'username' => $configs["db_user"],
    'password' => $configs["db_password"]
));
