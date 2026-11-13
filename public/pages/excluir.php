<?php

require __DIR__ . '/../../api/middleware/verificador.php';
VerificarLogin();

require_once __DIR__ . '/../../api/models/LivroORM.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0)
{
    header('Location: listar.php?erro=ID inválido!');
    exit;
}

$orm = new LivroORM();
$livro = $orm->buscarPorId($id);

if (!$livro)
{
    header('Location: listar.php?erro=Livro não encontrado!');
    exit;
}

$orm->excluir($id);

header('Location: listar.php?status=deletado');
exit;
