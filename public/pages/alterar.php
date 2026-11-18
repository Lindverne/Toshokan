<?php

require_once __DIR__ . '/../../api/models/LivroORM.php';

$orm = new LivroORM();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0)
{
    header('Location: listar.php?erro=ID inválido!');
    exit;
}

$livro = $orm->buscarPorId($id);

if (!$livro)
{
    header('Location: listar.php?erro=Livro não encontrado!');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $ano = isset($_POST['ano']) ? (int) $_POST['ano'] : 0;
    $imagem = $livro->imagem;
    $pdf = $livro->pdf;

    if ($titulo === '' || $autor === '')
    {
        $erro = 'Título e autor são obrigatórios!';
    }
    elseif ($ano < 0 || $ano > 2026)
    {
        $erro = 'Informe um ano válido entre 0 e 2026!';
    }
    else
    {
        if (isset($_FILES['capa_livro']) && $_FILES['capa_livro']['error'] === UPLOAD_ERR_OK)
        {
            $arquivo = $_FILES['capa_livro'];
            $nomeArquivo = uniqid('livro_', true) . '.' . pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $caminhoDestino = __DIR__ . '/../../public/assets/img/livros/' . $nomeArquivo;

            if (move_uploaded_file($arquivo['tmp_name'], $caminhoDestino))
            {
                $imagem = $nomeArquivo;
            }
            else
            {
                $erro = 'Erro ao fazer upload da imagem!';
            }
        }
        elseif ($erro === '' && !empty(trim($_POST['url_imagem'] ?? '')))
        {
            $imagem = trim($_POST['url_imagem']);
        }

        if (isset($_FILES['arquivo_pdf']) && $_FILES['arquivo_pdf']['error'] === UPLOAD_ERR_OK)
        {
            $arquivo = $_FILES['arquivo_pdf'];
            $nomeArquivo = uniqid('livro_', true) . '.pdf';
            $caminhoDestino = __DIR__ . '/../../public/assets/pdf/livros/' . $nomeArquivo;

            if (move_uploaded_file($arquivo['tmp_name'], $caminhoDestino))
            {
                $pdf = $nomeArquivo;
            }
            else
            {
                $erro = 'Erro ao fazer upload do PDF!';
            }
        }

        if ($erro === '')
        {
            try
            {
                $livroAtualizado = new Livro($id, $titulo, $autor, $ano, $imagem, $pdf);
                $orm->alterar($livroAtualizado);
                header('Location: listar.php?status=atualizado');
                exit;
            }
            catch (Throwable $e)
            {
                $erro = 'Erro ao alterar: ' . htmlspecialchars($e->getMessage());
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../assets/img/favicon/favicon.ico">
    <title>Alterar Livro | Toshokan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/pages/alterar.css">
</head>
<body data-erro="<?= htmlspecialchars($erro) ?>">

<div class="container mt-4">

    <div class="hero-card p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark m-0">Alterar Livro</h1>
            <p class="text-muted small m-0">Atualize as informações do livro (ノ°∀°)ノ</p>
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

    <div class="card form-card p-4">
        <form method="POST" action="alterar.php?id=<?= $livro->id ?>" id="formEditar" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $livro->id ?>">

            <?php if ($erro !== ''): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($erro) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="mb-3">
                        <label class="form-label" for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" id="titulo"
                               placeholder="Digite o título do livro" required maxlength="100"
                               value="<?= htmlspecialchars($livro->titulo) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="autor">Autor</label>
                        <input type="text" class="form-control" name="autor" id="autor"
                               placeholder="Digite o nome do autor" required maxlength="100"
                               value="<?= htmlspecialchars($livro->autor) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="ano">Ano de Publicação</label>
                        <input type="number" class="form-control" name="ano" id="ano"
                               placeholder="Ano de publicação" required min="0" max="2026"
                               value="<?= htmlspecialchars($livro->ano) ?>">
                        <div class="form-text text-muted">Ano entre 0 e 2026.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="capaLivro">Capa do Livro (opcional)</label>
                        <?php if (!empty($livro->imagem)): ?>
                        <div class="text-center mb-2">
                            <img src="../assets/img/livros/<?= htmlspecialchars($livro->imagem) ?>"
                                 class="preview-atual" id="previewCapaAtual" alt="Capa atual"
                                 onerror="this.onerror=null;this.src='../assets/img/livros/livro_padrao.png';">
                        </div>
                        <p class="text-muted small mt-1">Imagem atual</p>
                        <?php endif; ?>
                        <input type="file" class="d-none" name="capa_livro" id="capaLivro" accept="image/*">
                        <input type="hidden" name="url_imagem" id="urlImagem" value="">
                        <button type="button" class="btn btn-outline-primary rounded-3 px-4 w-100" data-bs-toggle="modal" data-bs-target="#imageModal">
                            <i class="fa-solid fa-image me-2"></i>Escolher Imagem
                        </button>
                        <span id="file-status-text" class="text-muted small ms-2 d-block mt-2">Nenhuma imagem selecionada</span>
                        <div class="text-center mt-3" id="previewNovaCapaContainer" style="display: none;">
                            <img src="" id="previewNovaCapaImg" class="preview-box" alt="Nova capa">
                        </div>
                        <div class="form-text text-muted">Deixe em branco para manter a capa atual. Formatos: JPG, PNG, WEBP. Máx. 2MB.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="arquivoPdf">PDF do Livro (opcional)</label>
                        <input type="file" class="form-control" name="arquivo_pdf" id="arquivoPdf" accept="application/pdf">
                        <div class="form-text text-muted">Somente arquivos PDF. Máx. 10MB.</div>
                    </div>
                </div>

                <div class="col-md-5 d-flex flex-column justify-content-start">
                    <div class="text-center guias-livro mt-5">
                        <i class="fa-solid fa-book fs-1 text-muted mb-3"></i>
                        <p class="text-muted small mb-0">Edite as informações do livro e salve as alterações.</p>
                    </div>
                    <div class="mt-auto pt-4">
                        <small class="text-muted d-block mb-2">Dicas:</small>
                        <ul class="list-unstyled text-muted small">
                            <li><i class="fa-solid fa-check text-success me-2"></i>O título é obrigatório</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Informe o autor do livro</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>O ano deve ser entre 0 e 2026</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>A capa é opcional</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <a href="listar.php" class="btn btn-voltar">
                    <i class="fa-solid fa-arrow-left me-1"></i>Voltar
                </a>
                <button type="submit" class="btn btn-salvar">
                    <i class="fa-solid fa-save me-1"></i>Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../components/modal_imagem.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script src="../assets/js/global.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function ()
{
    const inputCapa = document.getElementById('capaLivro');
    const previewContainer = document.getElementById('previewNovaCapaContainer');
    const previewImg = document.getElementById('previewNovaCapaImg');
    const statusText = document.getElementById('file-status-text');

    const dropZone = document.getElementById('dropZone');
    const imgUrlInput = document.getElementById('imgUrlInput');
    const btnApplyUrl = document.getElementById('btnApplyUrl');
    const hiddenUrlInput = document.getElementById('urlImagem');
    const imageModalEl = document.getElementById('imageModal');

    const imageModal = window.bootstrap?.Modal
        ? new bootstrap.Modal(imageModalEl)
        : null;

    const updateVisualPreview = (src, filename) =>
    {
        previewImg.src = src;
        previewContainer.style.display = 'block';
        statusText.textContent = filename;
        imageModal?.hide();
    };

    const processLocalFile = (file) =>
    {
        if (!file || !file.type.startsWith('image/')) return;

        hiddenUrlInput.value = '';

        const reader = new FileReader();
        reader.onload = (event) => updateVisualPreview(event.target.result, file.name);
        reader.readAsDataURL(file);
    };

    dropZone.addEventListener('click', () => inputCapa.click());

    inputCapa.addEventListener('change', function ()
    {
        const arquivo = this.files[0];
        if (arquivo)
        {
            processLocalFile(arquivo);
        }
        else
        {
            previewContainer.style.display = 'none';
        }
    });

    ['dragenter', 'dragover'].forEach((type) =>
    {
        dropZone.addEventListener(type, (e) =>
        {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach((type) =>
    {
        dropZone.addEventListener(type, (e) =>
        {
            e.preventDefault();
            dropZone.classList.remove('dragover');
        });
    });

    dropZone.addEventListener('drop', (event) =>
    {
        const files = event.dataTransfer.files;
        if (!files.length) return;
        inputCapa.files = files;
        processLocalFile(files[0]);
    });

    btnApplyUrl.addEventListener('click', () =>
    {
        const url = imgUrlInput.value.trim();
        if (!url) return;

        inputCapa.value = '';
        hiddenUrlInput.value = url;

        updateVisualPreview(url, 'Imagem vinculada via URL');
    });

    const formEditar = document.getElementById('formEditar');
    if (formEditar)
    {
        formEditar.addEventListener('submit', function (e)
        {
            e.preventDefault();
            Swal.fire({
                title: 'Salvar alterações? 📝',
                text: 'As informações do livro serão atualizadas.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#261834',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, salvar!',
                cancelButtonText: 'Cancelar',
                customClass: { popup: 'rounded-4 shadow-lg' }
            }).then(res =>
            {
                if (res.isConfirmed)
                {
                    formEditar.submit();
                }
            });
        });
    }
});
</script>

</body>
</html>
