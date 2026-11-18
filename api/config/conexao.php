<?php

$host   = 'localhost';
$dbname = 'biblioteca';
$user   = 'root';
$pass   = '';

try
{
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $user, $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

    $con = new mysqli($host, $user, $pass, $dbname);
    $con->set_charset('utf8mb4');

    if ($con->connect_errno)
    {
        throw new Exception('Erro ao conectar com mysqli: ' . $con->connect_error);
    }
}
catch (PDOException $e)
{
    die('Erro ao conectar com o banco de dados (PDO): ' . $e->getMessage());
}
catch (Exception $e)
{
    die('Erro ao conectar com o banco de dados (mysqli): ' . $e->getMessage());
}