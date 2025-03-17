<?php

$host = 'localhost';
$port = 3306;
$dbname = 'testing';
$username = 'root';
$password = '*';

try{
    $connection = new PDO("mysql:host={$host};dbname={$dbname}",$username,"password");

}