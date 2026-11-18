<?php

require __DIR__ . '/../../api/middleware/verificador.php';
VerificarLogin();

require_once __DIR__ . '/../../api/models/LivroORM.php';

$orm       = new LivroORM();
$busca     = $_GET['busca'] ?? '';
$filtro_ord = $_GET['filtro_ord'] ?? '';
$status    = $_GET['status'] ?? '';
$erro      = $_GET['erro'] ?? '';

$itensPorPagina = 8;
$paginaAtual    = max(1, (int)($_GET['pagina'] ?? 1));

$totalRegistros = $orm->contarTotal($busca);
$totalPaginas   = max(1, (int) ceil($totalRegistros / $itensPorPagina));
$paginaAtual    = min($paginaAtual, $totalPaginas);

$livros = $orm->listarPaginado($paginaAtual, $itensPorPagina, $busca, $filtro_ord);

function gerarUrlPagina(int $pagina): string
{
    $p           = $_GET;
    $p['pagina'] = $pagina;
    return '?' . http_build_query($p);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../assets/img/favicon/favicon.ico">
    <title>Listagem | Toshokan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/pages/listar.css">
</head>
<body data-status="<?= htmlspecialchars($status) ?>"
      data-erro="<?= htmlspecialchars($erro) ?>">

<div class="container mt-4">

    <div class="hero-card p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark m-0">Livros</h1>
            <p class="text-muted small m-0">Gerencie sua biblioteca (⌒‿⌒)</p>
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
                <a class="nav-link active" href="#">
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

    <div class="row g-2 align-items-center mb-4">
        <div class="col-md-7 col-12">
            <form method="GET" action="listar.php" class="row g-2 justify-content-md-end align-items-center search-form">
                <div class="col-sm-5 col-6">
                    <input type="text" name="busca"
                           class="form-control form-control-sm border rounded-3"
                           placeholder="🔍 Buscar por título ou autor..."
                           value="<?= htmlspecialchars($busca) ?>">
                </div>
                <div class="col-sm-4 col-12">
                    <select name="filtro_ord" class="form-select form-select-sm border rounded-3">
                        <option value="">Ordenar por...</option>
                        <option value="ano_desc" <?= $filtro_ord === 'ano_desc' ? 'selected' : '' ?>>Ano (recente)</option>
                        <option value="ano_asc" <?= $filtro_ord === 'ano_asc' ? 'selected' : '' ?>>Ano (antigo)</option>
                        <option value="titulo_asc" <?= $filtro_ord === 'titulo_asc' ? 'selected' : '' ?>>Título (A-Z)</option>
                    </select>
                </div>
                <div class="col-sm-3 col-12 d-grid">
                    <button type="submit" class="btn btn-sm btn-primary text-white rounded-3 btn-filtro">
                        <i class="fa-solid fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
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
                    <?php if (empty($livros)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4 empty-state">
                            <i class="fa-solid fa-book"></i>
                            <p class="mb-0">Nenhum livro cadastrado.</p>
                        </td>
                    </tr>
                    <?php else: ?>
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
                                 style="cursor: pointer;"
                                 onclick="abrirZoomLivro('<?= $caminhoImagem ?>')"
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
                                <?php if (!empty($livro->pdf)): ?>
                                <a href="visualizar.php?id=<?= $livro->id ?>" class="btn btn-pdf" title="Ler PDF">
                                    <i class="fa-solid fa-book-open-reader"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($totalPaginas > 1): ?>
    <nav aria-label="Navegação de páginas" class="mt-4 mb-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $paginaAtual <= 1 ? 'disabled' : '' ?>">
                <a class="page-link rounded-start-3" href="<?= gerarUrlPagina($paginaAtual - 1) ?>">
                    <i class="fa-solid fa-chevron-left fa-xs"></i>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <li class="page-item <?= $paginaAtual === $i ? 'active' : '' ?>">
                <a class="page-link" href="<?= gerarUrlPagina($i) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= $paginaAtual >= $totalPaginas ? 'disabled' : '' ?>">
                <a class="page-link rounded-end-3" href="<?= gerarUrlPagina($paginaAtual + 1) ?>">
                    <i class="fa-solid fa-chevron-right fa-xs"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/pages/listar.js"></script>
<script src="../assets/js/global.js"></script>

<div class="modal fade" id="modalLivroZoom" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; background: #ffffff; overflow: hidden;">
            <div class="modal-body text-center d-flex align-items-center justify-content-center" style="background:#ffffff; padding: 1.5rem 1rem;">
                <img id="modalLivroImg" src="" alt="Capa ampliada"
                     style="max-width:85%; max-height:60vh; object-fit:contain; border-radius: 12px;">
            </div>
            <div class="modal-footer border-0 justify-content-center" style="background:#ffffff; padding: 1.5rem 2rem;">
                <button type="button" class="btn btn-light rounded-3 px-4"
                        data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
