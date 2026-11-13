<?php

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

require_once __DIR__ . '/../middleware/verificador.php';
VerificarLogin();

header('Content-Type: application/json; charset=UTF-8');

$url = $_GET['url'] ?? '';

if (empty($url))
{
    http_response_code(400);
    echo json_encode(['erro' => 'URL não fornecida']);
    exit;
}

$parsedUrl = parse_url($url);
if (!$parsedUrl || !in_array($parsedUrl['scheme'] ?? '', ['http', 'https']))
{
    http_response_code(400);
    echo json_encode(['erro' => 'URL inválida']);
    exit;
}

$pastaDestino = __DIR__ . '/../../public/assets/img/livros/';

if (!is_dir($pastaDestino))
{
    mkdir($pastaDestino, 0755, true);
}

$ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
$ext = in_array(strtolower($ext ?? ''), ['jpg', 'jpeg', 'png', 'webp', 'gif']) ? strtolower($ext) : 'jpg';

$nomeArquivo = uniqid('livro_', true) . '.' . $ext;
$caminhoCompleto = $pastaDestino . $nomeArquivo;

$conteudo = @file_get_contents($url);
if ($conteudo === false)
{
    http_response_code(422);
    echo json_encode(['erro' => 'Não foi possível baixar a imagem da URL fornecida']);
    exit;
}

if (@file_put_contents($caminhoCompleto, $conteudo) === false)
{
    http_response_code(422);
    echo json_encode(['erro' => 'Não foi possível salvar a imagem baixada']);
    exit;
}

$caminhoRelativo = '../assets/img/livros/' . $nomeArquivo;

echo json_encode([
    'sucesso' => true,
    'caminho' => $caminhoRelativo,
    'arquivo' => $nomeArquivo,
]);
exit;
