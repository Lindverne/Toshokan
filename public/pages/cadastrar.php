<?php

require_once __DIR__ . '/../../api/models/LivroORM.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $ano = isset($_POST['ano']) ? (int) $_POST['ano'] : 0;
    $imagem = null;
    $pdf = null;

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
                $livro = new Livro(null, $titulo, $autor, $ano, $imagem, $pdf);
                $orm = new LivroORM();
                $orm->cadastrar($livro);
                header('Location: listar.php?status=cadastrado');
                exit;
            }
            catch (Throwable $e)
            {
                $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
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
    <title>Cadastrar Livro | Toshokan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/pages/cadastrar.css">
</head>
<body data-erro="<?= htmlspecialchars($erro) ?>">

<div class="container mt-4">

    <div class="hero-card p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark m-0">Cadastrar Livro</h1>
            <p class="text-muted small m-0">Adicione um novo livro à biblioteca! (>=<)</p>
        </div>

        <?php include __DIR__ . '/../components/header_usuario.php'; ?>
    </div>

    <div class="mb-4">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fa-solid fa-circle-plus text-success me-2"></i>Cadastrar Livro
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listar.php">
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
        <form method="POST" action="cadastrar.php" id="formCadastro" enctype="multipart/form-data">

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
                               placeholder="Ex: Dom Casmurro" required maxlength="100"
                               value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="autor">Autor</label>
                        <input type="text" class="form-control" name="autor" id="autor"
                               placeholder="Ex: Machado de Assis" required maxlength="100"
                               value="<?= htmlspecialchars($_POST['autor'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="ano">Ano de Publicação</label>
                        <input type="number" class="form-control" name="ano" id="ano"
                               placeholder="Ex: 1899" required min="0" max="2026"
                               value="<?= htmlspecialchars($_POST['ano'] ?? '') ?>">
                        <div class="form-text text-muted">Ano entre 0 e 2026.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="capaLivro">Capa do Livro (opcional)</label>
                        <input type="file" class="d-none" name="capa_livro" id="capaLivro" accept="image/*">
                        <input type="hidden" name="url_imagem" id="urlImagem" value="">
                        <button type="button" class="btn btn-outline-primary rounded-3 px-4 w-100" data-bs-toggle="modal" data-bs-target="#imageModal">
                            <i class="fa-solid fa-image me-2"></i>Escolher Imagem
                        </button>
                        <span id="file-status-text" class="text-muted small ms-2 d-block mt-2">Nenhuma imagem selecionada</span>
                        <div class="text-center mt-3" id="previewCapaContainer" style="display: none;">
                            <img src="" id="previewCapaImg" class="preview-box" alt="Pré-visualização da capa">
                        </div>
                        <div class="form-text text-muted">Formatos aceitos: JPG, PNG, WEBP. Máx. 2MB.</div>
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
                        <p class="text-muted small mb-0">Preencha os dados do livro para adicioná-lo à sua biblioteca.</p>
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
                <button type="submit" class="btn btn-cadastrar">
                    <i class="fa-solid fa-save me-1"></i>Cadastrar Livro
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
    const previewContainer = document.getElementById('previewCapaContainer');
    const previewImg = document.getElementById('previewCapaImg');
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

    const formCadastro = document.getElementById('formCadastro');
    if (formCadastro)
    {
        formCadastro.addEventListener('submit', function (e)
        {
            e.preventDefault();
            Swal.fire({
                title: 'Cadastrar este livro? 📚',
                text: 'O livro será adicionado à sua biblioteca.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#261834',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, cadastrar!',
                cancelButtonText: 'Cancelar',
                customClass: { popup: 'rounded-4 shadow-lg' }
            }).then(res =>
            {
                if (res.isConfirmed)
                {
                    formCadastro.submit();
                }
            });
        });
    }
});
</script>

</body>
</html>
