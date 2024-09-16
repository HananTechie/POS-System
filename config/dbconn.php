<?php
    define("DB_SERVER","localhost");
    define("DB_USERNAME","root");
    define("DB_PASSWORD","");
    define("DB_DATABASE","pos_system");

    $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if(!$connect)
    {
        die("Connection Failed: ". mysqli_connect_error());
    }
?>