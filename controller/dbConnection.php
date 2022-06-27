<?php

$server = 'remotemysql.com';
$user = 'n9xFi0NPG1';
$password = 'EXbz6YzPph';
$dbname = 'n9xFi0NPG1';

$dsn = 'mysql:host='.$server.';dbname='.$dbname;
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
if($pdo )
{
    echo 'connection success';
}
else
{
    echo 'conection failed';
}
