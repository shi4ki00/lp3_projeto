    <?php

    require_once __DIR__ . '/../config/Database.php';

    class Usuario
    {

        private $db;

        public function __construct()
        {
            $this->db = Database::getConnection();
        }

        public function listar()
        {

            $stnt = $this->db->query("select * from usuarios order by id desc");

            return $stnt->fetchALL();
        }

        public function salvar(string $nome, string $email)
        {

            $sql = "insert into usuarios (nome, email) values (:nome, :email)";
            $stnt = $this->db->prepare($sql);
            $values = [

                "nome" => $nome,
                "email" => $email

            ];

            return $stnt->execute($values);
        }

        public function atualizar(string $nome, string $email, int $id)
        {

            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $stnt = $this->db->prepare($sql);
            $values = [

                "nome" => $nome,
                "email" => $email,
                "id" => $id

            ];

            return $stnt->execute($values);
        }

        public function buscarPorId(int $id)
        {

            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stnt = $this->db->prepare($sql);

            $values = ["id" => $id];

            $stnt->execute($values);
            return $stnt->fetch();
        }

        public function excluir(int $id)
        {

            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stnt = $this->db->prepare($sql);

            $values = ["id" => $id];

            return $stnt->execute($values);
        }
    }
