<?php

require_once __DIR__ . '/../config/Database.php';

class Fornecedor
{
    private $db;
    private $tabela = "fornecedores";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar()
    {
        $stmt = $this->db->query("select * from $this->tabela order by id asc");
        return $stmt->fetchAll();
    }

    public function salvar(
        string $razao_social,
        string $email,
        string $telefone,
        string $cnpj,
        string $endereco,
        bool $ativo
    ) {
        $sql = "insert into $this->tabela (razao_social, cnpj, telefone, email, endereco, ativo) values (:razao_social, :cnpj, :telefone, :email, :endereco, :ativo)";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':razao_social' => $razao_social,
            ':cnpj' => $cnpj,
            ':telefone' => $telefone,
            ':endereco' => $endereco,
            ':email' => $email,
            ':ativo' => $ativo
        ];
        return $stmt->execute($values);
    }

    public function buscarPorId(int $id)
    {
        $sql = "select * from $this->tabela where id = :id";
        $stmt = $this->db->prepare($sql);
        $values = [':id' => $id];
        $stmt->execute($values);
        return $stmt->fetch();
    }

    public function atualizar(int $id, string $razao_social, string $email, string $telefone, string $cnpj, string $endereco, bool $ativo)
    {
        $sql = "update $this->tabela set razao_social=:razao_social, email=:email, telefone=:telefone, cnpj=:cnpj, endereco=:endereco, ativo=:ativo where id=:id";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':razao_social' => $razao_social,
            ':cnpj' => $cnpj,
            ':telefone' => $telefone,
            ':endereco' => $endereco,
            ':email' => $email,
            ':ativo' => $ativo,
            ':id' => $id
        ];
        return $stmt->execute($values);
    }

    public function excluir(int $id)
    {
        $sql = "delete from $this->tabela where id = :id";
        $stmt = $this->db->prepare($sql);
        $values = [':id' => $id];
        return $stmt->execute($values);
    }
}
