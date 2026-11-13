<?php

$host   = 'localhost';
$dbname = 'biblioteca';
$user   = 'root';
$pass   = '';

$con = mysqli_connect($host, $user, $pass, $dbname);

if (!$con)
{
    die('Erro ao conectar com o banco de dados (╥﹏╥)');
}

mysqli_set_charset($con, 'utf8mb4');
