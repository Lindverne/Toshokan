<?php

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (!isset($_SESSION['login']))
{
    header('Location: ../../public/pages/login.php');
    exit;
}

require_once __DIR__ . '/../models/LivroORM.php';

$id = $_GET['id'] ?? null;

if (empty($id))
{
    header('Location: ../../public/pages/listar.php?erro=' . urlencode('Livro não informado! (>:-<)'));
    exit;
}

try
{
    $orm = new LivroORM();
    $orm->excluir((int) $id);
    header('Location: ../../public/pages/listar.php?status=deletado');
    exit;
}
catch (Throwable $e)
{
    header('Location: ../../public/pages/listar.php?erro=' . urlencode('Erro ao excluir livro: ' . htmlspecialchars($e->getMessage())));
    exit;
}
