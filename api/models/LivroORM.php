<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/Livro.php';

class LivroORM
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        return $this->listarPaginado(1, PHP_INT_MAX);
    }

    public function contarTotal(string $busca = ''): int
    {
        $sql = 'SELECT COUNT(*) as total FROM livros WHERE 1=1';
        $params = [];
        if (!empty($busca))
        {
            $sql .= ' AND (titulo LIKE ? OR autor LIKE ?)';
            $params = ["%{$busca}%", "%{$busca}%"];
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function listarPaginado(int $pagina, int $itensPorPagina, string $busca = '', string $ordem = ''): array
    {
        $sql = 'SELECT id, titulo, autor, ano, imagem, pdf FROM livros WHERE 1=1';
        $params = [];
        if (!empty($busca))
        {
            $sql .= ' AND (titulo LIKE ? OR autor LIKE ?)';
            $params = ["%{$busca}%", "%{$busca}%"];
        }
        if ($ordem === 'ano_asc')
        {
            $sql .= ' ORDER BY ano ASC';
        }
        elseif ($ordem === 'ano_desc')
        {
            $sql .= ' ORDER BY ano DESC';
        }
        elseif ($ordem === 'titulo_asc')
        {
            $sql .= ' ORDER BY titulo ASC';
        }
        else
        {
            $sql .= ' ORDER BY id DESC';
        }
        $sql .= ' LIMIT ? OFFSET ?';
        $params[] = $itensPorPagina;
        $params[] = ($pagina - 1) * $itensPorPagina;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $livros = [];
        foreach ($rows as $row)
        {
            $livros[] = new Livro($row['id'], $row['titulo'], $row['autor'], $row['ano'], $row['imagem'] ?? null, $row['pdf'] ?? null);
        }
        return $livros;
    }

    public function cadastrar($livro)
    {
        $stmt = $this->pdo->prepare('INSERT INTO livros (titulo, autor, ano, imagem, pdf) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$livro->titulo, $livro->autor, $livro->ano, $livro->imagem ?? null, $livro->pdf ?? null]);
        $livro->id = $this->pdo->lastInsertId();
    }

    public function alterar($livro)
    {
        $stmt = $this->pdo->prepare('UPDATE livros SET titulo = ?, autor = ?, ano = ?, imagem = ?, pdf = ? WHERE id = ?');
        $stmt->execute([$livro->titulo, $livro->autor, $livro->ano, $livro->imagem ?? null, $livro->pdf ?? null, $livro->id]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM livros WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare('SELECT id, titulo, autor, ano, imagem, pdf FROM livros WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row)
        {
            return null;
        }
        return new Livro($row['id'], $row['titulo'], $row['autor'], $row['ano'], $row['imagem'] ?? null, $row['pdf'] ?? null);
    }

    public function buscarPorAutor($autor)
    {
        $stmt = $this->pdo->prepare('SELECT id, titulo, autor, ano, imagem FROM livros WHERE autor LIKE ? ORDER BY id DESC');
        $stmt->execute(["%{$autor}%"]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $livros = [];
        foreach ($rows as $row)
        {
            $livros[] = new Livro($row['id'], $row['titulo'], $row['autor'], $row['ano'], $row['imagem'] ?? null);
        }
        return $livros;
    }
}
