<?php

require_once __DIR__ . '/../config/Database.php';

class Cliente
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar()
    {
        $stnt = $this->db->query("SELECT * FROM clientes ORDER BY id DESC");
        return $stnt->fetchAll();
    }

    public function salvar(string $nome, string $email, string $cpf, ?float $salario, string $sexo, ?string $data, string $obs)
    {
        $sql = "INSERT INTO clientes (nome, email, cpf, salario, sexo, data, obs)
                VALUES (:nome, :email, :cpf, :salario, :sexo, :data, :obs)";
        $stnt = $this->db->prepare($sql);

        return $stnt->execute([
            'nome' => $nome,
            'email' => $email,
            'cpf' => $cpf,
            'salario' => $salario,
            'sexo' => $sexo,
            'data' => $data,
            'obs' => $obs
        ]);
    }

    public function atualizar(string $nome, string $email, string $cpf, ?float $salario, string $sexo, ?string $data, string $obs, int $id)
    {
        $sql = "UPDATE clientes SET
                    nome = :nome,
                    email = :email,
                    cpf = :cpf,
                    salario = :salario,
                    sexo = :sexo,
                    data = :data,
                    obs = :obs
                WHERE id = :id";
        $stnt = $this->db->prepare($sql);

        return $stnt->execute([
            'nome' => $nome,
            'email' => $email,
            'cpf' => $cpf,
            'salario' => $salario,
            'sexo' => $sexo,
            'data' => $data,
            'obs' => $obs,
            'id' => $id
        ]);
    }

    public function buscarPorId(int $id)
    {
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stnt = $this->db->prepare($sql);
        $stnt->execute(['id' => $id]);
        return $stnt->fetch();
    }

    public function excluir(int $id)
    {
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stnt = $this->db->prepare($sql);
        return $stnt->execute(['id' => $id]);
    }
}
