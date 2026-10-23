<?php
class GeneroController
{
    private $model;

    public function __construct()
    {
        $this->model = new Genero();
    }

    public function index()
    {
        $generos = $this->model->listar();
        require __DIR__ . '/../views/generos/index.php';
    }

    public function adicionar()
    {
        $erro = '';
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($nome === '') {
                $erro = 'Informe o nome do gênero.';
            } else {
                try {
                    $this->model->salvar($nome, $descricao !== '' ? $descricao : null);
                    header('Location: /lp3_projeto/generos'); exit;
                } catch (PDOException $e) {
                    $erro = $e->getCode() === '23000' ? 'Já existe um gênero com esse nome.' : 'Não foi possível salvar o gênero.';
                }
            }
        }
        require __DIR__ . '/../views/generos/criar.php';
    }

    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $genero = $id ? $this->model->buscarPorId($id) : false;
        if (!$genero) { header('Location: /lp3_projeto/generos'); exit; }
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            if ($nome === '') { $erro = 'Informe o nome do gênero.'; }
            else {
                try {
                    $this->model->atualizar($nome, $descricao !== '' ? $descricao : null, (int)$id);
                    header('Location: /lp3_projeto/generos'); exit;
                } catch (PDOException $e) {
                    $erro = $e->getCode() === '23000' ? 'Já existe um gênero com esse nome.' : 'Não foi possível atualizar o gênero.';
                }
            }
            $genero['nome'] = $nome;
            $genero['descricao'] = $descricao;
        }
        require __DIR__ . '/../views/generos/editar.php';
    }

    public function excluir()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) $this->model->excluir((int)$id);
        header('Location: /lp3_projeto/generos'); exit;
    }
}
