<?php

require_once __DIR__ . '/../config/Database.php';

class Filme
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar()
    {
        return $this->db->query('SELECT * FROM filmes ORDER BY id DESC')->fetchAll();
    }

    public function salvar(string $filme, string $diretor, ?int $duracao, ?string $imagem)
    {
        $sql = 'INSERT INTO filmes (filme, diretor, duracao, imagem)
                VALUES (:filme, :diretor, :duracao, :imagem)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'filme' => $filme,
            'diretor' => $diretor,
            'duracao' => $duracao,
            'imagem' => $imagem
        ]);
    }

    public function atualizar(string $filme, string $diretor, ?int $duracao, ?string $imagem, int $id)
    {
        $sql = 'UPDATE filmes
                SET filme = :filme, diretor = :diretor, duracao = :duracao, imagem = :imagem
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'filme' => $filme,
            'diretor' => $diretor,
            'duracao' => $duracao,
            'imagem' => $imagem,
            'id' => $id
        ]);
    }

    public function buscarPorId(int $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM filmes WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function excluir(int $id)
    {
        $stmt = $this->db->prepare('DELETE FROM filmes WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
