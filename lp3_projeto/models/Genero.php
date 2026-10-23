<?php
require_once __DIR__ . '/../config/Database.php';

class Genero
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar()
    {
        return $this->db->query("SELECT * FROM generos ORDER BY nome ASC")->fetchAll();
    }

    public function salvar(string $nome, ?string $descricao)
    {
        $stmt = $this->db->prepare("INSERT INTO generos (nome, descricao) VALUES (:nome, :descricao)");
        return $stmt->execute(['nome' => $nome, 'descricao' => $descricao]);
    }

    public function buscarPorId(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM generos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function atualizar(string $nome, ?string $descricao, int $id)
    {
        $stmt = $this->db->prepare("UPDATE generos SET nome = :nome, descricao = :descricao WHERE id = :id");
        return $stmt->execute(['nome' => $nome, 'descricao' => $descricao, 'id' => $id]);
    }

    public function excluir(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM generos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
