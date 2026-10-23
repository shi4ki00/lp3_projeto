<?php

class ProdutoController
{
    private $model;

    public function __construct()
    {
        $this->model = new Produto();
    }

    public function index()
    {
        $produtos = $this->model->listar();
        require_once __DIR__ . '/../views/produtos/index.php';
    }

    public function adicionar()
    {
        $categorias = $this->model->listarCategorias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produto = filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_SPECIAL_CHARS);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
            $categoria_id = filter_input(INPUT_POST, 'categoria', FILTER_VALIDATE_INT);

            if ($produto !== '' && $valor !== '' && $descricao !== '' && (($categoria_id === null) || $categoria_id !== false)) {
                $this->model->salvar($produto, $valor, $descricao, $categoria_id);
                header('Location: /lp3_projeto/produtos');
                exit;
            }
        }

        require_once __DIR__ . '/../views/produtos/criar.php';
    }

    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /lp3_projeto/produtos');
            exit;
        }

        $produto = $this->model->buscarPorId($id);
        if (!$produto) {
            header('Location: /lp3_projeto/produtos');
            exit;
        }

        $categorias = $this->model->listarCategorias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['produto'] ?? '');
            $valor = trim($_POST['valor'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $categoria_id = ($_POST['categoria_id'] ?? '') !== '' ? filter_var($_POST['categoria_id'], FILTER_VALIDATE_INT) : null;

            if ($nome !== '' && $valor !== '' && $descricao !== '' && (($categoria_id === null) || $categoria_id !== false)) {
                $this->model->atualizar($nome, $valor, $descricao, $categoria_id, $id);
                header('Location: /lp3_projeto/produtos');
                exit;
            }
        }

        require_once __DIR__ . '/../views/produtos/editar.php';
    }

    public function excluir()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->model->excluir($id);
        }
        header('Location: /lp3_projeto/produtos');
        exit;
    }
}
