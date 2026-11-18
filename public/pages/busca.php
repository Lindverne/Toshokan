<?php

require_once __DIR__ . '/../../api/models/LivroORM.php';

$orm = new LivroORM();

$autor = $_GET['autor'] ?? '';
$livros = [];
$buscaRealizada = false;

if ($autor !== '')
{
    $buscaRealizada = true;
    $livros = $orm->buscarPorAutor($autor);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../assets/img/favicon/favicon.ico">
    <title>Buscar por Autor | Toshokan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/pages/listar.css">
</head>
<body>

<div class="container mt-4">

    <div class="hero-card p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark m-0">Buscar por Autor</h1>
            <p class="text-muted small m-0">Encontre livros de um autor específico</p>
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
                <a class="nav-link" href="listar.php">
                    <i class="fa-solid fa-book me-2"></i>Lista de Livros
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fa-solid fa-user-gear me-2"></i>Meu Perfil
                </a>
            </li>
        </ul>
    </div>

    <div class="card form-card p-4">
        <form method="GET" action="busca.php">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold mb-2" for="autor">Nome do Autor</label>
                    <input type="text" class="form-control" name="autor" id="autor"
                           placeholder="Ex: Machado de Assis"
                           value="<?= htmlspecialchars($autor) ?>">
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-search me-1"></i>Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($buscaRealizada): ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 fw-bold mb-0">Resultados para "<span class="text-dark"><?= htmlspecialchars($autor) ?></span>"</h2>
        <span class="badge bg-info text-dark"><?= count($livros) ?> livro(s) encontrado(s)</span>
    </div>

    <div class="card main-card bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Capa</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Ano</th>
                        <th class="text-center pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td class="ps-4 text-muted fw-medium">#<?= $livro->id ?></td>
                        <td>
                            <?php
                                $caminhoImagem = !empty($livro->imagem)
                                    ? '../assets/img/livros/' . htmlspecialchars($livro->imagem)
                                    : '../assets/img/livros/livro_padrao.png';
                            ?>
                            <img src="<?= $caminhoImagem ?>"
                                 class="livro-img-table"
                                 alt="Capa do livro"
                                 onerror="this.onerror=null;this.src='../assets/img/livros/livro_padrao.png';">
                        </td>
                        <td><span class="fw-bold text-dark"><?= htmlspecialchars($livro->titulo) ?></span></td>
                        <td><?= htmlspecialchars($livro->autor) ?></td>
                        <td class="ano-col"><?= (int) $livro->ano ?></td>
                        <td class="text-center pe-4">
                            <div class="btn-group btn-group-sm rounded-3 overflow-hidden shadow-sm">
                                <a href="alterar.php?id=<?= $livro->id ?>" class="btn btn-editar" title="Alterar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button type="button" class="btn btn-excluir" title="Excluir"
                                        onclick="confirmarExclusao(<?= $livro->id ?>, '<?= htmlspecialchars(addslashes($livro->titulo)) ?>')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($livros)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4 empty-state">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <p class="mb-0">Nenhum livro encontrado para este autor.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/pages/listar.js"></script>
<script src="../assets/js/global.js"></script>

</body>
</html>
