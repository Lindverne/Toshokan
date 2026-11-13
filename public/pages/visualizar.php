<?php

require __DIR__ . '/../../api/middleware/verificador.php';
VerificarLogin();

require __DIR__ . '/../components/header_usuario.php';
require_once __DIR__ . '/../../api/models/LivroORM.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0)
{
    header('Location: listar.php?erro=ID inválido!');
    exit;
}

$orm = new LivroORM();
$livro = $orm->buscarPorId($id);

if (!$livro || empty($livro->pdf))
{
    header('Location: listar.php?erro=Livro não possui PDF disponível!');
    exit;
}

$caminhoPdf = '../assets/pdf/livros/' . htmlspecialchars($livro->pdf);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../assets/img/favicon/favicon.ico">
    <title>Ler PDF - <?= htmlspecialchars($livro->titulo) ?> | Toshokan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/pages/listar.css">
</head>
<body>

<div class="container mt-4">

    <div class="hero-card p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark m-0">Ler Livro</h1>
            <p class="text-muted small m-0"><?= htmlspecialchars($livro->titulo) ?></p>
        </div>

        <?php include __DIR__ . '/../components/header_usuario.php'; ?>
    </div>

    <div class="mb-4">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="cadastrar.php">
                    <i class="fa-solid fa-circle-plus text-success me-2"></i>Cadastrar Livro
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="listar.php">
                    <i class="fa-solid fa-book me-2"></i>Lista de Livros
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="perfil.php">
                    <i class="fa-solid fa-user-gear me-2"></i>Meu Perfil
                </a>
            </li>
        </ul>
    </div>

    <div class="card form-card p-4 text-center">
        <embed src="<?= $caminhoPdf ?>" type="application/pdf" width="100%" height="80vh" alt="PDF do livro">
    </div>

    <div class="mt-4 text-center">
        <a href="listar.php" class="btn btn-voltar">
            <i class="fa-solid fa-arrow-left me-1"></i>Voltar
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/global.js"></script>

</body>
</html>
