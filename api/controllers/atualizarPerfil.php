<?php

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../middleware/verificador.php';

VerificarLogin();

$id_usuario = $_SESSION['id_usuario'];
$acao       = $_POST['acao'] ?? '';

if (empty($acao))
{
    header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Ação não informada! (╥﹏╥)'));
    exit;
}

if ($acao === 'foto')
{
    processarFoto($con, $id_usuario);
}
elseif ($acao === 'dados')
{
    processarDados($con, $id_usuario);
}
elseif ($acao === 'senha')
{
    processarSenha($con, $id_usuario);
}
else
{
    header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Ação inválida! (º _ º)'));
    exit;
}

function processarFoto(mysqli $con, int $id_usuario): void
{
    $foto = $_POST['url_imagem'] ?? '';
    $foto = trim($foto);

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK)
    {
        $arquivo = $_FILES['foto'];
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $nomeArquivo = 'perfil_' . $id_usuario . '_' . uniqid() . '.' . $extensao;
        $caminhoDestino = __DIR__ . '/../../public/assets/img/usuarios/' . $nomeArquivo;

        if (move_uploaded_file($arquivo['tmp_name'], $caminhoDestino))
        {
            $foto = $nomeArquivo;
        }
        else
        {
            header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Erro ao fazer upload da imagem! (>:-<)'));
            exit;
        }
    }

    if (empty($foto))
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Informe uma imagem! (>:-<)'));
        exit;
    }

    $sql  = 'UPDATE usuarios SET foto_perfil = ? WHERE id = ?';
    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Erro interno ao atualizar foto! (╥﹏╥)'));
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'si', $foto, $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['foto_perfil'] = $foto;

    header('Location: ../../public/pages/perfil.php?status=sucesso');
    exit;
}

function processarDados(mysqli $con, int $id_usuario): void
{
    $novoLogin = trim($_POST['login'] ?? '');

    if (empty($novoLogin))
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Informe o nome de usuário! (>:-<)'));
        exit;
    }

    $sqlCheck  = 'SELECT id FROM usuarios WHERE login = ? AND id <> ? LIMIT 1';
    $stmtCheck = mysqli_prepare($con, $sqlCheck);

    if (!$stmtCheck)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Erro interno ao verificar usuário! (╥﹏╥)'));
        exit;
    }

    mysqli_stmt_bind_param($stmtCheck, 'si', $novoLogin, $id_usuario);
    mysqli_stmt_execute($stmtCheck);
    $resultado = mysqli_stmt_get_result($stmtCheck);
    $existe    = mysqli_num_rows($resultado) > 0;
    mysqli_stmt_close($stmtCheck);

    if ($existe)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Esse usuário já existe! Tente outro (・_・;)'));
        exit;
    }

    $sql  = 'UPDATE usuarios SET login = ? WHERE id = ?';
    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Erro interno ao atualizar dados! (╥﹏╥)'));
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'si', $novoLogin, $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['login'] = $novoLogin;

    header('Location: ../../public/pages/perfil.php?status=dados_atualizados');
    exit;
}

function processarSenha(mysqli $con, int $id_usuario): void
{
    $senhaAtual     = $_POST['senha_atual'] ?? '';
    $novaSenha      = $_POST['nova_senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_nova_senha'] ?? '';

    if (empty($senhaAtual) || empty($novaSenha) || empty($confirmarSenha))
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Preencha todos os campos de senha! (>:-<)'));
        exit;
    }

    if (strlen($novaSenha) < 4)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('A nova senha deve ter pelo menos 4 caracteres! (º _ º)'));
        exit;
    }

    if ($novaSenha !== $confirmarSenha)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('As senhas não coincidem! (╥﹏╥)'));
        exit;
    }

    $sql  = 'SELECT senha FROM usuarios WHERE id = ? LIMIT 1';
    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Erro interno ao verificar senha atual! (╥﹏╥)'));
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario   = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if (!$usuario || !password_verify($senhaAtual, $usuario['senha']))
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Senha atual incorreta! (x_x)'));
        exit;
    }

    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    $sql  = 'UPDATE usuarios SET senha = ? WHERE id = ?';
    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt)
    {
        header('Location: ../../public/pages/perfil.php?erro=' . urlencode('Erro interno ao alterar senha! (╥﹏╥)'));
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'si', $senhaHash, $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: ../../public/pages/perfil.php?status=senha_alterada');
    exit;
}
