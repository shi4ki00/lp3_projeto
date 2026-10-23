<?php

class usuarioController
{

    private $model;

    public function __construct()
    {
        $this->model = new Usuario();
    }

    public function index()
    {

        $usuarios = $this->model->listar();
        require_once __DIR__ . '/../views/usuarios/index.php';
    }

    public function adicionar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            if ($nome && $email) {

                $this->model->salvar($nome, $email);

                header('Location: /lp3_projeto/usuarios');
                exit;
            }
        }

        require_once __DIR__ . '/../views/usuarios/criar.php';
    }

    public function editar()
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {

            header('Location: /lp3_projeto/usuarios');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            if ($nome && $email) {

                $this->model->atualizar($nome, $email, $id);

                header('Location: /lp3_projeto/usuarios');
                exit;
            }
        }


        $usuario = $this->model->buscarPorId($id);

        if (!$usuario) {
            header('Location: /lp3_projeto/usuarios');
            exit;
        }

        require_once __DIR__ . '/../views/usuarios/editar.php';
    }

    public function excluir()
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {

            $this->model->excluir($id);
        }

        header('Location: /lp3_projeto/usuarios');
        exit;
    }
}
