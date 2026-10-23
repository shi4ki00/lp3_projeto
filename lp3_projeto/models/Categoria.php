<?php

require_once __DIR__ . '/../config/Database.php';

class Categoria
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar()
    {

        $stnt = $this->db->query("select * from categorias order by id desc");

        return $stnt->fetchALL();
    }

    public function salvar(string $categoria, string $descricao)
        {

            $sql = "insert into categorias (categoria, descricao) values (:categoria, :descricao)";
            $stnt = $this->db->prepare($sql);
            $values = [

                "categoria" => $categoria,
                "descricao" => $descricao

            ];

            return $stnt->execute($values);
        }

        public function atualizar(string $categoria, string $descricao, int $id)
        {

            $sql = "UPDATE categorias SET categoria = :categoria, descricao = :descricao WHERE id = :id";
            $stnt = $this->db->prepare($sql);
            $values = [

                "categoria" => $categoria,
                "descricao" => $descricao,
                "id" => $id

            ];

            return $stnt->execute($values);
        }

        public function buscarPorId(int $id)
        {

            $sql = "SELECT * FROM categorias WHERE id = :id";
            $stnt = $this->db->prepare($sql);

            $values = ["id" => $id];

            $stnt->execute($values);
            return $stnt->fetch();
        }

        public function excluir(int $id)
        {

            $sql = "DELETE FROM categorias WHERE id = :id";
            $stnt = $this->db->prepare($sql);

            $values = ["id" => $id];

            return $stnt->execute($values);
        }
    
}
