<?php

// Database connection
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_people_one');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'peopleone');
define('DB_PASS', 'people@one');

// Domain Url and Path
define('BASE_URL', 'localhost');    //localhost - domain url
define('BASE_PATH', 'peopleone');   //localhost/peopleone - base path


// Create a Database connection
try {
    $connect = new PDO("mysql:host=".DB_HOST.";charset=".DB_CHARSET.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
catch (PDOException $e){
    die("Database connection failed: " . $e->getMessage());
}

?>