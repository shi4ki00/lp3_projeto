<?php

require_once __DIR__ . '/../config/Database.php';

class Produto
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar()
    {
        $sql = "SELECT p.*, c.categoria AS nome_categoria
                FROM produtos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function listarCategorias()
    {
        return $this->db->query("SELECT * FROM categorias ORDER BY categoria ASC")->fetchAll();
    }

    public function salvar(string $produto, string $valor, string $descricao, ?int $categoria_id)
    {
        $sql = "INSERT INTO produtos (produto, valor, descricao, categoria_id)
                VALUES (:produto, :valor, :descricao, :categoria_id)";
        $stnt = $this->db->prepare($sql);
        return $stnt->execute([
            'produto' => $produto,
            'valor' => $valor,
            'descricao' => $descricao,
            'categoria_id' => $categoria_id
        ]);
    }

    public function atualizar(string $produto, string $valor, string $descricao, ?int $categoria_id, int $id)
    {
        $sql = "UPDATE produtos
                SET produto = :produto, valor = :valor, descricao = :descricao, categoria_id = :categoria_id
                WHERE id = :id";
        $stnt = $this->db->prepare($sql);
        return $stnt->execute([
            'produto' => $produto,
            'valor' => $valor,
            'descricao' => $descricao,
            'categoria_id' => $categoria_id,
            'id' => $id
        ]);
    }

    public function buscarPorId(int $id)
    {
        $stnt = $this->db->prepare("SELECT * FROM produtos WHERE id = :id");
        $stnt->execute(['id' => $id]);
        return $stnt->fetch();
    }

    public function excluir(int $id)
    {
        $stnt = $this->db->prepare("DELETE FROM produtos WHERE id = :id");
        return $stnt->execute(['id' => $id]);
    }
}
